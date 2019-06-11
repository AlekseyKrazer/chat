<?php

namespace Controllers;

use core\Controller;
use Model\ModelApi;

/**
 * Class ControllerApi
 * @package Controllers
 */
class ControllerApi extends Controller
{
    /**
     * ControllerApi constructor.
     */
    public function __construct()
    {
        $this->api = new ModelApi();
    }

    public function actionData()
    {
        $json = $this->api->getData();
        echo $json;
    }

    public function actionInsert()
    {
        if (count($_POST)>0) {
            $this->api->insert($_POST);
        }
    }

    public function actionDelete()
    {
        if (count($_POST)>0) {
            $this->api->delete($_POST);
        }
    }

    public function actionLike()
    {
        if (count($_POST)>0) {
            $this->api->like($_POST);
        }
    }

    public function actionFile()
    {
        if (count($_FILES)>0) {
            $result=$this->api->addFile($_FILES['myimg']);
            echo $result;
        } else {
            echo 0;
        }
    }
}
