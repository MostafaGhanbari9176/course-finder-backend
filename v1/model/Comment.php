<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 22-Feb-18
 * Time: 6:58 PM
 */

require_once 'uses/DBConnection.php';

class comment
{
    private $con;
    private $tableName = "comment";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function saveComment($userId, $teacherId, $courseId, $rat, $comment, $date)
    {
        $sql = "INSERT INTO $this->tableName (user_id, cource_id, teacher_id, date, rat, comment) VALUES (?,?,?,?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('sissis', $userId, $courseId, $teacherId, $date, $rat, $comment);
        if ($result->execute())
            return 1;
        return 0;

    }

    public function upDateComment($id, $userId, $teacherId, $courseId, $rat, $comment, $date)
    {
        $sql = "UPDATE $this->tableName c SET user_id = ?, cource_id= ?, teacher_id = ?, date = ?, rat = ?, comment = ? WHERE c.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('sissisi', $userId, $courseId, $teacherId, $date, $rat, $comment, $id);
        if ($result->execute())
            return true;
        $this->upDateComment($userId, $teacherId, $courseId, $rat, $comment, $date);
    }

    public function getCommentByCourseId($courseId)
    {
        $sql = " SELECT * FROM $this->tableName c WHERE c.cource_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $courseId);
        if ($result->execute())
            return $result->get_result();
        return false;


    }

    public function getSelectedComment()
    {
        $rat = 3;
        $sql = " SELECT * FROM $this->tableName c WHERE c.rat >= ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $rat);
        if ($result->execute())
            return $result->get_result();
        return false;
    }

    public function getawesomeComment()
    {
        $rat = 4;
        $sql = " SELECT * FROM $this->tableName c WHERE c.rat > ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $rat);
        if ($result->execute())
            return $result->get_result();
        return false;
    }

    public function checkAvailable($userId, $courseId){
        $sql = " SELECT * FROM $this->tableName  c WHERE c.cource_id = ? && c.user_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        if ($result->execute())
            return $result->get_result();
        return false;
    }


}