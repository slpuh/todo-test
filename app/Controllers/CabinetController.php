<?php

use SendPulseTest\Controllers\BaseController;
use SendPulseTest\Models\Task;
use SendPulseTest\Models\User;

class CabinetController extends BaseController
{    
    
    public function index()
    {    
        $userId = User::checkLogged();        
        $user = User::getUserById($userId);          
        $this->set(['user' => $user]);                  
    }

    public function addTask()
    {    
                       
    }

    public function editTask()
    {    
                       
    }
}