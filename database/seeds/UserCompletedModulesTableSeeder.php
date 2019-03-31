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
                'module_id' => 1
            ]);
        UserCompletedModule::create(
            
            [
                'user_id' => 5,
                'module_id' => 2 
            ]);
        UserCompletedModule::create(
            
            [
                'user_id' => 5,
                'module_id' => 3 
            ]);
        UserCompletedModule::create(
            
            [
                'user_id' => 6,
                'module_id' => 19 
            ]);
        UserCompletedModule::create(
            [
                'user_id' => 7,
                'module_id' => 19 
            ]);
        UserCompletedModule::create(
            [
                'user_id' => 7,
                'module_id' => 20 
            ]
        );
        UserCompletedModule::create(
            [
                'user_id' => 8,
                'module_id' => 1 
            ]
        );
        UserCompletedModule::create(
            [
                'user_id' => 8,
                'module_id' => 2 
            ]
        );
        UserCompletedModule::create(
            [
                'user_id' => 9,
                'module_id' => 19 
            ]
        );
        UserCompletedModule::create(
            [
                'user_id' => 9,
                'module_id' => 15
            ]
        );
       
    }
}
