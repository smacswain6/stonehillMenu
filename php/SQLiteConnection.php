<?php
class SQLiteConnection {

private $pdo;

/**
* return in instance of the PDO object that connects to the SQLite database
* @return \PDO
*/
public function connect() {
if ($this->pdo == null) {
$this->pdo = new PDO("sqlite:" . "../db/menudb.db");
}
return $this->pdo;
}
}

?>