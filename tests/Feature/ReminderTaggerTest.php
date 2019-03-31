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
    public function test_verify_valid_customer_who_has_not_started_any_course_and_has_iaa_as_first_course_returns_Start_IAA_Module_1_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/iaa-as-firstcourse@gmail.com")
        ->assertJson(['message' => 'Start IAA Module 1 Reminders', 'success' => true]);
    }
    public function test_verify_valid_customer_who_has_completed_first_ipa_module_returns_Start_IPA_Module_2_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/has-completed-first-ipa-module@gmail.com")
        ->assertJson(['message' => 'Start IPA Module 2 Reminders', 'success' => true]);
    }
    public function test_verify_valid_customer_who_has_ipa_and_iea_and_has_completed_last_ipa_module_returns_Start_IEA_Module_1_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/has-completed-last-ipa-module@gmail.com")
        ->assertJson(['message' => 'Start IEA Module 1 Reminders', 'success' => true]);
    }
    public function test_verify_valid_customer_who_has_ipa_and_iea_and_has_completed_only_1st_and_3rd_ipa_module_returns_Start_IPA_Module_4_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/has-completed-first-and-third-ipa-module@gmail.com")
        ->assertJson(['message' => 'Start IPA Module 4 Reminders', 'success' => true]);
    }
    public function test_verify_valid_customer_who_has_has_completed_last_module_of_all_courses_gets_returns_Module_reminders_complete_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/has-completed-last-module-of-all-courses@gmail.com")
        ->assertJson(['message' => 'Module reminders completed', 'success' => true]);
    }
    public function test_verify_valid_customer_who_has_completed_last_ipa_and_5th_iaa_module_returns_Start_IAA_Module_6_Reminders_message_and_true()
    {
        $this->post("/api/module_reminder_assigner/has-completed-last-ipa-and-5th-iaa@gmail.com")
        ->assertJson(['message' => 'Start IAA Module 6 Reminders', 'success' => true]);
    }
    public function test_verify_invalid_customer_returns_customer_not_found_and_false()
    {
        $this->post("/api/module_reminder_assigner/imaginary@gmail.com")
        ->assertJson(['message' => 'Customer not found', 'success' => false]);
    }
    public function test_verify_customer_with_no_courses_returns_customer_has_no_orders_and_false()
    {
        $this->post("/api/module_reminder_assigner/has-no-courses@gmail.com")
        ->assertJson(['message' => 'Customer has no orders', 'success' => false]);
    }
}
