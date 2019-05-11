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
                $errors[] = 'Name must not be shorter than 2 characters';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Wrong email';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Password must not be shorter than 6 characters';
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }

            if (User::checkEmailExists($email) || User::checkNameExists($name)) {
                $errors[] = 'This email or name is already in use';
            }

            if ($errors == []) {
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
                $errors[] = 'Wrong email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Password must not be shorter than 6 characters';
            }

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Incorrect login details';
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
