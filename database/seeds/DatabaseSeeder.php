<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ContactsTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(CoursesTableSeeder::class);
         $this->call(ModulesTableSeeder::class);
         $this->call(UserCompletedModulesTableSeeder::class);
         $this->call(TagsTableSeeder::class);
    }
}
