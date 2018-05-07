<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 4/29/18
 * Time: 6:15 PM
 */

include("Rating.php");

class RatingDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = RatingDao::connect();
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

    function insert($rating)
    {
        try {
            $sql = 'INSERT INTO ratings VALUES(:id,:value,:username,:foodname)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':foodname' => $rating->foodname,
                ':value' => $rating->value,
                ':username' => $rating->username,
                ':id' => $rating->id,
            ]);
            return true;
        }
        catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }

    function delete($rating)
    {
        try {
            $sql = 'DELETE FROM ratings WHERE id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $rating->id,
            ]);
            return true;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }
    public function selectByUsername($username)
    {
        try {
            $sql = "select * from rating where username=:username;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':username' => $username,]);
            $ratings = [];

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $rating = new Rating($row['foodname'],$row['value'], $row['username']);
                array_push($ratings, $rating);
            }
            return $ratings;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return Null;
        }


    }

    function update($rating)
    {
        try {
            $sql = 'UPDATE ratings set value = :value WHERE id=:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':value' => $rating->value,
                ':id' => $rating->id,
            ]);
            echo 'changed';
            return true;
        }
        catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }


}

#$dao = new RatingDao();
#$rating = new Rating('Burger Mania',1,'stephen');
#print $rating->id;
#$dao->insert($rating);
#$rating1 = new Rating('Tacos', 10, 'matt');
#print $rating1->key;
#$dao->update($rating1);
