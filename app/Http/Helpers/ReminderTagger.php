<?php

namespace App\Http\Helpers;

use Infusionsoft;
use Log;
use Storage;
use Request;
use \App\Tag;
use \App\User;
use App\Contact;
use \App\Course;
use \App\Module;
use App\Http\Interfaces\InfusionSoftHelperInterface;
use App\Http\Helpers\ApiResponse;

class ReminderTagger{

    private $infusionsoftHelper;

    public function __construct(InfusionSoftHelper $helper){
        $this->infusionsoftHelper = $helper;
    } 


    /**
     * Returns courses bought by this customer
     * I brought this out to its own function because the way we get courses ie products might change, 
     */
    public function getCustomerCourses($customer){
        //returns array of strings
        // if($customer == null) {
        //     return null;
        // }
        // return $customer->courses;
        try
        {
            if($customer->_Products){
                return str_split($customer->_Products);
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function apiResponse($msg, $successful, $code = null){
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
            Log::error($e->getMessage());
            return $this->apiResponse("An error occured " . $e->getMessage(), false);
        }

        if($customer == null){
            return $this->apiResponse("Customer not found", false, 404);
        }

        $courses = null;
        try{        
            $courses = $this->getCustomerCourses($customer); //returns array of strings
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return $this->apiResponse("An error occured " . $e->getMessage(), false);
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
            return $course;
            //if each course had a completed flag it would really optimize this process
            //if($course->completed){ continue; }
            $modules =  null;
            try{
                $modules = Module::where('course_key', $course)->get(); //$course->modules;
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return $this->apiResponse("An error occured " . $e->getMessage(), false);
            }
            //you might need to fetch each module from the database depending on if its a list of ids
            if($modules == null){
                continue; //dont crash because the list is empty
            }
            $next_uncompleted_module = null;
            $module_count = sizeof($modules); //Test
            $uncompleted_module_count = 0;
            
            //start from the end since we need the last completed module to determine the next module
            for( $i = $module_count; $i >= 0; $i--){ //$i > 0 would means it wont reach the last item
                /** Convert this into a function if u can */
                $module = $modules[$i]; //current module
                if($i > 0){
                    $next_module = $modules[$i-1]; //we get a handle on the previous module because the current  the one before this one 
                }
                if($module != null and $module->completed){
                    $started = true;

                    if($i == $module_count){//if the last module has been completed
                        $last_completed_course = $course; //why are we doing this? //we should store it maybe
                        $total_number_of_completed_courses++;
                         //according to the rules, since the last module has been treated, we have to move on to the next course
                        break;
                    }
                    //if we get here then module n was completed but module n+1  was not completed
                    //so lets tag the customer for this
                    if($next_uncompleted_module){
                        try{
                            $tag = $this->getTag($next_uncompleted_module, $course);
                            $customer = $this->setTag($customer, $tag);
                        }catch(\Exception $e){
                            Log::error($e->getMessage());
                            return $this->apiResponse("An error occured " . $e->getMessage(), false);
                        }
                        return $this->apiResponse("Reminder set successfully", true);
                        //Stop all processing and return the tagging result 
                    }
                }
                $uncompleted_module_count++;
                //if the current module is not completed, lets take note, cause the next might be
                //in which case this one becomes the one for the reminder
                $next_uncompleted_module = $module;
            }
            //If we get here then no module was completed in this course
            if($uncompleted_module_count == $module_count){
                //This means the customer has not started this course
                //If no modules are completed it should attach first tag in order
                try{
                    $tag = $this->getFirstTag();
                    $customer = $this->setTag($customer, $tag);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return $this->apiResponse("An error occured " . $e->getMessage(), false);
                }
                return $this->apiResponse("Reminder set successfully", true); //Stop all processing and return the result
                
            }
            $uncompleted_module_count = 0; //reset so that we can start afresh for the next set of modules
            $next_uncompleted_module = null; //reset so that we can start afresh for the next set of modules
        }
        //if we get here evert module was completed in every course
        try{
            $tag = $this->getCompletionTag();
            $customer = $this->setTag($customer, $tag);        
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return $this->apiResponse("An error occured " . $e->getMessage(), false);
        }
        return $this->apiResponse("Reminder set successfully", true); //Stop all processing and return the result
    }

    public function getCompletionTag(){
        $exists = Tag::where('id', '>', 0)->exist();
        if(!$exists){
            //fetch and save
            $this->downloadAndSaveTags();
        }
        $tag = Tag::where('name', "Module reminders completed")->first();
        return $tag;
        //return $getAllTags()->where('name', "Module reminders completed")->first(); //Test
    }

    public function downloadAndSaveTags(){
        try{
            $tags = $infusionsoftHelper->getAllTags();
            foreach ($tags as $tag) {
                $t = new Tag();
                $t->id = $tag->id;
                $t->name = $tag->name;
                $t->save();
            }
        }catch(\Exception $e){

        }
    }

    public function getFirstTag(){
        if(!$exists){
            //fetch and save
            $this->downloadAndSaveTags();
        }
        return Tag::where('id', '>', 0)->first(); //Test
    }

    public function getStartTag($module){
                                           
    }

    public function setTag($customer, $tag){
        $infusionsoftHelper->addTag($customer->id, $tag->id);                                        
    }
}

?>