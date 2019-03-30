<?php

namespace App\Http\Controllers;

use \App\Http\Helpers\MockInfusionsoftHelper;
use Request;
use Storage;
use Response;

class MockInfusionsoftController extends Controller
{
    public function __constructor(){
        // App:bind('App\Http\Helpers\InfusionsoftHelperBaseClass', 'App\Http\Helpers\MockInfusionsoftHelper');
    }

    public function testInfusionsoftIntegrationGetEmail($email){

        $infusionsoft = new \App\Http\Helpers\MockInfusionsoftHelper();

        return Response::json($infusionsoft->getContact($email));
    }

    public function testInfusionsoftIntegrationAddTag($contact_id, $tag_id){

        $infusionsoft = new MockInfusionsoftHelper();

        return Response::json($infusionsoft->addTag($contact_id, $tag_id));
    }

    public function testInfusionsoftIntegrationGetAllTags(){

        $infusionsoft = new MockInfusionsoftHelper();

        return Response::json($infusionsoft->getAllTags());
    }

    public function testInfusionsoftIntegrationCreateContact(){

        $infusionsoft = new MockInfusionsoftHelper();

        return Response::json($infusionsoft->createContact([
            'Email' => 'isaacemem@gmail.com',
            "_Products" => 'ipa,iea'
        ]));
    }

    public function CreateTestContacts(){

        $infusionsoft = new MockInfusionsoftHelper();

        $first =  Response::json($infusionsoft->createContact([
            'Email' => 'iea-as-firstcourse@gmail.com',
            "_Products" => 'iea,ipa'
        ]));
        $second =  Response::json($infusionsoft->createContact([
            'Email' => 'iaa-as-firstcourse@gmail.com',
            "_Products" => 'iaa'
        ]));
    }
}
