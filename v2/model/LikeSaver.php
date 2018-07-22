<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 09-Mar-18
 * Time: 8:33 PM
 */

require_once 'uses/DBConnection.php';

class LikeSaver
{
    private $con;
    private $tableName = "like_saver";


    public function __construct()
    {
        $dbConection = new DBConnection();
        $this->con = $dbConection->connect();
        mysqli_query($this->con, "SET NAMES 'UTF8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function saveLike($userId, $commentId, $isLicked)
    {
        $sql = "INSERT INTO $this->tableName (user_id, comment_id, is_liked) VALUES(?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('sii', $userId, $commentId, $isLicked);
        if ($result->execute())
            return 1;
        return 0;

    }

    public function upDateLike($userId, $commentId, $isLicked)
    {
        $sql = "UPDATE $this->tableName c SET is_liked = ? WHERE c.user_id = ? && c.comment_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('isi', $isLicked, $userId, $commentId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function checkValidation($userId, $commentId, $commentFeedBack)
    {
        $isAvailable = false;
        $sql = "SELECT * FROM $this->tableName c WHERE c.user_id = ? && c.comment_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('si', $userId, $commentId);

        if ($result->execute()) {

            if (($result->get_result()->fetch_assoc()['is_liked']) == $commentFeedBack) {

                $isAvailable = true;
            }
            return $isAvailable;
        }
        return $isAvailable;
    }

    public function checkForInverting($userId, $commentId)
    {
        $isAvailable = false;
        $sql = "SELECT * FROM $this->tableName c WHERE c.user_id = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $userId);

        if ($result->execute()) {

            if (($row = $result->get_result()->fetch_assoc()['comment_id']) == $commentId) {
                $isAvailable = true;
            }
            return $isAvailable;
        }
        return $isAvailable;
    }


}