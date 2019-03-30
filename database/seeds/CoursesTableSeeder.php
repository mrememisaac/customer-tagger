<?php

use Illuminate\Database\Seeder;
use App\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
