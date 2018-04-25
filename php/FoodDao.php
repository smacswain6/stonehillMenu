<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/25/2018
 * Time: 3:37 PM
 */
include("SQLConnection.php");
include("Food.php");

class FoodDao
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
        $stmt = $this->pdo->prepare("SELECT * from foods where name=:name;");
        if ($stmt == NULL) {
            error_log("stmt is null", 0);
        }
        try {
            $stmt->execute([':name' => $foodname]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($row == NULL) {
                print("Error in selectByUserID, user not found");
                return NULL;
            } else {
                $foodItem = new Food($row['name'], $row['rating'], $row['image'], $row['description'], $row['station'],
                    $row['day'], $row['votes'], $row['current']);
                return $foodItem;
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }
    }
    function selectAll()
    {
        $stmt = $this->pdo->prepare("SELECT * from foods;");
        if ($stmt == NULL) {
            error_log("stmt is null", 0);
        }
        try {
            $stmt->execute();
            $foodItems = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $foodItem = new Food($row['name'], $row['rating'], $row['image'], $row['description'], $row['station'],
                    $row['day'], $row['votes'], $row['current']);
                print_r($foodItem);
                array_push($foodItems, $foodItem);
            }
            return $foodItems;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
        }
        return Null;
    }

    function insert($foodItem)
    {
        try {
            $sql = 'INSERT INTO foods(name,rating,image,description,station,day,votes,current) 
                              VALUES(:name,:rating,:image,:description,:station,:day,:votes,:current);';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $foodItem->name,
                ':rating' => $foodItem->rating,
                ':image' => $foodItem->image,
                ':description' => $foodItem->description,
                ':station' => $foodItem->station,
                ':day' => $foodItem->day,
                ':votes' => $foodItem->votes,
                ':current' => $foodItem->current,
            ]);
            return true;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return false;
        }
    }

    function populate()
    {
        $dao = new FoodDao();
        $dao->insert(new Food('Chicken Wrap', 5, 'chickenwrap.jpg', 'crispy chicken wrap', 'Entree', 'Monday', 1, 'true'));
    }
}
#FoodDao::populate();
$dao=new FoodDao();
$foods=$dao->selectAll();
