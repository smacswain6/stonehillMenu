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
    private $pdo;
    public function __construct()
    {
        $this->pdo=(new SQLiteConnection())->connect();
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
        $stmt=$this->pdo->prepare("SELECT id,password FROM users WHERE id=:id;");
        if($stmt==NULL) {
            error_log("stmt is null", 0);
        }
        try {
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
        catch (PDOException $exception)
        {
          error_log($exception->getMessage());
        }
    }
}