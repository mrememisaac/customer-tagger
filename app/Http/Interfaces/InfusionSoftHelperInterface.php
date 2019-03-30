<?php
namespace App\Http\Interfaces;

interface InfusionsoftHelperInterface{
    public function getAllTags();
    public function getContact($email);
    public function addTag($contact_id, $tag_id);
    public function createContact($data);
}
?>