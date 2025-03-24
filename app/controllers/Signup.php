<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){

			if(!$session->validate_csrf($_POST['csrf_token'])){
				$session->set('signup', 'Invalid Login');
				redirect('signin');
				die();
			}
			$data = [];
			
			$data['email'] = esc(trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)));
			$data['password'] = $_POST['password'];
			$data['fname'] = esc(trim(filter_var($_POST['fname'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['lname'] = esc(trim(filter_var($_POST['lname'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$image = $_FILES['image'];
			
			$session->set('last_email', $data['email']);
			$session->set('fname', $data['fname']);
			$session->set('lname', $data['lname']);

			try{$user->validate($_POST);
			}catch (\Exception $e){
				$session->set('signup', $e->getMessage());
				redirect('signup');
				exit;
			}

			try {
				$user->create($data, $image);
				$session->set('signin-s', 'Account created successfully. You can now login');

				$session->set('last_email', '');
				$session->set('fname', '');
				$session->set('lname', '');

				redirect('signin');
				exit;
			} catch (\Exception $e) {
				$session->set('signup', $e->getMessage());
				redirect('signup');
				exit;
			}
		}else{
			redirect('signup');
			die();
		}
	}
}