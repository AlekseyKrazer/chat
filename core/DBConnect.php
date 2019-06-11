<?php

namespace core;


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class DBConnect
 * @package core
 */
class DBConnect
{
    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public static function getConnection()
    {
        $db = require "config/config.php";

        $isDevMode=true;
        $config = Setup::createAnnotationMetadataConfiguration(array("models/ORM"), $isDevMode);

        $connection = array(
            "dbname" => $db['dbname'],
            "user" => $db['user'],
            "password" => $db['password'],
            "host" => $db['host'],
            "driver" => $db['driver']
        );

        $entityManager = EntityManager::create($connection, $config);

        return $entityManager;
    }
}