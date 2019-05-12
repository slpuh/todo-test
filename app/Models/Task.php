<?php

namespace SendPulseTest\Models;

use SendPulseTest\Components\Db;
use PDO;

class Task
{
    //Список задач пользователя
    public static function allTaskByUser($userId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM tasks WHERE user_id = :userId ORDER BY finish';
        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->execute();
        $tasks = $result->fetchAll();

        $dateNow = date("Y-m-d H:i");
        foreach ($tasks as $task) {
            if (strtotime($dateNow) >= strtotime($task['finish'])) {
                self::closeTask($task['id']);
            }
        }   
        
        return $tasks;
    }

    //Получение Id задачи
    public static function getTaskId()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $arr = explode('/', $uri);
        $taskId = array_pop($arr);
        return $taskId;
    }

    //Получение отдельной задачи
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

    //Получение родительской задачи
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

    //Получение подзадач
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

    //Добавление задачи
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

    //Редактирование задачи
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

    //Удаление задачи (и подзадач, если есть)
    public static function deleteTask($taskId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM tasks WHERE id = :taskId OR parent_id = :taskId';
        $result = $db->prepare($sql);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $result->execute();
    }

    //Проеверка заголовка на длину
    public static function checkTitle($title)
    {
        if (strlen($title) >= 4) {
            return true;
        }
        return false;
    }

    //Проверка задачи на длину
    public static function checkTask($text)
    {
        if (strlen($text) >= 10) {
            return true;
        }
        return false;
    }

    //Проверка заполнения поля дата
    public static function checkFinishDate($finish)
    {
        if (strlen($finish) > 0) {
            return true;
        }
        return false;
    }

    //Проверка даты на то, что дата позже нестоящей
    public static function checkFinishDateRel($finish)
    {
        $dateNow = date("Y-m-d H:i");
        if (strtotime($dateNow) <= strtotime($finish)) {
            return true;
        }
        return false;
    }

    //Проверка даты позадачи на то, что она не больше даты основной задачи
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

    //Проверка, чтобы дата при редактировании задачи родителя не была меньше даты подзадач
    public static function checkParentTaskFinishDate($finish, $taskId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM tasks WHERE parent_id = :taskId';
        $result = $db->prepare($sql);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $result->execute();
        $subTasks = $result->fetchAll();

        foreach ($subTasks as $subTask) {
            $subTaskFinish = $subTask['finish'];
            if (strtotime($subTaskFinish) <= strtotime($finish)) {
                return true;
            }
            return false;
        }
    }
    //Получение Id родителя
    public static function getParentId($taskId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT parent_id FROM tasks WHERE id = :taskId';
        $result = $db->prepare($sql);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $result->execute();
        $parentId = $result->fetch();

        return $parentId;
    }

    //Закрытие задач
    public static function closeTask($taskId)
    {
        $a = [];

        $db = Db::getConnection();

        $status = false;
        $sql = 'UPDATE tasks SET status = :status WHERE id = :taskId OR parent_id = :taskId';
        $result = $db->prepare($sql);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $result->execute(); 

       $parentId = self::getParentId($taskId);
       
        if ($parentId['parent_id'] != 0) {
            $sql = 'SELECT * FROM tasks WHERE parent_id = :subTasks';
            $result = $db->prepare($sql);
            $result->bindParam(':subTasks', $parentId['parent_id'], PDO::PARAM_INT);
            $result->execute();
            $subTasks = $result->fetchAll();

            
            foreach ($subTasks as $subTask) {
                if ($subTask['status'] == 1) {
                    $a[] = $subTask['status'];
                }
            }
         }
        
        if (empty($a) && $parentId['parent_id'] != 0) {
                $sql = 'UPDATE tasks SET status = :status WHERE id = :taskId';
                $result = $db->prepare($sql);
                $result->bindParam(':status', $status, PDO::PARAM_INT);
                $result->bindParam(':taskId', $parentId['parent_id'], PDO::PARAM_INT);
                $result->execute();        
     }
    }
}