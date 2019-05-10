<?php

namespace SendPulseTest\Controllers;

use SendPulseTest\Components\View;

class BaseController
{

	public $route = [];

	public $view;

	public $layout;

	public $vars = [];

	public function __construct($route)
	{
		$this->route = $route[0];
		$this->view = $route[1];
	}

	public function getView()
	{
		$viewObj = new View($this->route, $this->layout, $this->view);
		$viewObj->render($this->vars);
	}

	public function set($vars)
	{
		$this->vars = $vars;
	}
}
