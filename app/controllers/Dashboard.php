<?php 

    namespace Controller;

    
    defined('ROOTPATH') OR exit('Access Denied!');
    use Core\Session;

    
class Dashboard extends Controller
{
    public function index()
    {
        $session = new Session();
        if (!$session->is_logged_in()) {
            redirect('signin');
        }

        $this->view('dashboard/index');
    }

    public function createlisting(){
        $session = new Session();
        if (!$session->is_logged_in()) {
            redirect('signin');
        }

        $this->view('dashboard/createlisting');
    }

    public function searchlisting()
    {
        $session = new Session();
        if (!$session->is_logged_in()) {
            redirect('signin');
        }

        $this->view('dashboard/searchlisting');
    }

    public function viewusers(){
        $session = new Session();
        if (!$session->is_logged_in()) {
            redirect('signin');
        }

        $this->view('dashboard/user');
    }

    public function listings(){
        $session = new Session();
        if (!$session->is_logged_in()) {
            redirect('signin');
        }

        $this->view('dashboard/listings');
    }

    public function search() {
        $session = new Session();
        if (!$session->is_logged_in()) {
            redirect('signin');
        }

        $this->view('dashboard/search');
    }

}
