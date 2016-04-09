<?php
class Company extends CI_Model
{

  public $companyName;
  public $ref;
  public $natureOfBusiness;
  public $keyContactId;
  public $keyContactInBuilding;
  public $emergencyContactId;

  public function __construct()
  {
    parent::__construct();
  }

    
    /**
     * @param string $companyName, string $ref, string $natureOfBusiness,int $keyContactId, int emergencyContactId
     * Adds company
     * @return int
     */ 
    
    public function addCompany($companyName, $ref, $natureOfBusiness = "", $keyContactId=0,$keyContactInBuilding=0, $emergencyContactId=0)
    {
      
      $this->companyName = $companyName;
      $this->ref = $ref;
      $this->natureOfBusiness = $natureOfBusiness;
      $this->keyContactId = $keyContactId;
      $this->keyContactInBuilding = $keyContactInBuilding;
      $this->emergencyContactId = $emergencyContactId;
      $result = $this->db->insert("Companies", $this);
      
      if(empty($result) ){
        $result = "Duplicate name or reference";
      }else{
        $result = $this->db->insert_id();
      }
      return $result;  
    }
    
    /**
     * @param int $id
     * Removes comapany based on ID
     * @return boolean
     */
    
    public function removeCompany($id)
    {
      $this->db->where('id', $id);
      if ($this->db->delete('Companies')) {
        return true;
      } else {
        return false;
      }
    }

  /**
     * Returns all cpmanies
     * @return object
    */
    public function getCompanies()
    {
      $query = $this->db->get('Companies');
      $result = $query->result();
      if(is_array($result)){
        return $result;
      }
      return false;
    }

    /**
     * @param int $id
     * Returns comapany based on id
     * @return object
    */
    public function getCompany($id)
    {
      $this->db->select("Companies.id, Companies.companyName, Companies.natureOfBusiness, 
        Companies.ref, 
        Companies.keyContactInBuilding,
        keyContact.name as keyContactName,
        keyContact.surname as keyContactSurname,
        keyContact.phone as keyContactPhone,
        keyContact.mobile as keyContactMobile,
        keyContact.email as keyContactEmail,
        emergencyContact.name as emergencyContactName,
        emergencyContact.surname as emergencyContactSurname,
        emergencyContact.phone as emergencyContactPhone,
        emergencyContact.mobile as emergencyContactMobile,
        emergencyContact.email as emergencyContactEmail,



         ");
      $this->db->join('Contacts as keyContact', 'Companies.keyContactId = keyContact.id', 'left');
      $this->db->join('Contacts as emergencyContact', 'Companies.emergencyContactId = emergencyContact.id', 'left');
      $query = $this->db->get_where('Companies', array("Companies.id" => $id));
     error_log("New: ".$this->db->last_query());
      $result = $query->result();
      
      if(is_array($result)){
        return $result[0];
      }
      return false;
    }

    
    /**
     * @param int $id
     * Updates company based on ID
     * @return boolean
     */
    public function updateCompany($id, $companyName=false, $ref=false, $natureOfBusiness=false)
    {
      if($companyName){
        $this->companyName = $companyName;                
      }

      if($ref){
        $this->ref = $ref;                
      }

      if($natureOfBusiness){
        $this->natureOfBusiness = $natureOfBusiness;                
      }
      $this->db->where("id",$id);
      return $this->db->update('Companies', $this);
    }

    /**
     * @param string $companyName, string $ref
     * Searches for company directory by either company's name or ref
     * @return array
     */
    public function searchCompany($companyName="", $ref=""){   
        $this->db->like('companyName', $companyName);
        $this->db->like('ref', $ref);
        $query = $this->db->get("Companies");
        $result = $query->result();
        return $result;
    }



  }
