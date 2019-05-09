<?php

//namespace SendPulseTest\Controllers;

use SendPulseTest\Controllers\BaseController;

class SiteController extends BaseController
{
    public function index()
    {
        
        return $this->view->render('site/index.php', 'layouts/template.php');        
    }
}