<?php

return [
    //Задачи
    'cabinet/edittask/([0-9]+)' => 'cabinet/edittask/$1',
    'cabinet/addsubtask/([0-9]+)' => 'cabinet/addsubtask/$1',
    'cabinet/deletetask/([0-9]+)' => 'cabinet/deletetask/$1',
    'cabinet/closetask/([0-9]+)' => 'cabinet/closetask/$1',
    'cabinet/addtask' => 'cabinet/addtask',
    'site/index' => 'site/index',
    '' => 'site/index',
    // Пользователь:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'user' => 'user/login',
    'cabinet' => 'cabinet/index'
];