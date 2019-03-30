<?php

namespace App\Http\Helpers;

use App\Tag;
use App\Contact;
use App\Http\Interfaces\InfusionsoftHelperInterface;

class MockInfusionsoftHelper implements InfusionsoftHelperInterface
{
    public function getAllTags(){
        return Tag::all();
    }

    public function getContact($email){
        $contact = Contact::where('Email', $email)->first();
        if($contact == null){
            return null;
        }
        return [ 'Id' => $contact->Id, 'Email' => $contact->Email, '_Products' => $contact->_Products, 'Groups' => $contact->Groups];
    }

    public function getContactById($contact_id){
        return Contact::find($contact_id);
    }

    public function getTagById($tag_id){
        return Tag::find($tag_id);
    }

    public function addTag($contact_id, $tag_id){
        $contact = $this->getContactById($contact_id);
        $tag =  $this->getTagById($tag_id);
        if($tag != null){
            $contact->Groups = $tag->name;
            $contact->save();
        }
        return $contact;
    }

    public function createContact($contact){
        Contact::create($contact);
    }
}


?>