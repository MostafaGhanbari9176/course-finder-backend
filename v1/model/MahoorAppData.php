<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 16-Mar-18
 * Time: 3:14 PM
 */
require_once 'uses/DBConnection.php';

class MahoorAppData
{
    private $conn;
    private $tableName = 'mahoor_app';

    function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->connect();
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        mysqli_set_charset($this->conn, "UTF8");
    }

    public function getAppData()
    {
        $sql = "SELECT * FROM $this->tableName";
        $result = $this->conn->prepare($sql);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }
}