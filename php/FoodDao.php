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
        if($stmt == NULL){
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
}
