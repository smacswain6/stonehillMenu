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
    var $admin;
    public function __construct($user,$pass,$admin)
    {
        $this->username=$user;
        $this->password=$pass;
        $this->admin=$admin;
    }

    function __toString()
    {
        return $this->username." ".$this->password;
    }

}