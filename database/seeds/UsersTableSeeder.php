<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id' => 1,
                'email' => 'isaacemem@gmail.com',
                'password' => '12345',
                'name' => 'Emem Isaac',
            ],
            [
                'id' => 2,
                'email' => 'iea-as-firstcourse@gmail.com',
                'password' => 'iea,ipa',
                'name' => 'Emem Isaac',

            ],
            [
                'id' => 3,
                'email' => 'iaa-as-firstcourse@gmail.com',
                'password' => 'iaa,ipa',
                'name' => 'Emem Isaac',
            ],
            [
                'id' => 4,
                'email' => 'has-completed-first-ipa-module@gmail.com',
                'password' => 'ipa,iea',
                'name' => 'Emem Isaac',
            ],
            [
                'id' => 5,
                'email' => 'has-completed-first-and-third-ipa-module@gmail.com',
                'password' => 'ipa,iea',
                'name' => 'Emem Isaac',
            ],
            [
                'id' => 6,
                'email' => 'has-completed-last-ipa-module@gmail.com',
                'password' => 'ipa,iea',
                'name' => 'Emem Isaac',
            ],
            [
                'id' => 7,
                'email' => 'has-completed-last-module-of-all-courses@gmail.com',
                'password' => 'ipa,iea',
                'name' => 'Emem Isaac',
            ]
        ]);
    }
}
