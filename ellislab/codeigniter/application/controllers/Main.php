<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
  				

	public $data = array(); // Array with all data passed to view

	public function __construct(){
  		parent::__construct();

  		$this->load->library('unit_test');


	}


	public function index()
	{

		//Is user logged?

		//If yes then load view.

		//check URI

		//select Data

		//return view with data
		//$this->load->view('welcome_message', $this->data);


	}











}
