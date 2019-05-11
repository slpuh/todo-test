<?php

namespace SendPulseTest\Models;

use SendPulseTest\Components\Db;
use PDO;

class Task
{
    public static function allTaskByUser($userId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM tasks WHERE user_id = :userId ORDER BY finish';
        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->execute();
        $tasks = $result->fetchAll();

        return $tasks;
    }

    public static function addTask($userId, $title, $text, $finish, $parentId = false)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO tasks (title, text, user_id, parent_id, finish)'
            . 'VALUES (:title, :text, :userId, :parentId, :finish)';

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':parentId', $parentId, PDO::PARAM_INT);
        $result->bindParam(':finish', $finish, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function checkTitle($title)
    {
        if (strlen($title) > 0) {
            return true;
        }
        return false;
    }

    public static function checkTask($text)
    {
        if (strlen($text) >= 10) {
            return true;
        }
        return false;
    }

    public static function checkFinishDate($finish)
    {
        if (strlen($finish) > 0) {
            return true;
        }
        return false;
    }

    public static function checkFinishDateRel($finish)
    {
        $dateNow = date("Y-m-d H:i");
        if (strtotime($dateNow) <= strtotime($finish)) {
            return true;
        }
        return false;
    }

    public static function checkSubFinishDate($finish, $parentId)
    {
        $db = Db::getConnection();        

        $sql = 'SELECT * FROM tasks WHERE id = :parentId';
        $result = $db->prepare($sql);        
        $result->bindParam(':parentId', $parentId, PDO::PARAM_INT);
        $result->execute();
        $parentTask = $result->fetch();
        $parentTaskFinish = $parentTask['finish'];       
        
        if (strtotime($parentTaskFinish) >= strtotime($finish)) {
            return true;
        }
        return false;
    }

    public static function getTaskId()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $arr = explode('/', $uri);
        $taskId = array_pop($arr);
        return $taskId;
    }

    public static function getTask()
    {
        $taskId = self::getTaskId();

        $db = Db::getConnection();

        $sql = 'SELECT * FROM tasks WHERE id = :taskId';

        $result = $db->prepare($sql);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $result->execute();
        $task = $result->fetch();

        return $task;
    }

    public static function getParentTask($parentId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM tasks WHERE id = :parentId';

        $result = $db->prepare($sql);
        $result->bindParam(':parentId', $parentId, PDO::PARAM_INT);
        $result->execute();
        $parentTask = $result->fetch();

        return $parentTask;
    }

    public static function allSubTaskByUser($userId)
    {
        $db = Db::getConnection();

        $parentId = false;

        $sql = 'SELECT * FROM tasks WHERE user_id = :userId AND parent_id != :parentId ORDER BY finish';
        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':parentId', $parentId, PDO::PARAM_INT);
        $result->execute();
        $subTasks = $result->fetchAll();
        
        return $subTasks;
    }

    public static function editTask($taskId, $title, $text, $finish)
    {
        $db = Db::getConnection();       

        $sql = 'UPDATE tasks SET title = :title, text = :text, finish = :finish WHERE id = :taskId';
        $result = $db->prepare($sql);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':finish', $finish, PDO::PARAM_STR);        
        $result->execute();
    }

    public static function deleteTask($taskId)
    {
        $db = Db::getConnection();       

        $sql = 'DELETE FROM tasks WHERE id = :taskId OR parent_id = :taskId';
        $result = $db->prepare($sql);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);        
        $result->execute();
    }
}
