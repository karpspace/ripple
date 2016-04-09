<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitTest extends CI_Controller {

	public function __construct(){
  	parent::__construct();
	
		$this->load->library('unit_test');
		$this->load->model('User');

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







			





		echo $this->unit->report();
	}


	











}
