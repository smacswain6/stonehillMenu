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
        } catch (PDOException $exception) {
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
            $sql = "select * from ratings where username=:username;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':username' => $username,]);
            $ratings = [];

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $rating = new Rating($row['foodname'], $row['value'], $row['username']);
                array_push($ratings, $rating);
            }
            return $ratings;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return Null;
        }
    }
    public function selectByFoodname($fname)
        {
            try {
                $sql = "select * from ratings where foodname=:foodname;";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':foodname' => $fname,]);
                $ratings = [];

                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $rating = new Rating($row['foodname'], $row['value'], $row['username']);
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
                return true;
            } catch (PDOException $exception) {
                error_log($exception->getMessage());
                return false;
            }
        }

        function populate()
        {
            $dao = new RatingDao();
            $dao->insert(new Rating('Angus Quesadilla Burger',3,'admin'));
            $dao->insert(new Rating('Antipasto Salad Plate',10,'admin'));
            $dao->insert(new Rating('Baked Potato Bar',2,'admin'));
            $dao->insert(new Rating('BBQ Beef Briskett',7,'admin'));
            $dao->insert(new Rating('BBQ Pulled Pork or Chicken Sandwhich',5,'admin'));
            $dao->insert(new Rating('Bread Boules',3,'admin'));
            $dao->insert(new Rating('Breakfast sandwich',4,'admin'));
            $dao->insert(new Rating('Buffalo Chicken Penne',5,'admin'));
            $dao->insert(new Rating('Burger Mania',9,'admin'));
            $dao->insert(new Rating('Calabrian Polenta',3,'admin'));
            $dao->insert(new Rating('Calzonee',8,'admin'));
        }


    }

$dao = new RatingDao();
$dao->populate();