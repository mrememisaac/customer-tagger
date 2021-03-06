<?php

namespace App\Http\Helpers;

use Infusionsoft;
use Log;
use Storage;
use Cache;
use Request;
use \App\Tag;
use \App\User;
use App\Contact;
use \App\Course;
use \App\Module;
use \App\UserCompletedModule;
use App\Http\Interfaces\InfusionSoftHelperInterface;
use App\Http\Helpers\ApiResponse;

class ReminderTagger{

    private $infusionsoftHelper;

    public function __construct(InfusionSoftHelperInterface $helper = null){
        $this->infusionsoftHelper = $helper == null ? new MockInfusionsoftHelper() : $helper;
    } 


    /**
     * Returns courses bought by this customer
     * I brought this out to its own function because the way we get courses ie products might change, 
     */
    private function getCustomerCourses($customer){
        //returns array of strings
        // if($customer == null) {
        //     return null;
        // }
        // return $customer->courses;
        try
        {
            if($customer->_Products){
                return explode(',',$customer->_Products);
            }
        }catch(\Exception $e){
            Log::error($e->getMessage() . " on line " . __LINE__);
        }
    }

    private function apiResponse($msg, $successful, $code = null){
        return[
            'message' => $msg,
            'success' => $successful
        ];
    }

    public function setReminderTag($email){
        //check if customer object is null
        if($email == null){
            return $this->apiResponse(null, "Null customer sent", 404);
        }
        
        //check if customer exists in database using customer id
        $customer =  null;
        try{
            $customer = $this->infusionsoftHelper->getContact($email);
            if($customer){
                $customer =  new Contact($customer);
            }
        }catch(\Exception $e){
            Log::error($e->getMessage() . " on line " . __LINE__);
            return $this->apiResponse("An error occured " . $e->getMessage() . " on line " . __LINE__, false);
        }
        if($customer == null){
            return $this->apiResponse("Customer not found", false, 404);
        }

        $courses = null;
        try{        
            $courses = $this->getCustomerCourses($customer); //returns array of strings
        }catch(\Exception $e){
            Log::error($e->getMessage() . " on line " . __LINE__);
            return $this->apiResponse("An error occured " . $e->getMessage() . " on line " . __LINE__, false);
        }
        if($courses == null){
            return $this->apiResponse("Customer has no orders", false);
        }

        //you might need to fetch each course from the database depending on if its a list of ids
        $started = false; //assume customer has not taken any module -> to help us set 
        $total_number_of_courses = sizeof($courses); //Test
        $total_number_of_completed_courses = 0;
        $last_completed_course = null; //we will set this to true if a course is found to be completed : all its modules taken or last module taken

        foreach ($courses as $course) {
            $course = trim($course);
            //if each course had a completed flag it would really optimize this process
            //if($course->completed){ continue; }
            $modules =  null;
            try{
                $modules = $this->getModule($course); 
            }catch(\Exception $e){
                Log::error($e->getMessage() . " on line " . __LINE__);
                return $this->apiResponse("An error occured " . $e->getMessage() . " on line " . __LINE__, false);
            }
            //you might need to fetch each module from the database depending on if its a list of ids
            if($modules == null){
                continue; //dont crash because the list is empty
            }
            $next_uncompleted_module = null;
            $module_count = sizeof($modules); //Test
            $uncompleted_module_count = 0;
            
            //start from the end since we need the last completed module to determine the next module
            //beginning from -2 bcause we already know that the last module is not treated
            for( $i = $module_count -1; $i >= 0; $i--){ //$i > 0 would means it wont reach the last item
                /** Convert this into a function if u can */
                $module = $modules[$i]; //current module
                if($module != null and $this->moduleCompleted($module, $customer)){
                    if($i == $module_count -1){
                        break;
                    }
                   
                    
                    if($next_uncompleted_module){
                        //if we get here that means we have found the first uncompleted lesson in this course
                        //so lets tag the customer for this
                        try{
                            $tag = $this->getTag($this->constructTagName($next_uncompleted_module));
                            $customer = $this->setTag($customer, $tag);
                            //Stop all processing and return the tagging result 
                            return $this->apiResponse($tag->name , true);
                        }catch(\Exception $e){
                            Log::error($e->getMessage() . " on line " . __LINE__);
                            return $this->apiResponse("An error occured " . $e->getMessage() . " on line " . __LINE__, false);
                        }
                    }
                }
                //if we get here that means that the current module has not been completed
                //so it becomes the next uncompleted module
                //if the current module is not completed, lets take note, cause the next might be
                //in which case this one becomes the one for the reminder
                $next_uncompleted_module = $module;
                $uncompleted_module_count++;
            
            }//end of modules loop

            if($uncompleted_module_count == $module_count){
                //If we get here then no module was completed in this course
                //This means the customer has not started this course
                //If no modules are completed it should attach first tag in order
                try{
                    $tag = $this->getTag($this->constructTagName($module));
                    $customer = $this->setTag($customer, $tag);
                }catch(\Exception $e){
                    Log::error($e->getMessage() . " on line " . __LINE__);
                    return $this->apiResponse("An error occured " . $e->getMessage() . " on line " . __LINE__, false);
                }
                return $this->apiResponse($tag->name , true); //Stop all processing and return the result
            }
            $uncompleted_module_count = 0; //reset so that we can start afresh for the next set of modules
            $next_uncompleted_module = null; //reset so that we can start afresh for the next set of modules
        
        }//end of course loop
        
        //if we get here every module was completed in every course
        //or the last module of every course was completed
        try{
            $tag = $this->getCompletionTag();
            $customer = $this->setTag($customer, $tag);  
            return $this->apiResponse($tag->name , true); //Stop all processing and return the result
        }catch(\Exception $e){
            Log::error($e->getMessage() . " on line " . __LINE__);
            return $this->apiResponse("An error occured " . $e->getMessage() . " on line " . __LINE__, false);
        }
    }

