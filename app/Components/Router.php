<?php

namespace SendPulseTest\Components;

class Router
{
    private $routes;   

    public function __construct()
    {
        $routesPath  = __DIR__ . '/../../config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        
    }

    public function run()
    {
        $uri = $this->getURI();
        
        foreach ($this->routes as $uriPattern => $path) {
            
            if (preg_match("~$uriPattern~", $uri)) {
                
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);                
                
                $segments = explode('/', $internalRoute);               
                
                $route = $segments;

                $controllerName = ucfirst(array_shift($segments)) . 'Controller';                
                
                $action = array_shift($segments);               
                
                $controllerFile = APP.'/Controllers/' .
                    $controllerName . '.php';                    

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }
                
                $controllerObj = new $controllerName($route);

                if (method_exists($controllerObj, $action))
		        {			
                    $controllerObj->$action();
                    $controllerObj->getView();
                    break;                    
		        }  
                               
            } 
        }
    }    
}