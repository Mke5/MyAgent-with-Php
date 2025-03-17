<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');


class Search extends Controller
{

	public function index()
	{

		$this->view('search');
	}

}