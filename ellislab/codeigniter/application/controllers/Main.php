<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
  				
	public function __construct(){
  	parent::__construct();
		$this->load->library('session');
		$this->load->model('User');
		$this->load->model('Company');
		$this->load->model('Contact');
		$loggedIn = $this->session->userdata('loggedIn');
		$view = $this->uri->segment(1);
		if($loggedIn == 0){	
			//Better filtering system could be used.
			if(
					($view != "login" )&&
					($view != "loginFail" )&&
					($view != "authenticate" )
				){			
				redirect("login");	
			}
		}	
	}

	/**
  * @param string $_POST['email'], $string $_POST['password']
  * CodeIgnier Input libery clears POST data. Then is being checked.
  * If authetication successes session data is set.
  */
	public function authenticate(){
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		if($this->User->authenticateUser($email,$password)){
			$this->session->loggedIn = 1;
			redirect("allCompanies");	
			error_log("Authentication successful ");
		}else{
			redirect("loginFail");	
			error_log("Authentication failed");
		}
	}

	/**
  * Logout user
  */
	public function logout(){
		$this->session->unset_userdata('loggedIn');
		redirect("login");	
	}


	/**
  * @param int $error
  * Loads login page.
  */
	public function login($error=0)
	{
		error_log("test");
		if($error){
			$data['error'] = 'Bad username or password';
		}
		$data['view'] = "login";
		$this->load->view('template', array("data"=>$data));
	}


	public function allCompanies($page){
		$data['companies'] = $this->Company->getCompanies($page);
		$data['companiesCount'] = count($this->Company->getCompanies($page));
		$data['view'] = "companies";
		$this->load->view('template', array("data"=>$data));
	}

	public function editCompany($id){
		$data['company'] = $this->Company->getCompany($id);
		$data['companyContacts'] = $this->Contact->searchContacts(array("ref" => $data['company']->ref));
		$data['view'] = "company";
		$this->load->view('template', array("data"=>$data));
	}

	public function removeCompany($id){
		$data['company'] = $this->Company->removeCompany($id);
		redirect("allCompanies");
	}

	public function updateCompany($id){
		$data = $this->input->post();
		$data['id'] = $id;
		if(empty($data['keyContactInBuilding'])){
			$data['keyContactInBuilding'] = "off";
		}
		$this->Company->updateCompany($data);

		redirect("editCompany/".$id);	
	}

	public function searchCompaniesAjax(){
		$companyName = $this->input->post("companyName");
		$ref = $this->input->post("ref");
		$page = $this->input->post("page");
		$companies = $this->Company->searchCompany($companyName, $ref, $page);
		echo json_encode($companies);
	}

	public function searchContactsAjax(){
		$data = array("name" => $this->input->post("name"),
			"surname" => $this->input->post("surname"),
			"email" => $this->input->post("email"),
			"phone" => $this->input->post("phone"),
			"mobile" => $this->input->post("mobile"),
			"position" => $this->input->post("position"),
			"companyName" => $this->input->post("companyName"),
			"page" => $this->input->post("page")
		);	
		$contacts = $this->Contact->searchContacts($data,25,0);
		echo json_encode($contacts);
	}
	



	public function allContacts($page){
		$data['contacts'] = $this->Contact->getContacts($page,25,0);
		$data['contactsCount'] = count($this->Contact->getContacts($page,0,0));
		$data['view'] = "contacts";
		$this->load->view('template', array("data"=>$data));
	}

	public function editContact($id){
		$data['companies']       = $this->Company->getCompanies(1,0);
		$data['contact']         = $this->Contact->getContact($id);
		$data['supervisor']      = $this->Contact->getContact($data['contact']->supervisorId);
		$data['companyContacts'] = $this->Contact->searchContacts(array("companyId" => $data['contact']->companyId));
		$data['view']            = "contact";
		$this->load->view('template', array("data"=>$data));
	}
	public function updateContact($id){
		$data = $this->input->post();
		$data['id'] = $id;
		$this->Contact->updateContact($data);
		redirect("editContact/".$id);	
	}

	public function removeContact($id){
		$this->Contact->removeContact($id);
		redirect("allContacts");
	}


	public function allUsers($page){
		$data['users'] = $this->User->getUsers($page);
		$data['view'] = "users";
		$this->load->view('template', array("data"=>$data));
	}

	public function editUser($id){
		$data['user']       = $this->User->getUser($id);
		$data['view']       = "user";
		$this->load->view('template', array("data"=>$data));
	}

	public function updateUser($id){
		$data = $this->input->post();
		$data['id'] = $id;
		$this->User->updateUser($data);
		redirect("editUser/".$id);	
	}
	public function addUser(){
		$data['view']       = "addUser";
		$this->load->view('template', array("data"=>$data));
	}
	public function addUserExecute(){
		$data = $this->input->post();
		$this->User->addUser($data);
		redirect("allUsers");	
	}
	public function removeUser($id){
		$this->User->removeUser($id);
		redirect("allUsers");
	}

	public function activateUser($id){
		$data["id"] = $id;
		$data["active"]=1;
		$this->User->updateUser($data);
		redirect("allUsers");
	}
	public function deactivateUser($id){
		$data["id"] = $id;
		$data["active"]=0;
		$this->User->updateUser($data);
		redirect("allUsers");
	}







}
