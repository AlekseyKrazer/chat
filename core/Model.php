<?php
/**
 * Created by PhpStorm.
 * User: crazer
 * Date: 23.04.2019
 * Time: 20:33
 */
namespace core;

/**
 * Class Model
 */
class Model
{

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->doctrine = DBConnect::getConnection();
    }

    /**
     *
     */
    public function getData()
    {
    }
}