<?php 

    namespace Controller;

    
    defined('ROOTPATH') OR exit('Access Denied!');
    use Core\Session;

    
class Dashboard extends Controller
{
    public function index()
    {
        $session = new Session();
        // Restrict access to logged-in users
        if (!$session->is_logged_in()) {
            redirect('signin'); // Redirect to login page if not logged in
        }

        $this->view('dashboard');
    }
}
