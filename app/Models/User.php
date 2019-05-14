<?php

namespace SendPulseTest\Models;

use SendPulseTest\Components\Db;
use PDO;

class User
{
    //Регистрация пользователя
    public static function register($name, $email, $password)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO users (name, email, password) '
            . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    //Валидация пароля при залогинивании
    public static function validatePassword($email)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT email, password FROM users');

        $rowsArray = $result->fetchAll();

        foreach ($rowsArray as $item) {
            if ($email == $item['email']) {
                $hash = $item['password'];
            }
        }
        if (isset($hash)) {
            return $hash;
        } else {
            return false;
        }
    }

    //Проверка данных пользователя при залогинивании
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE email = :email';

        $result = $db->prepare($sql);

        $hash = self::validatePassword($email);

        $password = password_verify($password, $hash);

        if ($password) {
            $result->bindParam(':email', $email, PDO::PARAM_STR);

            $result->execute();

            $user = $result->fetch();
            if ($user) {
                return $user['id'];
            }
        }

        return false;
    }

    //Сессия
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    //Проверка авторизирован ли пользователь
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }
    
    //Проверка длины логина при регистрации
    public static function checkName($name)
    {
        if (strlen($name) <= 4  || strlen($name) >= 20) {
            return false;
        }
        return true;
    }    

    //Проверка длины пароля при авторизации/регистрации
    public static function checkPassword($password)
    {
        if (strlen($password) <= 6 || strlen($password) >= 20) {
            return false;
        }
        return true;
    }

    //Проверка длины email при авторизации/регистрации
    public static function checkEmailLen($email)
    {
        if (strlen($email) <= 30) {
            return true;
        }
        return false;
    }

    //Проверка валидности email при авторизации/регистрации
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    //Проверка есть ли email при авторизации/регистрации
    public static function checkEmailExists($email)
    {

        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    //Проверка есть ли логин при авторизации
    public static function checkNameExists($name)
    {

        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM users WHERE name = :name';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    //Получение id пользователя
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();

            $sql = 'SELECT * FROM users WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }
}
