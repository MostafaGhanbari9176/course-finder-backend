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
    private $tableName = "rating_comment";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat, $date)
    {
        $sql = "INSERT INTO $this->tableName (comment_text, course_id, user_id, teacher_id, teacher_rat, cm_date) VALUES (?,?,?,?,?,?)";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('sissds', $commentText, $courseId, $userId, $teacherId, $teacherRat, $date);
        if ($rezult->execute())
            return 1;
        return 0;
    }/////////////checked

    public function saveCourseRat($userId, $courseId, $teacherId, $courseRat)
    {
        $sql = "INSERT INTO $this->tableName (course_id, user_id, teacher_id, course_rat) VALUES (?,?,?,?)";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('issd', $courseId, $userId, $teacherId, $courseRat);
        if ($rezult->execute())
            return 1;
        return 0;
    }

    public function upDateComment($id, $commentText, $userId, $courseId, $teacherId, $teacherRat, $date)
    {
        $vaziat = 0;
        $sql = "UPDATE $this->tableName c SET user_id = ?, course_id= ?, teacher_id = ?, teacher_rat = ?, comment_text = ?, cm_date = ?, vaziat = ? WHERE c.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('sisdssii', $userId, $courseId, $teacherId, $teacherRat, $commentText, $date, $vaziat, $id);
        if ($result->execute())
            return 1;
        return 0;
    }/////////////checked

    public function getCommentById($commentId)
    {
        $sql = " SELECT * FROM $this->tableName c WHERE c.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $commentId);
        $result->execute();
        return $result->get_result();

    }

    public function changeLike($likeNum, $commentId)
    {
        $sql = "UPDATE $this->tableName c SET like_num = ? WHERE c.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ii', $likeNum, $commentId);
        $result->execute();
    }

    public function changeDisLike($disLikeNum, $commentId)
    {
        $sql = "UPDATE $this->tableName c SET dislike_num = ? WHERE c.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ii', $disLikeNum, $commentId);
        $result->execute();
    }

    public function upDateCourseRat($id, $courseRat)
    {
        $sql = "UPDATE $this->tableName c SET course_rat = ? WHERE c.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('di', $courseRat, $id);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function getCommentByTeacherId($teacherId)
    {
        $sql = " SELECT * FROM $this->tableName c WHERE c.teacher_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $teacherId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getCourseRat($courseId)
    {
        $sql = " SELECT c.course_rat FROM $this->tableName c WHERE c.course_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $courseId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getTeacherRat($teacherId)
    {
        $sql = " SELECT c.teacher_rat , c.vaziat FROM $this->tableName c WHERE c.teacher_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $teacherId);
        if ($result->execute())
            return $result->get_result();
        return 0;
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

    public function getRatByCourseIdAndUserId($courseId, $userId)/////////////checked
    {
        $sql = " SELECT c.course_rat FROM $this->tableName c WHERE c.course_id = ? && c.user_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        if ($result->execute())
            return $result->get_result()->fetch_assoc()['course_rat'];
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

    public function checkAvailable($userId, $courseId)
    {/////////////checked
        $sql = " SELECT * FROM $this->tableName  c WHERE c.course_id = ? && c.user_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        if ($result->execute())
            return $result->get_result();
        return false;
    }


}