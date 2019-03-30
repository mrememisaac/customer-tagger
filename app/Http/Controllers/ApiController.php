<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\InfusionSoftHelperInterface;

use App\Http\Helpers\MockInfusionsoftHelper;
use App\Http\Helpers\InfusionsoftHelper;
use App\Http\Helpers\ReminderTagger;
use Illuminate\Http\Request;
use Response;
use App;

class ApiController extends Controller
{
   
    public function __constructor(){
        App:bind('App\Http\Interfaces\InfusionSoftHelperInterface', 'App\Http\Helpers\MockInfusionsoftHelper');
    }
    // Todo: Module reminder assigner
    public function reminderAssigner(Request $request, $contact_email){
        $tagger = new ReminderTagger(new MockInfusionsoftHelper());
        return $tagger->setReminderTag($contact_email);
    }

    private function exampleCustomer(){

        $infusionsoft = new InfusionsoftHelper();

        $uniqid = uniqid();

        $infusionsoft->createContact([
            'Email' => $uniqid.'@test.com',
            "_Products" => 'ipa,iea'
        ]);

        $user = User::create([
            'name' => 'Test ' . $uniqid,
            'email' => $uniqid.'@test.com',
            'password' => bcrypt($uniqid)
        ]);

        // attach IPA M1-3 & M5
        $user->completed_modules()->attach(Module::where('course_key', 'ipa')->limit(3)->get());
        $user->completed_modules()->attach(Module::where('name', 'IPA Module 5')->first());


        return $user;
    }
}
