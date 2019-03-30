<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReminderTaggerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function test_verify_valid_customer_who_has_not_started_any_course_and_has_ipa_as_first_course_returns_Start_IPA_Module_1_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/isaacemem@gmail.com")
        ->assertJson(['message' => 'Start IPA Module 1 Reminders', 'success' => true]);
    }

    public function test_verify_valid_customer_who_has_not_started_any_course_and_has_iea_as_first_course_returns_Start_IEA_Module_1_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/iea-as-firstcourse@gmail.com")
        ->assertJson(['message' => 'Start IEA Module 1 Reminders', 'success' => true]);
    }

}
