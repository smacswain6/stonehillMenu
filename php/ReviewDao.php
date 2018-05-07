<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/16/2018
 * Time: 9:31 PM
 */

include("User.php");
include("Review.php");

class ReviewDao
{
    /**
     * PDO instance
     * @var PDO
     */

    private $pdo;

    public function __construct()
    {
        $this->pdo = ReviewDao::connect();
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

    public function selectByFoodname($foodname)
    {
        try {
            $sql = "SELECT * FROM review WHERE foodname=:foodname;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':foodname' => $foodname,]);
            $reviews = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $review = new Review($row['username'], $row['review'], $row['foodname']);
                array_push($reviews, $review);
            }
            return $reviews;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return Null;
        }
    }

    public function selectByUsername($username)
    {
        try {
            $sql = "select * from review where username=:username;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':username' => $username,]);
            $reviews = [];

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $review = new Review($row['username'], $row['review'], $row['foodname']);
                array_push($reviews, $review);
            }
            return $reviews;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return Null;
        }


    }

    public function insert($review)
    {
        try {
            $sql = 'INSERT INTO review(username,review,foodname,id) VALUES(:username,:review,:foodname,:id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':username' => $review->username,
                ':review' => $review->review,
                ':foodname' => $review->foodname,
                ':id' => $review->username.$review->foodname,
            ]);
            return true;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;


        }


    }

    public function populate()
    {
        $dao = new ReviewDao();
        $dao->insert(new Review('matt','Not Bad','Baked Potato Bar'));
        $dao->insert(new Review('nick','pretty good','Calzone'));
        $dao->insert(new Review('sam','not good','Chicken Wrap'));
        $dao->insert(new Review('stephen','aweful','Burger Mania'));
        $dao->insert(new Review('michael','fantastic','Baked Potato Bar'));
    }
}

#$dao = new ReviewDao();
#$dao->populate();

