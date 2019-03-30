<?php

use Illuminate\Database\Seeder;
use App\UserCompletedModule;
use App\Module;

class UserCompletedModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCompletedModule::create(
            [
                'user_id' => 4,
                'module_id' => 1//Module::where('name', 'like', '%'. 'IPA Module 1' . '%')->first()->id
            ]);
        UserCompletedModule::create(
            
            [
                'user_id' => 5,
                'module_id' => 2 //Module::where('name', 'like', '%'. 'IPA Module 1' . '%')->first()->id
            ]);
        UserCompletedModule::create(
            
            [
                'user_id' => 5,
                'module_id' => 3 //Module::where('name', 'like', '%'. 'IPA Module 3' . '%')->first()->id
            ]);
        UserCompletedModule::create(
            
            [
                'user_id' => 6,
                'module_id' => 19 //Module::where('name', 'like', '%'. 'IPA Module 7' . '%')->first()->id
            ]);
        UserCompletedModule::create(
            [
                'user_id' => 7,
                'module_id' => 19 //Module::where('name', 'like', '%'. 'IPA Module 7' . '%')->first()->id
            ]);
        UserCompletedModule::create(
            [
                'user_id' => 7,
                'module_id' => 20 //Module::where('name', 'like', '%'. 'IEA Module 7' . '%')->first()->id
            ]
        );
        /*UserCompletedModule::create([
            [
                'user_id' => 4,
                'module_id' => 1//Module::where('name', 'like', '%'. 'IPA Module 1' . '%')->first()->id
            ],
            [
                'user_id' => 5,
                'module_id' => 2 //Module::where('name', 'like', '%'. 'IPA Module 1' . '%')->first()->id
            ],
            [
                'user_id' => 5,
                'module_id' => 3 //Module::where('name', 'like', '%'. 'IPA Module 3' . '%')->first()->id
            ],
            [
                'user_id' => 6,
                'module_id' => 19 //Module::where('name', 'like', '%'. 'IPA Module 7' . '%')->first()->id
            ],
            [
                'user_id' => 7,
                'module_id' => 19 //Module::where('name', 'like', '%'. 'IPA Module 7' . '%')->first()->id
            ],
            [
                'user_id' => 7,
                'module_id' => 20 //Module::where('name', 'like', '%'. 'IEA Module 7' . '%')->first()->id
            ]
        ]);*/
       
    }
}
