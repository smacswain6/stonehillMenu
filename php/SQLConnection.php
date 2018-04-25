<?php
class SQLConnection
{
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
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
}
?>