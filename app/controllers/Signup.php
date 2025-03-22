<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');


use App\Models\User;
use Core\Session;

class Signup extends Controller
{

	public function index()
	{

		$this->view('signup');
	}

}