<?php

namespace Application\Controllers;

use Application\Core\Controller;

class TaskController extends Controller
{
    const PATH = 'tasks/tasks';

    const DEFAULT_STATUS = false;

    public function index()
    {
        if (!isset($_COOKIE['id'])) {
            setcookie('id', 1);
        }

        foreach ($_COOKIE as $key => $value) {
            if (strpos($key, 'task') !== false) {
                $task = unserialize($value, ["allowed_classes" => false]);
                $task['name'] = $key;
                $tasks[] = $task;
            }
        }

        if (isset($tasks)) {
            $column = array_column($tasks, 'name');
            array_multisort($column, SORT_DESC, $tasks);
        }

        $this->view->path = self::PATH;
        $this->view->render(['tasks' => $tasks ?? []]);
    }

    public function store()
    {
        $task = [
            'title' => $_POST['title'],
            'status' => self::DEFAULT_STATUS,
        ];
        $taskId = $_COOKIE['id'];

        setcookie('id', $_COOKIE['id'] + 1);
        setcookie("task$taskId", serialize($task));

        $this->view->redirect();
    }

    public function delete()
    {
        setcookie($_POST['task'], null, -1, '/');

        $this->view->redirect();
    }

    public function ready()
    {
        $task = unserialize($_COOKIE[$_POST['task']], ["allowed_classes" => false]);
        $task['status'] ? $task['status'] = false : $task['status'] = true;
        setcookie($_POST['task'], serialize($task));

        $this->view->redirect();
    }

    public function deleteAll()
    {
        foreach ($_COOKIE as $key => $value) {
            if (strpos($key, 'task') !== false) {
                setcookie($key, null, -1, '/');
            }
        }

        $this->view->redirect();
    }

    public function readyAll()
    {
        foreach ($_COOKIE as $key => $value) {
            if (strpos($key, 'task') !== false) {
                $task = unserialize($value, ["allowed_classes" => false]);

                if (!$task['status']) {
                    $task['status'] = true;
                    setcookie($key, serialize($task));
                }
            }
        }

        $this->view->redirect();
    }
}