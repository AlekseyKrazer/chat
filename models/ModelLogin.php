<?php
namespace Model;

use core\Model;

/**
 * Class ModelLogin
 * @package Model
 */
class ModelLogin extends Model
{
    /**
     * @param $name
     *
     * @return bool
     */
    public function validate($name)
    {
        if (strlen(trim($name))==0) {
            $name = false;
        }

        if ($name!=false) {
            $this->addCookie($name);
        }
        return $name;
    }

    /**
     * @param $value
     */
    private function addCookie($value)
    {
        setcookie("username", $value, time()+3600);
    }

    /**
     * @return bool
     */
    public function checkCookie()
    {
        if (isset($_COOKIE['username']) and trim($_COOKIE['username'])!='') {
            $cookie = true;
        } else {
            $cookie = false;
        }

        return $cookie;
    }

    /**
     * @return bool
     */
    public function getUsername()
    {
        if (isset($_COOKIE['username']) and trim($_COOKIE['username'])!='') {
            $username = $_COOKIE['username'];
        } else {
            $username = false;
        }
        return $username;
    }

    public function logout()
    {
        setcookie("username", "", time()-1);
    }
}
