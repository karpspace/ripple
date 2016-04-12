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
  public $notes;
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
    
    public function addContact($data)
    {
    
      $result = $this->db->insert("Contacts", $data);
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
    public function getContacts($page, $limit=25)
    {
       $this->db->select("Contacts.id as id, Contacts.name, Contacts.title, Contacts.surname,Contacts.email,Contacts.phone,Contacts.mobile,Contacts.position,Contacts.notes,Companies.companyName,Companies.ref, Companies.id as companyId");
      $this->db->join('Companies', 'Contacts.companyId = Companies.id', 'left');
      $query = $this->db->get('Contacts',$limit, (($page-1)*25));
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
       $this->db->select("Contacts.id as id, Contacts.name, Contacts.title, Contacts.surname,Contacts.email,Contacts.phone,Contacts.mobile,Contacts.position,Contacts.notes,Contacts.supervisorId,Companies.companyName,Companies.ref, Companies.id as companyId");
      $this->db->join('Companies', 'Contacts.companyId = Companies.id', 'left');
      $query = $this->db->get_where('Contacts', array("Contacts.id" => $id));

      $result = $query->result();
       if( (is_array($result) && ( count($result) >0 ) ) ) {
        return $result[0];
      }
      return false;
    }

    public function updateContact($data){

      $this->db->where("id", $data['id']);
      $this->db->update('Contacts', $data);

    }


    public function searchContacts($data,$limit=25){   

      $this->db->select("Contacts.id as id, Contacts.name, Contacts.title, Contacts.surname,Contacts.email,Contacts.phone,Contacts.mobile,Contacts.position,Contacts.notes,Companies.companyName,Companies.ref, Companies.id as companyId");

      $this->db->join('Companies', 'Companies.id=companyId',"left");
      if(!isset($data['page']))
        $data['page'] =1;
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
      if(isset($data['notes']))
        $this->db->like('Contacts.notes', $data['notes']);
      if(isset($data['companyName']))
        $this->db->like('Companies.companyName', $data['companyName']);
      if(isset($data['ref']))
        $this->db->like('Companies.ref', $data['ref']);
      if(isset($data['companyId']))
        $this->db->like('Companies.id', $data['companyId']);
      
      $this->db->limit($limit, (($data['page']-1)*25) );
      $query =  $this->db->get("Contacts");
      error_log($this->db->last_query());
      $result = $query->result();
      return $result;
    }
    
}
