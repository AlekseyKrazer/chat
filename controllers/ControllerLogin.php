<?php

namespace Controllers;

use core\Controller;
use Model\ModelLogin;

class ControllerLogin extends Controller
{
    /**
     * Controller_Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelLogin();
    }

    public function actionIndex()
    {
        if ($this->model->checkCookie() == false) {
            $name = $_POST['name'] ?? false;
            return ($this->model->validate($name) != false) ? header("Location:index.php?r=chat") : $this->view->generate("login.php");
        } else {
            header("Location:index.php?r=chat");
        }
    }

    public function actionLogout()
    {
        $this->model->logout();
        header("Location:index.php");
    }
}