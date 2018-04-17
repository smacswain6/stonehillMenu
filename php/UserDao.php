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
        $this->pdo = (new SQLiteConnection())->connect();
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
        $stmt = $this->pdo->prepare("SELECT id,password FROM users WHERE id=:id;");
        if ($stmt == NULL) {
            error_log("stmt is null", 0);
        }
        try {
            $stmt->execute([':id' => $userid]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($row == NULL) {
                print("Error in selectByUserID, user not found");
                return NULL;
            } else {
                $user = new User($row['id'], $row['password']);
                return $user;
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }
    }

    function selectAll()
    {
        $stmt = $this->pdo->prepare("SELECT * from users;");
        if ($stmt == NULL) {
            error_log("stmt is null", 0);
        }
        try {
            $stmt->execute();
            $users = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $user = new User($row['id'], $row['password']);
                array_push($users, $user);
            }
            return $users;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }
        return Null;
    }
    function insert($user)
    {
        try {
            $sql = 'INSERT INTO users(id,password) VALUES(:id,:password)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $user->username,
                ':password' => $user->password,
            ]);
            return true;
        }
        catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }
    function update($user)
    {
        try {
            $sql = 'UPDATE users set id = :id, password = :password';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $user->username,
                ':password' => $user->password,
            ]);
            return true;
        }
        catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }
    function delete($user)
    {
        try {
            $sql = 'DELETE FROM users WHERE id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $user->username,
            ]);
            return true;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }
    function populate()
    {
        $dao=new UserDao();
        $dao->insert(new User('sam','bradford'));
        $dao->insert(new User('nick','lischenok'));
        $dao->insert(new User('matt','young'));
        $dao->insert(new User('michael','middleton'));
        $dao->insert(new User("matt","peters"));
    }

}

#UserDao::populate();
$dao=new UserDao();
$dao->populate();
//$dao->delete(new User("michael","middleton"));
//$dao->delete(new User('nick','lischenok'));
//$dao->delete(new User('matt','young'));
//$dao->delete(new User('michael','middleton'));
#$dao->delete(new User("sam","passwordChange"));