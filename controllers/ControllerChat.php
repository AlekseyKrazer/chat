<?php

namespace Controllers;

use core\Controller;
use Model\ModelLogin;

/**
 * Class ControllerChat
 * @package Controllers
 */
class ControllerChat extends Controller
{
    public function actionIndex()
    {
        $chat = new ModelLogin();
        $username = $chat->getUsername();
        return ($username == false) ? header("Location:index.php?r=login") : $this->view->generate("chat.php", $username);
    }
}