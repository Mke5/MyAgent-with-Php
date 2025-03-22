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

	public function register(){
		$user = new User();
		$session = new Session();


		if($_SERVER['REQUEST_METHOD'] === 'Post' && isset($_POST['submit'])){

			if(!$session->validate_csrf($_POST['csrf_token'])){
				$session->set('signup', 'Invalid Login');
				redirect('signin');
				die();
			}


		}
	}
}