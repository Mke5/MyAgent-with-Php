<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use Core\Session;

class Listing extends Controller
{

	public function index()
	{

		$this->view('listing');
	}

	public function createlisting(){
		$session = new Session();

		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
			if(!$session->validate_csrf($_POST['csrf_token'])){
				$session->set('signup', 'Invalid Login');
				redirect('signin');
				die();
			}

			$data = [];
		}else{
			redirect('dashboard/createlisting');
			die();
		}	
	}
}
