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

    function update($review)
    {
        try {
            $sql = 'UPDATE review set review = :val WHERE username=:uname and foodname=:fname';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':val' => $review->review,
                ':uname' => $review->username,
                ':fname' => $review->foodname,
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
        $dao->insert(new Review('matt','Worst burger ive ever had','Angus Quesadilla Burger'));
        $dao->insert(new Review('abby','Great','Angus Quesadilla Burger'));
        $dao->insert(new Review('brock','Decent, ive had better','Angus Quesadilla Burger'));
        $dao->insert(new Review('ryan','Best burger ive ever had','Angus Quesadilla Burger'));

        $dao->insert(new Review('matt','Not Bad','Antipasto Salad Plate'));
        $dao->insert(new Review('matthew','Too much dressing','Antipasto Salad Plate'));
        $dao->insert(new Review('nick','Horrible','Antipasto Salad Plate'));
        $dao->insert(new Review('viola','Fantastic','Antipasto Salad Plate'));
        $dao->insert(new Review('vladimira','Too many croutons','Antipasto Salad Plate'));
        $dao->insert(new Review('matt','Not Bad','Antipasto Salad Plate'));

        $dao->insert(new Review('nick','Potato was too burnt','Baked Potato Bar'));
        $dao->insert(new Review('abby','Awesome','Baked Potato Bar'));
        $dao->insert(new Review('viola','Fantastic','Baked Potato Bar'));
        $dao->insert(new Review('brock','Good','Baked Potato Bar'));

        $dao->insert(new Review('brock','very beefy','BBQ Beef Briskett'));
        $dao->insert(new Review('matt','decently beefy','BBQ Beef Briskett'));
        $dao->insert(new Review('ryan','Terrible BBQ','BBQ Beef Briskett'));
        $dao->insert(new Review('viola','Great','BBQ Beef Briskett'));

        $dao->insert(new Review('sam','not good','BBQ Pulled Pork or Chicken Sandwhich'));
        $dao->insert(new Review('vladimira','the chicken is great','BBQ Pulled Pork or Chicken Sandwhich'));
        $dao->insert(new Review('nick','Good pork','BBQ Pulled Pork or Chicken Sandwhich'));
        $dao->insert(new Review('stephen','Fantastic','BBQ Pulled Pork or Chicken Sandwhich'));


        $dao->insert(new Review('michael','Too much cheese','Bean and Cheese Chimichanga'));
        $dao->insert(new Review('matthew','too little cheese','Bean and Cheese Chimichanga'));
        $dao->insert(new Review('viola','too much beans','Bean and Cheese Chimichanga'));
        $dao->insert(new Review('abby','perfect','Bean and Cheese Chimichanga'));

        $dao->insert(new Review('viola','not good','Bread Boules'));
        $dao->insert(new Review('vladimira','great','Bread Boules'));
        $dao->insert(new Review('brock','fantastic','Bread Boules'));
        $dao->insert(new Review('matt','my favorite meal','Bread Boules'));


        $dao->insert(new Review('sam','great for breakfast','Breakfast sandwich'));
        $dao->insert(new Review('nick','really good eggs','Breakfast sandwich'));
        $dao->insert(new Review('abby','great bacon egg and cheese','Breakfast sandwich'));
        $dao->insert(new Review('stephen','the sausage is not so good','Breakfast sandwich'));

        $dao->insert(new Review('stephen','aweful','Buffalo Chicken Penne'));
        $dao->insert(new Review('viola','way too much buffalo sauce','Buffalo Chicken Penne'));
        $dao->insert(new Review('abby','perfectly made','Buffalo Chicken Penne'));
        $dao->insert(new Review('matthew','fantastic buffalo chicken','Buffalo Chicken Penne'));

    }
}

$dao = new ReviewDao();
$dao->populate();


