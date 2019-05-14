<?php

use SendPulseTest\Controllers\BaseController;
use SendPulseTest\Models\Task;
use SendPulseTest\Models\User;

class CabinetController extends BaseController
{

    public function index()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $tasks = Task::allTaskByUser($userId);
        $subTasks = Task::allSubTaskByUser($userId);

        $this->set([
            'user' => $user,
            'tasks' => $tasks,
            'subTasks' => $subTasks,
        ]);
    }

    public function addTask()
    {
        $userId = $_SESSION["user"];
        $title = '';
        $text = '';
        $finish = '';

        if (($_POST)) {

            $title = $_POST['title'];
            $text = $_POST['text'];
            $finish = $_POST['finish'];
            $errors = [];

            if (!Task::checkTitle($title)) {
                $errors[] = 'Title field must contain at least 4 characters and maximum 50';
            }

            if (!Task::checkTask($text)) {
                $errors[] = 'Task field must contain at least 10 characters and maximum 300';
            }

            if (!Task::checkFinishDate($finish)) {
                $errors[] = 'Expiration date field cannot be empty';
            }

            if (!Task::checkFinishDateRel($finish) && Task::checkFinishDate($finish)) {
                $errors[] = 'Tasks can only be installed in the future';
            }

            if (empty($errors)) {
                Task::addTask($userId, $title, $text, $finish);
                header("Location: /cabinet");
            } else {
                $this->set(['errors' => $errors]);
            }
        }
    }

    public function addSubTask()
    {
        $title = '';
        $text = '';
        $finish = '';
        $parentId = Task::getTaskId();
        $errors = [];

        if (($_POST)) {

            $title = $_POST['title'];
            $text = $_POST['text'];
            $finish = $_POST['finish'];
            $userId = $_SESSION["user"];


            if (!Task::checkTitle($title)) {
                $errors[] = 'Title field must contain at least 4 characters and maximum 20';
            }

            if (!Task::checkTask($text)) {
                $errors[] = 'Task field must contain at least 10 characters and maximum 300';
            }

            if (!Task::checkFinishDate($finish)) {
                $errors[] = 'Expiration date field cannot be empty';
            }

            if (!Task::checkFinishDateRel($finish) && Task::checkFinishDate($finish)) {
                $errors[] = 'Tasks can only be installed in the future';
            }

            if (!Task::checkSubFinishDate($finish, $parentId)) {
                $errors[] = 'The subtask can not be later than the task';
            }

            if (empty($errors)) {
                Task::addTask($userId, $title, $text, $finish, $parentId);
                header("Location: /cabinet");
            }
        }

        $parentTask = Task::getParentTask($parentId);
        $this->set([
            'parentTask' => $parentTask,
            'errors' => $errors
        ]);
    }

    public function editTask()
    {
        $task = Task::getTask();
        $taskId = $task['id'];
        $errors = [];

        if (($_POST)) {

            $title = $_POST['title'];
            $text = $_POST['text'];
            $finish = $_POST['finish'];

            if (!Task::checkTitle($title)) {
                $errors[] = 'Title field must contain at least 4 characters and maximum 20';
            }

            if (!Task::checkTask($text)) {
                $errors[] = 'Task field must contain at least 10 characters and maximum 300';
            }

            if (!Task::checkFinishDate($finish)) {
                $errors[] = 'Expiration date field cannot be empty';
            }

            if (!Task::checkFinishDateRel($finish) && Task::checkFinishDate($finish)) {
                $errors[] = 'Tasks can only be installed in the future';
            }

            if ($task['parent_id'] != 0) {
                $parentId = $task['parent_id'];
                if (!Task::checkSubFinishDate($finish, $parentId)) {
                    $errors[] = 'The subtask can not be later than the task';
                }                 
            
                if (!Task::checkParentTaskFinishDate($finish, $taskId)) {
                    $errors[] = 'Task cannot be completed before subtask';
                }
            }            

            if (empty($errors)) {
                Task::editTask($taskId, $title, $text, $finish);
                header("Location: /cabinet");
            }
        }
        $this->set([
            'task' => $task,
            'errors' => $errors
        ]);
    }

    public function closeTask()
    {
        $taskId = Task::getTaskId();
        
        Task::closeTask($taskId);
        header("Location: /cabinet");
    }

    public function deleteTask()
    {
        $taskId = Task::getTaskId();
        Task::deleteTask($taskId);
        header("Location: /cabinet");
    }
}