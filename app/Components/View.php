<?php

namespace SendPulseTest\Components;

class View
{
    public function render($content, $template, $data = null)    {
        
        include  __DIR__ . '/../../views/' . $template;
    }
}