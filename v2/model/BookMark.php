<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 25-Jun-18
 * Time: 11:39 PM
 */

require_once 'uses/DBConnection.php';

class BookMark
{
    private $tableName = "bookmark";
    private $con;

    function __construct()
    {
        $this->con = (new DBConnection())->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");

    }

    public function saveBookMark($courseId, $userId)
    {
        $sql = "INSERT INTO $this->tableName ( course_id, user_id) VALUES (? , ?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function removeBookMark($courseId, $userId)
    {
        $sql = "DELETE FROM $this->tableName  WHERE  course_id = ? AND user_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function checkBookMark($courseId, $userId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE course_id = ? AND user_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        $result->execute();
        $arr = $result->get_result()->fetch_assoc();
        if ($arr != null && sizeof($arr))
            return 1;
        return 0;
    }

}