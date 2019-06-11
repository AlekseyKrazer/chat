<?php
/**
 * Created by PhpStorm.
 * User: crazer
 * Date: 24.04.2019
 * Time: 0:33
 */

namespace core;

/**
 * Class Controller
 */
class Controller
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View();
    }

    /**
     *
     */
    public function actionIndex()
    {
    }
}