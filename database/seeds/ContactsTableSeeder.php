<?php

use Illuminate\Database\Seeder;
use App\Contact;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::insert([
            [
                'Id' => 1,
                'Email' => 'isaacemem@gmail.com',
                '_Products' => 'ipa, iea',
            ],
            [
                'Id' => 2,
                'Email' => 'iea-as-firstcourse@gmail.com',
                '_Products' => 'iea, ipa',
            ],
            [
                'Id' => 3,
                'Email' => 'iaa-as-firstcourse@gmail.com',
                '_Products' => 'iaa, ipa',
            ],
            [
                'Id' => 4,
                'Email' => 'has-completed-first-ipa-module@gmail.com',
                '_Products' => 'ipa, iea',
            ],
            [
                'Id' => 5,
                'Email' => 'has-completed-first-and-third-ipa-module@gmail.com',
                '_Products' => 'ipa, iea',
            ],
            [
                'Id' => 6,
                'Email' => 'has-completed-last-ipa-module@gmail.com',
                '_Products' => 'ipa, iea',
            ],
            [
                'Id' => 7,
                'Email' => 'has-completed-last-module-of-all-courses@gmail.com',
                '_Products' => 'ipa, iea',
            ],
            [
                'Id' => 8,
                'Email' => 'has-completed-first-of-both-modules@gmail.com',
                '_Products' => 'ipa,iea',
            ],
            [
                'Id' => 9,
                'Email' => 'has-completed-last-ipa-and-5th-iaa@gmail.com',
                '_Products' => 'ipa,iaa',
            ],
            [
                'Id' => 10,
                'Email' => 'has-no-courses@gmail.com',
                '_Products' => null
            ]
        ]);
    }
}
