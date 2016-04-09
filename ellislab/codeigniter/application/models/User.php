<?php
class User extends CI_Model
{

  public $name;
  public $surname;
  public $email;
  public $password;
  public $salt;
  public $active = 1;

  public function __construct()
  {
    parent::__construct();
  }

    /**
    * From http://stackoverflow.com/questions/5438760/generate-random-5-characters-string
    * How to generate 5 (here changed to 10) random characters, for salt. 
    * @return string
    */
    public function randomSeed(){
      $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
      shuffle($seed);
      $rand = '';
      foreach (array_rand($seed, 10) as $k)
        $rand .= $seed[$k];
        //-----------------------------------------------------------------------------------------
      return $rand;
    }






    /**
     * @param string $email, $string password
     * First checks if username exists in database, if he doesn't, it return false. Else it's comparing hashed password with 
     * concatenated salt. 
     * @return boolean
     */
    
    public function authenticateUser($email, $password)
    {
      $query = $this->db->get_where('Users', array(
        'email' => $email
        ));
      $user  = $query->row();
      if (!empty($user)) {
        if (hash("sha256", $password . $user->salt) == $user->password) {
          return 1;
        } else {
          return  false;
        }
        return false;
      }
      return false;
    }
    
    
    
    /**
     * @param string $email, string $password, string $name, string $surname 
     * Creates random string using solution found on stackoverflow, and then hashes it with sha256. Afterwards concatenates password 
     * with salt and hashes it again with sha256 and stores it, with all additional data in database. 
     * @return boolean
     */
    
    public function addUser($email, $password, $name, $surname)
    {
      $this->email   = $email;
      $this->name    = $name;
      $this->surname = $surname;
      $this->salt     = hash("sha256", $this->randomSeed());
      $this->password = hash("sha256", $password . $this->salt);
      
      try {
        $result = $this->db->insert("Users", $this);

        if(empty($result) ){
          throw new Exception('no data returned');
        }
       $result = $this->db->insert_id();
      } catch (Exception $e) {
        $result = "Duplicate email";
      }
      return $result;
    }
    
    /**
     * @param int $id
     * Removes user based on ID
     * @return boolean
     */
    
    public function removeUser($id)
    {
      $this->db->where('id', $id);
      if ($this->db->delete('Users')) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * Returns all users
     * @return object
    */
    public function getUsers()
    {
      $query = $this->db->get('Users');
      $result = $query->result();
      if(is_array($result)){
        return $result[0];
      }
      return false;
    }


    /**
     * @param int $id
     * Returns user based on id
     * @return object
    */
    public function getUser($id)
    {
      $query = $this->db->get_where('Users', array("id" => $id));
      $result = $query->result();
      if(is_array($result)){
        return $result[0];
      }
      return false;
    }

    
    /**
     * @param int $id
     * Updates user based on ID
     * @return boolean
     */
    public function updateUser($id, $email=false, $name=false, $surname=false, $password=false, $active=false)
    {
      if($name){
        $this->name = $name;                
      }

      if($surname){
        $this->surname = $surname;                
      }

      if($password){
        $this->salt     = hash("sha256", $this->randomSeed());
        $this->password = hash("sha256", $password . $this->salt);              
      }

      if($active){
        $this->active = $active;                
      }
      $this->db->where("id",$id);
      return $this->db->update('Users', $this);
    }    
  }
