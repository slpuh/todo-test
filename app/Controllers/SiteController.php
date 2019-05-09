<?php

//namespace SendPulseTest\Controllers;

use SendPulseTest\Controllers\BaseController;
use SendPulseTest\Models\User;

class SiteController extends BaseController
{
    public function index()
    {
        
        return $this->view->render('site/index.php', 'layouts/template.php');        
    }
}