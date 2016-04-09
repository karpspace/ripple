<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitTest extends CI_Controller {

	public function __construct(){
  	parent::__construct();
	
		$this->load->library('unit_test');
		$this->load->model('User');
		$this->load->model('Company');
		$this->load->model('Contact');

	}


	public function index()
	{

		//User Functions Tests

		$rand = rand(1,100);


		//Get Users Test
		$getUsersTest = $this->User->getUsers();
		$testName = 'Get Users Test';
		$this->unit->run($getUsersTest, 'is_object', $testName);


		//Create User Test
		$createUserTest = $this->User->addUser("user@user1.com".$rand, "password", "John", "Smith");
		$testName = 'Create User Test';
		$this->unit->run($createUserTest, "is_int", $testName, $createUserTest);

		//Correct Login Test
		$correctLoginTest = $this->User->authenticateUser("user@user1.com".$rand,"password");
		$testName = 'Correct Login Test';
		$this->unit->run($correctLoginTest, true, $testName, $correctLoginTest);

		///Incorrect Login Test
		$inCorrectLoginTest = $this->User->authenticateUser("user@user1.com".$rand,"passsword");
		$testName = 'InCorrect Login Test';
		$this->unit->run($inCorrectLoginTest, false, $testName);

		//Get Correct User

		$getUserTest = $this->User->getUser($createUserTest);
		$testName = 'Get User Test';
		$this->unit->run($getUserTest->email,"user@user1.com".$rand, $testName,$getUserTest->email);
		
		///Update User
		$updateUserTest = $this->User->updateUser($createUserTest,false, false, false,"password2");
		$testName = 'Update User Test';
		$this->unit->run($updateUserTest, true, $testName,$updateUserTest);

		//Correct Login Test
		$correctLoginTestAfterUpdate = $this->User->authenticateUser("user@user1.com".$rand,"password2");
		$testName = 'Correct Login Test after Update';
		$this->unit->run($correctLoginTestAfterUpdate, true, $testName);

		///Incorrect Login Test
		$inCorrectLoginTestAfterUpdate = $this->User->authenticateUser("user@user.com","passsword");
		$testName = 'InCorrect Login Test after Update ';
		$this->unit->run($inCorrectLoginTestAfterUpdate, false, $testName);

		//Remove User Test
		$removeUserTest = $this->User->removeUser($createUserTest);
		$testName = 'Remove User Test';
		$this->unit->run($removeUserTest, true, $testName, $removeUserTest);



		//Companies tests


		//Add Company test

		$addCompanyTest = $this->Company->addCompany("Test Company".$rand, "TCOMP".$rand,"",86,87);
		$testName = 'Add Company Test';
		$this->unit->run($addCompanyTest, "is_numeric", $testName, $addCompanyTest);


		//Get Company Test
		$getCompanyTest = $this->Company->getCompany($addCompanyTest);
		$testName = 'Get Company Test';
		$this->unit->run($getCompanyTest->companyName, "Test Company".$rand, $testName, $getCompanyTest->emergencyContactName);

		//Get Companies Test
		$getCompaniesTest = $this->Company->getCompanies($addCompanyTest);
		$testName = 'Get Companies Test';
		$this->unit->run($getCompaniesTest, 'is_array', $testName, count($getCompaniesTest));

		//Update Company Test
		$this->Company->updateCompany($addCompanyTest,"Test Company-2-".$rand,"TCO-MP2","Lorem Ipsum");
		$updateCompanyTest = $this->Company->getCompany($addCompanyTest);
		$testName = 'Update Companies Test';
		$this->unit->run(
			array(
				$updateCompanyTest->companyName,
				$updateCompanyTest->ref,
				$updateCompanyTest->natureOfBusiness
			),
			array(
				"Test Company-2-".$rand,
				"TCO-MP2",
				"Lorem Ipsum"
			), 
			$testName,
			$updateCompanyTest->companyName." ".$updateCompanyTest->ref." ".$updateCompanyTest->natureOfBusiness
		);

		//Remove Company test
		$removeCompanyTest = $this->Company->removeCompany($addCompanyTest);
		$testName = 'Remove Company Test';
		$this->unit->run($removeCompanyTest, true, $testName, $removeCompanyTest);

		//Single result search Company Test 
		$testResults = array();
		
		$astroOneId = $this->Company->addCompany("Astro One", "A1");
		$testResults['Name'] = $this->Company->searchCompany("Astro One");
		$testResults['Ref']  = $this->Company->searchCompany("", "A1");
		$testResults['Both'] = $this->Company->searchCompany("Astro One", "A1");
		$testName = 'Single result search Company Test';

		$this->unit->run(
			array( count($testResults['Name']), count($testResults['Ref']), count($testResults['Both']) ), 
			array(1,1,1),
			$testName, 
			count($testResults['Name']). " | " . count($testResults['Ref']) . " | " . count($testResults['Both'])
		);
		$this->Company->removeCompany($astroOneId);



		//Multiple result search Company Test 
		$testResults = array();
		
		$astroOneId = $this->Company->addCompany("Astro One", "A1");
		$astroTwoId = $this->Company->addCompany("Astro Two", "A2");
		$cosmosFourId = $this->Company->addCompany("Cosmos Four", "C4");
		$testResults['Name'] = $this->Company->searchCompany("Astro");
		$testResults['Ref']  = $this->Company->searchCompany("", "A");
		$testResults['Both'] = $this->Company->searchCompany("Astro", "A");
		$testResults['None'] = $this->Company->searchCompany("", "");
		$testName = 'Multiple result search Company Test';

		$this->unit->run(
			array( 
				count($testResults['Name']), 
				count($testResults['Ref']),
				count($testResults['None']),  
				count($testResults['Both']) ), 
			array(2,2,3,2),
			$testName, 
			count($testResults['Name']). " | " . count($testResults['Ref']) . " | " . count($testResults['None']). " | " . count($testResults['Both'])
		);
		$this->Company->removeCompany($astroOneId);
		$this->Company->removeCompany($astroTwoId);
		$this->Company->removeCompany($cosmosFourId);

		//Contacts Tests

		//Add Contact Test

		$astroOneId  = $this->Company->addCompany("Astro One", "A1");


		$johnSmithId = $this->Contact->addContact("Mr. ", "John", "Smith", "john@astroone.com", "123-456-788", "123-456-788", 	$astroOneId , $supervisorId=0, "CEO");
		$testName = 'Add Contact Test';
		$this->unit->run($johnSmithId, "is_numeric", $testName, $johnSmithId);

		//Get Contact Test
		$getContactTest = $this->Contact->getContact($johnSmithId);
		$testName = 'Get Contact Test';
		$this->unit->run(
			array(
				$getContactTest->title,
				$getContactTest->name,
				$getContactTest->surname,
				$getContactTest->email,
				$getContactTest->phone,
				$getContactTest->mobile,
				$getContactTest->position,
				$getContactTest->supervisorId,
				$getContactTest->companyId
			),
			array("Mr. ", "John", "Smith", "john@astroone.com", "123-456-788", "123-456-788", "CEO",0,	$astroOneId ), $testName,		
			  $getContactTest->title." ".
				$getContactTest->name." ".
				$getContactTest->surname." ".
				$getContactTest->email." ".
				$getContactTest->phone." ".
				$getContactTest->mobile." ".
				$getContactTest->position." ".
				$getContactTest->supervisorId." ".
				$getContactTest->companyId." ");

		//Get Contacts Test
		$getContactsTest = $this->Contact->getContacts();
		$testName = 'Get Contacts Test';
		$this->unit->run($getContactsTest, 'is_array', $testName, count($getContactsTest));



		//Update Test
		$this->Contact->updateContact($johnSmithId, "Mr. ", "Wayne", "Scott", "wayne@astroTwo.com", "312-456-788", "321-456-788", "CTO",1,	$astroOneId );
		$updateContactTest = $this->Contact->getContact($johnSmithId);
		$testName = 'Update Contact Test';
		$this->unit->run(
			array(
				$updateContactTest->title,
				$updateContactTest->name,
				$updateContactTest->surname,
				$updateContactTest->email,
				$updateContactTest->phone,
				$updateContactTest->mobile,
				$updateContactTest->position,
				$updateContactTest->supervisorId,
				$updateContactTest->companyId
			),
			array("Mr. ", "Wayne", "Scott", "wayne@astroTwo.com", "312-456-788", "321-456-788", "CTO",1,	$astroOneId ), $testName,		
			  $updateContactTest->title." ".
				$updateContactTest->name." ".
				$updateContactTest->surname." ".
				$updateContactTest->email." ".
				$updateContactTest->phone." ".
				$updateContactTest->mobile." ".
				$updateContactTest->position." ".
				$updateContactTest->supervisorId." ".
				$updateContactTest->companyId." ");



		//Single result search Contact Test 
		$testResults = array();
		$testResults['Name'] = $this->Contact->searchContacts(array('name'=>"Wayne"));
		$testResults['Surname'] = $this->Contact->searchContacts(array('surname'=>"Scott"));
		$testResults['Email'] = $this->Contact->searchContacts(array('email'=>"wayne@astroTwo.com"));
		$testResults['Phone'] = $this->Contact->searchContacts(array('phone'=>"312-456-788"));
		$testResults['Mobile'] = $this->Contact->searchContacts(array('mobile'=>"321-456-788"));
		$testResults['Position'] = $this->Contact->searchContacts(array('position'=>"CTO"));
		$testResults['CompanyName'] = $this->Contact->searchContacts(array('companyName'=>"Astro One"));
		$testResults['CompanyRef'] = $this->Contact->searchContacts(array('ref'=>"A1"));
		$testName = 'Single result search Company Test';

		$this->unit->run(
			array( 
				count($testResults['Name']),
				count($testResults['Surname']),
				count($testResults['Email']),
				count($testResults['Phone']),
				count($testResults['Mobile']),
				count($testResults['Position']),
				count($testResults['CompanyName']),
				count($testResults['CompanyRef']),
			 ), 
			array(1,1,1,1,1,1,1,1),
			$testName, 
			count($testResults['Name'])." | ".
				count($testResults['Surname'])." | ".
				count($testResults['Email'])." | ".
				count($testResults['Phone'])." | ".
				count($testResults['Mobile'])." | ".
				count($testResults['Position'])." | ".
				count($testResults['CompanyName'])." | ".
				count($testResults['CompanyRef'])
		);

		//Remove Contact test
		$removeContactTest = $this->Contact->removeContact($johnSmithId);
		$testName = 'Remove Contact Test';
		$this->unit->run($removeContactTest, true, $testName, $removeContactTest );

		//Multiple Search Contact
		$cosmosXId  = $this->Company->addCompany("Cosmos X", "CX");
		
		$johnStakeId = $this->Contact->addContact("Mr. ", "John", "Stake", "stake@astroone.com", "222-456-788", "123-336-443", 	$astroOneId , $supervisorId=0, "CEO");

		$mikeFerroId = $this->Contact->addContact("Mr. ", "Mike", "Ferro", "mike@astroone.com", "211-223-718", "423-456-443", 	$astroOneId , $supervisorId=0, "CTO");
		

		$georgeDeeId = $this->Contact->addContact("Mr. ", "George", "Dee", "frank@cosmos.com", "222-452-788", "123-443-138", 	$cosmosXId , $supervisorId=0, "CTO");
		

		$frankHollId = $this->Contact->addContact("Mr. ", "Frank", "Hool", "stake@cosmos.com", "222-456-788", "443-436-168", 	$cosmosXId , $supervisorId=0, "CEO");

		$testResults = array();
		$testResults['Name'] = $this->Contact->searchContacts(array('name'=>"o"));
		$testResults['Surname'] = $this->Contact->searchContacts(array('surname'=>"F"));
		$testResults['Email'] = $this->Contact->searchContacts(array('email'=>"astroone"));
		$testResults['Phone'] = $this->Contact->searchContacts(array('phone'=>"222"));
		$testResults['Mobile'] = $this->Contact->searchContacts(array('mobile'=>"443"));
		$testResults['Position'] = $this->Contact->searchContacts(array('position'=>"CTO"));
		$testResults['CompanyName'] =$this->Contact->searchContacts(array('companyName'=>"Astro One"));
		$testResults['CompanyRef'] = $this->Contact->searchContacts(array('ref'=>"A1"));
		$testName = 'Single result search Company Test';

		$this->unit->run(
			array( 
				count($testResults['Name']),
				count($testResults['Surname']),
				count($testResults['Email']),
				count($testResults['Phone']),
				count($testResults['Mobile']),
				count($testResults['Position']),
				count($testResults['CompanyName']),
				count($testResults['CompanyRef']),
			 ), 
			array(2,1,2,3,4,2,2,2),
			$testName, 
			count($testResults['Name'])." | ".
				count($testResults['Surname'])." | ".
				count($testResults['Email'])." | ".
				count($testResults['Phone'])." | ".
				count($testResults['Mobile'])." | ".
				count($testResults['Position'])." | ".
				count($testResults['CompanyName'])." | ".
				count($testResults['CompanyRef'])
		);
		


	  $this->Company->removeCompany($astroOneId);
	  $this->Company->removeCompany($cosmosXId);
	  $this->Contact->removeContact($johnStakeId);
	  $this->Contact->removeContact($mikeFerroId);
	  $this->Contact->removeContact($georgeDeeId);
	  $this->Contact->removeContact($frankHollId);



	  


		echo $this->unit->report();
	}


	











}
