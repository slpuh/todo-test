<?php

//namespace SendPulseTest\Controllers;

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

            $errors = false;

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
                return $this->view->render('cabinet/index.php', 'layouts/template.php');
            }
        }

        return $this->view->render('user/register.php', 'layouts/template.php');
    }

    public function login()
    {

        $email = '';
        $password = '';

        if ($_POST) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $errors = false;

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
        }
        return $this->view->render('user/login.php', 'layouts/template.php');
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
