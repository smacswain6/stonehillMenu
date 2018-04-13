<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/11/2018
 * Time: 9:32 PM
 */
include("SQLiteConnection.php");
include("User.php");

class UserDao extends SQLite3
{
    /**
     * PDO instance
     * @var PDO
     */
    public $pdo;
    public function __construct()
    {

    }

    public function connect()
    {
        $pdo = (new SQLiteConnection())->connect();
        if ($pdo != null) {
            echo 'Connected to the SQLite database successfully!';
        } else
            echo 'Whoops, could not connect to the SQLite database!';
    }

    function selectByUserID($userid)
    {
        $stmt =$this->pdo->query('SELECT id, password '
            . 'FROM users'.'WHERE id=:id');
        $stmt->execute([':id' => $userid]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($row==NULL)
        {
            print("Error in selectByUserID, user not found");
            return NULL;
        }
        else {
            $user = new User($row['id'], $row['password']);
            return $user;
        }
    }
}