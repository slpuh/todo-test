<?php

//namespace SendPulseTest\Controllers;

use SendPulseTest\Controllers\BaseController;
use SendPulseTest\Models\User;

class CabinetController extends BaseController
{
    public function index()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);        
        
        return $this->view->render('cabinet/index.php', 'layouts/template.php', $user);        
    }
}