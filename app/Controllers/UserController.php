<?php

use SendPulseTest\Controllers\BaseController;
use SendPulseTest\Models\User;

class UserController extends BaseController
{

    public function register()
    {
        $name = '';
        $email = '';
        $password = '';
        $result = false;

        if ($_POST) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = [];

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }

            if (User::checkEmailExists($email) || User::checkNameExists($name)) {
                $errors[] = 'Такой email или имя уже используются';
            }

            if ($errors == false) {
                $result = User::register($name, $email, $password); 
                               
            }
            $this->set(['result' => $result, 'errors' => $errors]);            
        }
           
         
    }

    public function login()
    {
        $email = '';
        $password = '';

        if ($_POST) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $errors = [];

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {

                User::auth($userId);

                header("Location: /cabinet");
            }
            if ($errors) {
                $this->set(['errors' => $errors]);  
            }
        }
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
