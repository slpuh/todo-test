<?php

namespace SendPulseTest\Components;

class View
{
    public $route = []; 
    
    public $view;    
    
    public $layout;  
    
    public function __construct($route, $layout = '', $view = '') {        
        
        $this->route = $route;
        
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ? : LAYOUT;
        }        
        $this->view = $view;
    }

    public function render($vars){
        
        if(is_array($vars)) extract($vars);

        $file_view = VIEW . "/{$this->route}/{$this->view}.php";
        
        ob_start();
        {
            if (is_file($file_view)) {
                require $file_view;
            } 

            $content = ob_get_contents();
        }
        ob_clean();

        $file_layout = VIEW . '/layouts/' . LAYOUT . '.php';

        require  $file_layout;
    }    
}