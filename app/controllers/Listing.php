<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');


class Listing extends Controller
{

	public function index()
	{

		$this->view('listing');
	}

}
