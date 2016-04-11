<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends CI_Controller {

	public function __construct(){
  	parent::__construct();
	
		$this->load->library('unit_test');
		$this->load->model('User');
		$this->load->model('Company');
		$this->load->model('Contact');

	}


	public function companies()
	{

		//User Functions Tests

		
		$namePartOne = array('Mercury', 'Venus','Earth','Mars','Jupiter','Saturn','Neptune','Uranus'); 
		$namePartTwo = array('Journey', 'Expedition','Eclipse','VR');

		for($i=0;$i<50;$i++){
			$companyNamePartOne = $namePartOne[rand(0,7)];
			$companyNamePartTwo = $namePartTwo[rand(0,3)];
			$companyNamePartThree = rand(2000,2060);;
			$companyName = $companyNamePartOne. " ". $companyNamePartTwo ." ". $companyNamePartThree;
			$companyRef = strtoupper ($companyNamePartOne[0].substr($companyNamePartTwo,0,3).$companyNamePartThree);
			$addCompanyTest = $this->Company->addCompany(array("companyName" => $companyName, "ref" => $companyRef));
		}

	}

	public function contacts(){
		$titleArray = array("sir", "Mr.");
		$positionArray = array("pilot","navigator","engineer","captain");
		$namePartOne = array('Pete', 'Alan','Alan','Edgar','David','James','Irwin','John','Charles','Eugene','Harrison','Neil','Buzz'); 
		$namePartTwo = array('Conrad', 'Bean','Shepard','Mitchell','Scott','Irwin','Irwin','Young','Duke','Cernan','Schmitt','Armstrong','Aldrin');
		$companies = $this->Company->getCompanies(1,0	);
		$numberOfCompanies = count($companies);

		for($i=0;$i<400;$i++){
			$title = $titleArray[rand(0,1)];
			$position = $positionArray[rand(0,3)];
			$name = $namePartOne[rand(0,12)];
			$surname = $namePartTwo[rand(0,12)];
			$companyId = rand(0,$numberOfCompanies-1);

			$company = $this->Company->getCompany($companies[$companyId]->id);
		
			$email = strtolower(substr($name,0,1).".".$surname."@".str_replace(' ', '', $company->companyName).".com");

			$phone=rand(100,999)."-".rand(100,999)."-".rand(100,999);
			$mobile=rand(100,999)."-".rand(100,999)."-".rand(100,999);

			

			$this->Contact->addContact(
				array("title" =>$title, "name"=> $name,  "surname" => $surname, "email" => $email,"phone" => $phone, "mobile"=> $mobile, "companyId" => $companies[$companyId]->id, "supervisorId"=>0, "position"=>$position,"notes"=>"Notes, lorem ipsum."
				));
		}


		$this->connectContacts();
		
	}


	public function connectContacts(){

			$companies = $this->Company->getCompanies(1,0);
		//	echo "Number of companies: " . count($companies)."<br/>";
			$numberOfCompanies = count($companies);
			foreach ($companies as $company) {
				$employees = $this->Contact->searchContacts(array("companyName"=>$company->companyName));
				//echo $this->db->last_query()."<br/>";
				$numberOfEmployees = count($employees);
			//	echo "Number of employees: " . $numberOfEmployees."<br/>";

				$emergencyContactId = rand(0,$numberOfEmployees-1);
				$keyContactId = rand(0,$numberOfEmployees-1);
				$keyContactInBuilding = rand(0,1);
				$this->Company->updateCompany(
					array(
						"keyContactId"=>$employees[$keyContactInBuilding]->id,
						"keyContactInBuilding"=>$keyContactInBuilding,
						"emergencyContactId"=>$employees[$emergencyContactId]->id,
						"id"=>$company->id));
	
			}

		}

		public function connectSupervisors(){

			$contacts = $this->Contact->getContacts(1,0);
			
			foreach ($contacts as $contact) {

				$employees = $this->Contact->searchContacts(array("companyName"=>$contact->companyName));
				$numberOfEmployees = count($employees);
				$supervisorId = rand(0,$numberOfEmployees-1);
				$this->Contact->updateContact(
					array(
						"supervisorId"=>$employees[$supervisorId]->id,
						"id"=>$contact->id));
			}

		

		}

		public function regenerate(){
			$this->db->empty_table("Companies");
			$this->db->empty_table("Contacts");
			$this->companies();
			$this->contacts();
			$this->connectContacts();
			$this->connectSupervisors();
		}
}