    private function getModule($course){
        $module = Cache::remember($course, 1440, function() use($course){
            return Module::where('course_key', $course)->get();
        });
        return $module;
    }

    private function constructTagName($module){
        return "Start " . $module->name . " Reminders";
    }

    
    private function getCompletionTag(){        
        $tag = $this->getTag("Module reminders completed");
        return $tag;
    }

    private function getTag($tagName){
        if(!$this->tagsDownloaded()){
            //fetch and save
            $this->downloadAndSaveTags();
        }
        $cache_key = preg_replace('/\s+/', ' ', $tagName);
        $tag = Cache::remember($cache_key, 1440, function() use($tagName){
            return Tag::where('name', 'LIKE', '%' . $tagName . '%')->first();
        });
        return $tag;
    }    

    private function downloadAndSaveTags(){
        try{
            $tags = $this->infusionsoftHelper->getAllTags();
            $tags = json_decode($tags);
            foreach ($tags as $tag) {
                $t = new Tag();
                $t->id = $tag->id;
                $t->name = $tag->name;
                $t->save();
            }
        }catch(\Exception $e){
            Log::error($e->getMessage() . " in downloadAndSaveTags");
        }
    }

    private function tagsDownloaded(){
        $exists = Cache::remember('tags_exist', 1440, function(){
            return Tag::where('id', '>', 0)->count() > 0;
        });
        return $exists;
    }
   
    private function setTag($customer, $tag){
        try{
            return $this->infusionsoftHelper->addTag($customer->Id, $tag->id);                                        
        }catch(\Exception $e){
            Log::error($e->getMessage() . " in setTag");
            return $e;
        }
    }

    private function getUser($contact){
        try{
            $cache_key = 'user' . $contact->Id;
            $contact->Email = trim($contact->Email);
            $user = Cache::remember($cache_key, 1440, function() use($contact){
                return User::where('email', 'like', '%' . $contact->Email . '%')->first();
            });
            return $user;
        }catch(\Exception $e){
            Log::error($e->getMessage() . " in getUser");
        }
    }

    private function moduleCompleted($module, $customer){
        try{
            $cache_key = 'u_c_m' . $module->id . $customer->Id;
            $user = $this->getUser($customer);
            $completed = Cache::remember($cache_key, 1440, function() use($module, $user){
                return UserCompletedModule::where('user_id', $user->id)->where('module_id', $module->id)->count();
            });
            return $completed;
        }catch(\Exception $e){
            Log::error($e->getMessage() . " in moduleCompleted");
        }
    }
}

?>