<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');


class Signup extends Controller
{

	public function index()
	{

		$this->view('signup');
	}

}