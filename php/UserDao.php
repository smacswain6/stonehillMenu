<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/11/2018
 * Time: 9:32 PM
 */

include("User.php");

class UserDao
{
    /**
     * PDO instance
     * @var PDO
     */
    private $pdo;

    public function __construct()
    {
        $this->pdo = UserDao::connect();
    }

    public function connect()
    {
        $dbhost = "menudb.cpjmzja1ggqk.us-west-2.rds.amazonaws.com";
        $dbport = "3306";
        $dbname = "menudb";
        $charset = 'utf8';

        $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
        $username = "root";
        $password = "rootpassword";

        $pdo = new PDO($dsn, $username, $password);
        return $pdo;
    }

    function selectByUserID($userid)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id=:id;");
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
                $user = new User($row['id'], $row['password'], $row['admin']);
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
                $user = new User($row['id'], $row['password'],$row['admin']);
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
            $sql = 'INSERT INTO users(id,password,admin) VALUES(:id,:password,:admin)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $user->username,
                ':password' => $user->password,
                ':admin' => $user->admin,
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
            $sql = 'UPDATE users set id = :id, password = :password, admin =:admin WHERE id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $user->username,
                ':password' => $user->password,
                'admin' => $user->admin
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
        $dao->insert(new User('sam','bradford',0));
        $dao->insert(new User('nick','lischenok',0));
        $dao->insert(new User('matthew','young',0));
        $dao->insert(new User('michael','middleton',0));
        $dao->insert(new User("vladimira","lea",0));
        $dao->insert(new User("abby","abner",0));
        $dao->insert(new User("mrytle","franklin",0));
        $dao->insert(new User("viola","myles",0));
        $dao->insert(new User("brock","anderson",0));
    }

}

