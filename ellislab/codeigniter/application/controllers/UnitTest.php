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
		$getUsersTest = $this->User->getUsers(1,0);
		$testName = 'Get Users Test';
		$this->unit->run($getUsersTest, 'is_array', $testName);


		//Create User Test
		$createUserTest = $this->User->addUser(array("email"=> "user@user1.com".$rand, "password" =>"password", "name" => "John","surname" => "Smith"));
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
		$updateUserTest = $this->User->updateUser(array("id"=>$createUserTest,"email"=> "user@user1.com".$rand, "password" =>"password2", "name" => "John","surname" => "Smith"));
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

		$addCompanyTest = $this->Company->addCompany(
			array(
			"companyName" =>"Test Company".$rand,
			"ref" => "TCOMP".$rand,
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			)
		);
		$testName = 'Add Company Test';
		$this->unit->run($addCompanyTest, "is_numeric", $testName, $addCompanyTest);


		//Get Company Test
		$getCompanyTest = $this->Company->getCompany($addCompanyTest);
		$testName = 'Get Company Test';
		$this->unit->run($getCompanyTest->companyName, "is_string", $testName);

		//Get Companies Test
		$getCompaniesTest = $this->Company->getCompanies(1,0);
		$testName = 'Get Companies Test';
		$this->unit->run($getCompaniesTest, 'is_array', $testName, count($getCompaniesTest));

		//Update Company Test
		$this->Company->updateCompany(array(
			"id" =>$addCompanyTest,
			"companyName" =>"132",
			"ref" => "113",
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0));
		$updateCompanyTest = $this->Company->getCompany($addCompanyTest);
		$testName = 'Update Companies Test';
		$this->unit->run(
			array(
				$updateCompanyTest->companyName,
				$updateCompanyTest->ref,
			),
			array(
				"132",
				"113"
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
		
		$astroOneId = $this->Company->addCompany( array(
			"companyName" =>"Astro One".$rand,
			"ref" => "A1".$rand,
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			) );
		$testResults['Name'] = $this->Company->searchCompany("Astro One","",1);
		$testResults['Ref']  = $this->Company->searchCompany("", "A1",1);
		$testResults['Both'] = $this->Company->searchCompany("Astro One", "A1",1);
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
		
		$astroOneId = $this->Company->addCompany( array(
			"companyName" =>"Astro One",
			"ref" => "AKK1",
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			) );
		$astroTwoId = $this->Company->addCompany( array(
			"companyName" =>"Astro Two",
			"ref" => "AKK2",
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			) );
		$cosmosFourId = $this->Company->addCompany( array(
			"companyName" =>"Cosmos Four",
			"ref" => "COS3",
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			) );
		$testResults['Name'] = $this->Company->searchCompany("Astro","",1);
		$testResults['Ref']  = $this->Company->searchCompany("", "AKK",1);
		$testResults['Both'] = $this->Company->searchCompany("Astro","AKK",1);
		$testName = 'Multiple result search Company Test';

		$this->unit->run(
			array( 
				count($testResults['Name']), 
				count($testResults['Ref']),
				count($testResults['Both'])),
			array(2,2,2),
			$testName, 
			count($testResults['Name']). " | " . count($testResults['Ref']) . " | " . count($testResults['Both'])
		);
		$this->Company->removeCompany($astroOneId);
		$this->Company->removeCompany($astroTwoId);
		$this->Company->removeCompany($cosmosFourId);

		//Contacts Tests

		//Add Contact Test

		$astroOneId = $this->Company->addCompany( array(
			"companyName" =>"Astro One",
			"ref" => "TCOMP".$rand,
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			) );


		$johnSmithId = $this->Contact->addContact(
			array(
				"title" => "Mr. ","name" => "John","surname" => "Smith", "email" => "john@astroone.com","phone"=> "123-456-788", "mobile"=> "123-456-788", 	"companyId" => $astroOneId , "supervisorId" =>0,"position" => "CEO"));
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
		$getContactsTest = $this->Contact->getContacts(1,0);
		$testName = 'Get Contacts Test';
		$this->unit->run($getContactsTest, 'is_array', $testName, count($getContactsTest));



		//Update Test
		$this->Contact->updateContact(array(
				"title" => "1","name" => "1","surname" => "1", "email" => "1","phone"=> "1", "mobile"=> "1", 	"companyId" => 1, "supervisorId" =>1,"position" => "1", "id"=>$johnSmithId));
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

			),
			array("1", "1", "1", "1", "1", "1", "1", "1"), $testName,		
			  $updateContactTest->title."1 ".
				$updateContactTest->name."2 ".
				$updateContactTest->surname."3 ".
				$updateContactTest->email."4 ".
				$updateContactTest->phone."5 ".
				$updateContactTest->mobile."6 ".
				$updateContactTest->position."7 ".
				$updateContactTest->supervisorId."8 "
				);



		//Single result search Contact Test 
		$testResults = array();
		$testResults['Name'] = $this->Contact->searchContacts(array('name'=>"1"));
		$testResults['Surname'] = $this->Contact->searchContacts(array('surname'=>"1"));
		$testResults['Email'] = $this->Contact->searchContacts(array('email'=>"1"));
		$testResults['Phone'] = $this->Contact->searchContacts(array('phone'=>"1"));
		$testResults['Mobile'] = $this->Contact->searchContacts(array('mobile'=>"1"));
		$testResults['Position'] = $this->Contact->searchContacts(array('position'=>"1"));
		$testResults['CompanyName'] = $this->Contact->searchContacts(array('companyName'=>"1"));
		$testResults['CompanyRef'] = $this->Contact->searchContacts(array('ref'=>"1"));
		$testName = 'Single result search Company Test';

		$this->unit->run(
			$testResults, 
			"isarray",
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
		$cosmosXId  = $this->Company->addCompany( array(
			"companyName" =>"Cosmos Four",
			"ref" => "TCOMP".$rand,
			"emergencyContactId" => 0,
			"keyContactInBuilding" => 0,
			"keyContactId" => 0
			) );
		
		$johnStakeId = $this->Contact->addContact(	array(
				"title" => "Mr. ","name" => "John1","surname" => "Smith", "email" => "john1@astroone.com","phone"=> "123-456-788", "mobile"=> "123-456-788", 	"companyId" => $astroOneId , "supervisorId" =>0,"position" => "CEO"));

		$mikeFerroId = $this->Contact->addContact(	array(
				"title" => "Mr. ","name" => "John2","surname" => "Smith", "email" => "john2@astroone.com","phone"=> "123-456-788", "mobile"=> "123-456-788", 	"companyId" => $astroOneId , "supervisorId" =>0,"position" => "CEO"));
		

		$georgeDeeId = $this->Contact->addContact(	array(
				"title" => "Mr. ","name" => "John3","surname" => "Smith", "email" => "john3@astroone.com","phone"=> "123-456-788", "mobile"=> "123-456-788", 	"companyId" => $astroOneId , "supervisorId" =>0,"position" => "CEO"));
		

		$frankHollId = $this->Contact->addContact(	array(
				"title" => "Mr. ","name" => "John4","surname" => "Smith", "email" => "john4@astroone.com","phone"=> "123-456-788", "mobile"=> "123-456-788", 	"companyId" => $astroOneId , "supervisorId" =>0,"position" => "CEO"));

		$testResults = array();
		$testResults['Name'] = $this->Contact->searchContacts(array('name'=>"John1"));
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
			"is_array",
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
