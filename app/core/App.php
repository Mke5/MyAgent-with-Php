<?php

defined('ROOTPATH') OR exit('Access Denied!');

class App
{
    private $controller = 'Home';
    private $method     = 'index';
    protected $params = [];

    public function __construct()
    {
        $this->loadController();
    }

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;    
    }

    // public function loadController()
    // {
    //     $URL = $this->splitURL();

    //     // Handle nested controllers (e.g., dashboard/listings)
    //     $controllerNamespace = '\\Controller';
    //     $controllerPath = "../app/controllers/";

        
    //     /** Select controller **/
    //     $filename = "../app/controllers/" . ucfirst($URL[0]) . ".php";
    //     if (file_exists($filename)) {
    //         require $filename;
    //         $this->controller = ucfirst($URL[0]);
    //         unset($URL[0]);
    //     } else {
    //         $filename = "../app/controllers/_404.php";
    //         require $filename;
    //         $this->controller = "_404";
    //     }

    //     // Instantiate the controller properly
    //     $controllerClass = '\\Controller\\' . $this->controller;
    //     $controller = new $controllerClass();

    //     /** Select method **/
    //     if (!empty($URL[1])) {
    //         if (method_exists($controller, $URL[1])) {
    //             $this->method = $URL[1];
    //             unset($URL[1]);
    //         }    
    //     }

    //     call_user_func_array([$controller, $this->method], $URL);
    // }

    public function loadController()
    {
        $URL = $this->splitURL();

        // Default controller
        $controllerName = !empty($URL[0]) ? ucfirst($URL[0]) : "Home";
        $filename = "../app/controllers/{$controllerName}.php";

        if (file_exists($filename)) {
            require_once $filename;
        } else {
            require_once "../app/controllers/_404.php";
            $controllerName = "_404";
        }

        // Instantiate the controller
        $controllerClass = "\\Controller\\{$controllerName}";
        if (!class_exists($controllerClass)) {
            die("Controller class '{$controllerClass}' not found.");
        }

        $controller = new $controllerClass();
        
        // Determine method (default: index)
        $method = !empty($URL[1]) && method_exists($controller, $URL[1]) ? $URL[1] : "index";

        // Sanitize request parameters (GET & POST)
        $params = array_values(array_filter($URL, fn($value) => !is_null($value) && $value !== ''));

        // Merge GET & POST parameters (prioritizing POST)
        $requestData = array_merge($_GET, $_POST);

        // Call the method with request data
        call_user_func_array([$controller, $method], [$requestData, ...$params]);
    }

}
