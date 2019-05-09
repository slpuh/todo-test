<?php

namespace SendPulseTest\Components;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = __DIR__ . '/../../config/routes.php';
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
            
            if ($uriPattern == $uri) {
                
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);                
                
                $segments = explode('/', $internalRoute);
                
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';                
                
                $actionName = array_shift($segments);
                
                $parameters = $segments;
                
                $controllerFile = __DIR__ . '/../Controllers/' .
                    $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }
                
                $controllerObject = new $controllerName;

                $result = call_user_func_array([$controllerObject, $actionName], $parameters);
                     
                if ($result != null) {
                    break;
                }
            }
        }
    }
}
