<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/11/2018
 * Time: 9:32 PM
 */

class UserDao extends SQLite3
{
    function __construct()
    {
        private $pdo=new PDO("sqlite:"."../db/user.db");
    }

}