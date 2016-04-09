<?php
class Contact extends CI_Model
{
  
  public $title;
  public $name;
  public $surname;
  public $email;
  public $phone;
  public $mobile;
  public $position;
  public $companyId;
  public $supervisorId;

  public function __construct()
  {
    parent::__construct();
  }

    
    /**
     * @param string $title, string $name, string $surname, string $email, string $phone, string $mobile, int $companyId,int  $supervisorId=0, string $position
     * Adds Contact
     * @return int
     */
    
    public function addContact($title, $name, $surname, $email, $phone, $mobile, $companyId, $supervisorId=0, $position)
    {
      $this->title          = $title;
      $this->name           = $name;
      $this->surname        = $surname;
      $this->email          = $email;
      $this->phone          = $phone;
      $this->mobile         = $mobile;
      $this->companyId      = $companyId;
      $this->supervisorId   = $supervisorId;
      $this->position       = $position;
    
      $result = $this->db->insert("Contacts", $this);
      if(!$result){
        $result = "Error - duplicate entry"; 
      }else{
        $result = $this->db->insert_id();  
      }
      
      return $result;
    }

     /**
     * @param int $id
     * Removes contact based on ID
     * @return boolean
     */
    
    public function removeContact($id)
    {
      $this->db->where('id', $id);
      if ($this->db->delete('Contacts')) {
        return true;
      } else {
        return false;
      }
    }


    /**
     * Returns all contacts
     * @return array
    */
    public function getContacts()
    {
      $query = $this->db->get('Contacts');
      $result = $query->result();
      if(is_array($result)){
        return $result;
      }
      return false;
    }

    /**
     * @param int $id
     * Returns contact based on id
     * @return object
    */
    public function getContact($id)
    {
      $query = $this->db->get_where('Contacts', array("id" => $id));
      $result = $query->result();
      if(is_array($result)){
        return $result[0];
      }
      return false;
    }

    public function updateContact(
      $id,
      $title=false,
      $name=false,
      $surname=false,
      $email=false,
      $phone=false,
      $mobile=false,
      $position=false,
      $supervisorId=false,
      $companyId=false)
    {
      if($title){
        $this->title = $title;                
      }
      if($name){
        $this->name = $name;                
      }
      if($surname){
        $this->surname = $surname;                
      }
      if($email){
        $this->email = $email;                
      }
      if($phone){
        $this->phone = $phone;                
      }
      if($mobile){
        $this->mobile = $mobile;                
      }
      if($position){
        $this->position = $position;                
      }
      if($supervisorId){
        $this->supervisorId = $supervisorId;                
      }
      if($companyId){
        $this->companyId = $companyId;                
      }

      $this->db->where("id",$id);
      
      return $this->db->update('Contacts', $this);
    }

    //('name'=>"",$surname="",$email="",$phone="",$mobile="",$position="",$companyName = "",$ref=""
    public function searchContacts($data){   
        $this->db->join('Companies', 'Contacts.companyId = Companies.id', 'left');
      if(isset($data['name']))
        $this->db->like('Contacts.name', $data['name']);
      if(isset($data['surname']))
        $this->db->like('Contacts.surname', $data['surname']);
      if(isset($data['email']))
        $this->db->like('Contacts.email', $data['email']);
      if(isset($data['phone']))
        $this->db->like('Contacts.phone', $data['phone']);
      if(isset($data['mobile']))
        $this->db->like('Contacts.mobile', $data['mobile']);
      if(isset($data['position']))
        $this->db->like('Contacts.position', $data['position']);
      if(isset($data['companyName']))
        $this->db->like('Companies.companyName', $data['companyName']);
      if(isset($data['ref']))
        $this->db->like('Companies.ref', $data['ref']);
      $query = $this->db->get("Contacts");
  
      $result = $query->result();
      return $result;
    }
    
}
