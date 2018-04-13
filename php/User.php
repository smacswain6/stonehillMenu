<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/11/2018
 * Time: 9:15 PM
 */

class User
{
    var $username;
    var $password;
    public function __construct($user,$pass)
    {
        $this->username=$user;
        $this->password=$pass;
    }

    function toString()
    {
        return $this->username." ".$this->password;
    }

}