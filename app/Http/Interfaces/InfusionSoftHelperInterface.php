<?
namespace App\Http\Interfaces;

interface InfusionSoftHelperInterface{
    public function getAllTags();
    public function getContact($email);
    public function addTag($contact_id, $tag_id);
    public function createContact($data);
}
?>