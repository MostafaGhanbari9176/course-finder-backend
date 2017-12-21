<?php
/**
 * Created by PhpStorm.
 * User: MAD
 * Date: 16/10/2017
 * Time: 08:18 AM
 */

require_once 'DBConf.php';
header('Content-Type: text/html; charset=utf-8');

class DBConnection
{
    private $conn;

    // Connecting to database
    public function connect()
    {
        $this->conn=
            new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // Check for database connection error
        if ($this->conn->connect_error) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        // returning connection resource
        return $this->conn;
    }
}

/*$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

*/