<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 13-Mar-18
 * Time: 12:56 PM
 */

class Subscribe
{
    private $conn;
    private $tableName = 'subscribe';

    function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->connect();
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        mysqli_set_charset($this->conn, "UTF8");
    }

    public function getByUserId($id)
    {
        $sql = "SELECT * FROM $this->tableName e WHERE e.user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('s', $id);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }
}