<?php

use Illuminate\Database\Seeder;
use App\Module;
use App\Course;
use App\Contact;
use App\User;

class iPSDevTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(
            [
                'email' => 'isaacemem@gmail.com',
                'password' => '12345',
                'name' => 'Emem Isaac',
            ]
        );
        Contact::insert(
            [
                'email' => 'isaacemem@gmail.com',
            ]
        );
        Course::insert([
            [
                'course_key' => 'ipa',
                'name' => 'iPhone Photography Academy'
            ],
            [
                'course_key' => 'iea',
                'name' => 'iPhone Editing Academy'
            ],
            [
                'course_key' => 'iaa',
                'name' => 'iPhone Art Academy'
            ]
        ]);
        
        for ($i = 1; $i <= 7; $i++){
            Module::insert([
                [
                    'course_key' => 'ipa',
                    'name' => 'IPA Module ' . $i
                ],

                [
                    'course_key' => 'iea',
                    'name' => 'IEA Module ' . $i
                ],

                [
                    'course_key' => 'iaa',
                    'name' => 'IAA Module ' . $i
                ]
            ]);
        }


    }
}
