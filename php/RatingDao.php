<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 4/29/18
 * Time: 6:15 PM
 */

include("SQLConnection.php");
include("Rating.php");

class RatingDao
{
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
#$rating = new Rating('Tacos',5,'matt');
#print $rating->id;
#$dao->insert($rating);
#$rating1 = new Rating('Tacos', 10, 'matt');
#print $rating1->key;
#$dao->update($rating1);
