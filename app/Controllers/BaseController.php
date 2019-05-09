<?php

namespace SendPulseTest\Controllers;

use SendPulseTest\Components\View;

class BaseController
{
	public $view;
	public $model;
	
	function __construct()
	{
		$this->view = new View();
	}
}