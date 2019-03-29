<?

namespace App\Http\Helpers;

use App\Http\Interfaces\InfusionSoftHelperInterface;
use App\Tag;
use App\Contact;

class MockInfusionSoftHelper implements InfusionSoftHelperInterface
{
    public function getAllTags(){
        return Tag::all();
    }

    public function getContact($email){
        $contact = Contact::where('Email', $email)->first();
        return $contact;
    }

    public function getContactById($contact_id){
        return Contact::find($contact_id);
    }

    public function getTagById($tag_id){
        return Tag::find($tag_id);
    }

    public function addTag($contact_id, $tag_id){
        $contact = $this->getContact($contact_id);
        $contact->tag = $this->getTag($tag_id);
    }

    public function createContact($contact){
        Contact::create($contact);
    }
}


?>