<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/16/2018
 * Time: 9:31 PM
 */

include("SQLConnection.php");
include("User.php");
include("Review.php");

class ReviewDao extends SQLite3
{
    /**
     * PDO instance
     * @var PDO
     */

    private $pdo;

    public function __construct()
    {
        $this->pdo = (new SQLConnection())->connect();
    }

    public function connect()
    {
        $pdo = (new SQLConnection())->connect();
        if ($pdo != null) {
            echo 'Connected to the SQLite database successfully!';
        } else
            echo 'Whoops, could not connect to the SQLite database!';
    }

    public function selectByFoodname($foodname)
    {
        try {
            $sql = "SELECT * FROM reviews WHERE foodname=:foodname;";
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
            $sql = "select * from reviews where username=:username;";
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
            return Nulll;
        }


    }

    public function insert($review)
    {
        try {
            $sql = 'INSERT INTO review(username,review,foodname) VALUES(:username,:review,:foodname)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':username' => $review->username,
                ':review' => $review->review,
                ':foodname' => $review->foodname,
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
        $dao->insert(new Review('nick','pretty good','Calzonee'));
        $dao->insert(new Review('sam','not good','Chicken Wrap'));
        $dao->insert(new Review('stephen','aweful','Burger Mania'));
        $dao->insert(new Review('michael','fantastic','Baked Potato Bar'));
    }
}

$dao = new ReviewDao();
$dao->populate();

