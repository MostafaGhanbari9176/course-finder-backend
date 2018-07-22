<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 23-Jun-18
 * Time: 3:36 AM
 */

require_once 'uses/DBConnection.php';

class Favorite
{
    private $tableName = "favorite";
    private $con;

    public function __construct()
    {
        $this->con = (new DBConnection())->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");

    }

    public function saveFavorite($teacherId, $userId)
    {

        $sql = "INSERT INTO $this->tableName (teacher_id , user_id)  VALUES (?, ?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('ss', $teacherId, $userId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function removeFavorite($teacherId, $userId)
    {

        $sql = "DELETE FROM $this->tableName WHERE user_id = ? AND teacher_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ss', $userId, $teacherId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function checkFavorite($teacherId, $userId)
    {
        $sql = "SELECT * FROM   $this->tableName s WHERE s.user_id = ? AND s.teacher_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ss', $userId, $teacherId);
        $result->execute();
        if (sizeof($result->get_result()->fetch_assoc()))
            return 1;
        return 0;

    }

}