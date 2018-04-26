<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/16/2018
 * Time: 9:31 PM
 */

include("SQLConnection.php");
include("User.php");

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
    public function selectByFoodname($review)
    {
        try {
            $sql = "SELECT * FROM reviews WHERE name=:name;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $review->name,
            ]);
            $reviews = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $review = new Review($row['user'], $row['name'], $row['review']);
                array_push($reviews, $review);
            }
            return $reviews;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return Null;
        }
    }

    public function selectByUsername($review)
    {
        try {
            $sql = "select * from reviews where username=:username;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->excecute([':username' => $review->username,]);
            $reviews = [];

            while($row = $stmt->fetch( \PDO::FETCH_ASSOC)) {
                $review = new Review($row['username'], $row['review'],$row['foodname']);
                array_push( $reviews, $review);
            }
            return $reviews;
        }

        catch (PDOException $exception) {
            error_log($exception->getMessage());
            return Nulll;
        }


    }
}