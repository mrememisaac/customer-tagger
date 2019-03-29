<?php

namespace App\Http\Controllers;

use App\Http\Helpers\InfusionsoftHelper;
use App\Http\Helpers\ReminderTagger;
use Illuminate\Http\Request;
use Response;

class ApiController extends Controller
{
    private $reminderTagger;

    public function __constructor(ReminderTagger $tagger){
        $this->reminderTagger = $tagger;
    }
    // Todo: Module reminder assigner
    private function reminderAssigner($customer_email){
        return $reminderTagger->setReminderTag($customer_email);
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
