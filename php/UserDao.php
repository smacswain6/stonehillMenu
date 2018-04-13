<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/11/2018
 * Time: 9:32 PM
 */
use SQLiteConnection;
use User;

class UserDao extends SQLite3
{
    function connect()
    {
        $pdo = (new SQLiteConnection())->connect();
        if ($pdo != null) {
            echo 'Connected to the SQLite database successfully!';
        } else
            echo 'Whoops, could not connect to the SQLite database!';
    }

    function selectByUserID()
    {
        $stmt = $this->pdo->query('SELECT id, password '
            . 'FROM users');
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        $user=User()->User($row['id'],$row['password']);
        return $user;
    }
}