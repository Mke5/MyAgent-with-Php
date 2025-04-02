<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use Core\Session;

class Listings extends Controller
{

	public function index()
	{

		$this->view('listing');
	}

	public function createlisting(){
		$session = new Session();
		$listing = new \App\Models\Listing();

		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
			if(!$session->validate_csrf($_POST['csrf_token'])){
				$session->set('signup', 'Invalid Login');
				redirect('signin');
				die();
			}

			$data = [];

			try{
				$listing->validate($_POST);
			}catch (\Exception $e){
				$session->set('listing', $e->getMessage());
				redirect('dashboard/createlisting');
				exit;
			}

			$data['type'] = esc(trim(filter_var($_POST['type'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['description'] = esc(trim(filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['sittingroom'] = esc(trim(filter_var($_POST['sittingroom'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['bathroom'] = esc(trim(filter_var($_POST['bathroom'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['bedroom'] = esc(trim(filter_var($_POST['bedroom'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['kitchen'] = esc(trim(filter_var($_POST['kitchen'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['price'] = esc(trim(filter_var($_POST['price'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['category'] = esc(trim(filter_var($_POST['category'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['user_id'] = esc(trim(filter_var($_POST['user_id'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['state'] = esc(trim(filter_var($_POST['state'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['lga'] = esc(trim(filter_var($_POST['lga'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$data['address'] = esc(trim(filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS)));
			$images = $_FILES['image'];


			try{
				$listing->create($data, $images);
				$session->set('listing-s', 'Listing created successfully');
				redirect('dashboard/index');
				exit;
			}catch (\Exception $e){
				$session->set('listing', $e->getMessage());
				redirect('dashboard/createlisting');
				exit;
			}

		}else{
			redirect('dashboard/createlisting');
			die();
		}	
	}
}
