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
    
    public function addCompany($data)
    {
      if(!$this->checkIfCompanyExists($data['ref'])){
        $this->db->insert("Companies", $data);
        $result = $this->db->insert_id();
        return $result;  
      }else{
        return false;
      }

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
    public function getCompanies($page,$limit=25)
    {
      $query = $this->db->get('Companies',$limit, (($page-1)*25));
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
        keyContact.title as keyContactTitle,
        keyContact.name as keyContactName,
        keyContact.surname as keyContactSurname,
        keyContact.phone as keyContactPhone,
        keyContact.mobile as keyContactMobile,
        keyContact.email as keyContactEmail,
        keyContact.position as keyContactPosition,
        emergencyContact.title as emergencyContactTitle,
        emergencyContact.name as emergencyContactName,
        emergencyContact.surname as emergencyContactSurname,
        emergencyContact.phone as emergencyContactPhone,
        emergencyContact.mobile as emergencyContactMobile,
        emergencyContact.email as emergencyContactEmail,
        emergencyContact.position as emergencyContactPosition,



         ");
      $this->db->join('Contacts as keyContact', 'Companies.keyContactId = keyContact.id', 'left');
      $this->db->join('Contacts as emergencyContact', 'Companies.emergencyContactId = emergencyContact.id', 'left');
      $query = $this->db->get_where('Companies', array("Companies.id" => $id));
     error_log("New: ".$this->db->last_query());
      $result = $query->result();
      
      if( (is_array($result) && ( count($result) !=0 ) ) ) {
        return $result[0];
      }
      return false;
    }

    
    /**
     * @param int $id
     * Updates company based on ID
     * @return boolean
     */
    public function updateCompany($data)
    { 
      $this->db->where("id",$data['id']);

      return $this->db->update('Companies', $data);
    }

    /**
     * @param string $companyName, string $ref
     * Searches for company directory by either company's name or ref
     * @return array
     */
    public function searchCompany($companyName, $ref, $page,$limit=25){  
        $this->db->like('companyName', $companyName);
        $this->db->like('ref', $ref);
        $query = $this->db->get("Companies",$limit, (($page-1)*25));
        $result = $query->result();
        return $result;
    }

    /**
     * @param  string $ref
     * Checks if company exists
     * @return boolean
     */
    public function checkIfCompanyExists($ref){   
        $query = $this->db->get_where('Companies',array("ref" => $ref));
        $result = $query->result();
        if($result){
          return true;
        }else{
          return false;  
        }
        
    }


  }
