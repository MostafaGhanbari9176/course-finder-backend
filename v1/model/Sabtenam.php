<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 2/1/2018
 * Time: 11:38 AM
 */
require_once 'uses/DBConnection.php';

class Sabtenam
{
    private $conn;
    private $tableName = 'sabtnam';

    function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->connect();
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        mysqli_set_charset($this->conn, "UTF8");
    }

    public function add($idCourse, $idTeacer, $idUser, $date)
    {

        $sql = "INSERT INTO $this->tableName (cource_id, teacher_id, user_id, date) VALUES (?, ?, ?, ?)";
        $rezuelt = $this->conn->prepare($sql);
        $rezuelt->bind_param('isss', $idCourse, $idTeacer, $idUser, $date);
        if ($rezuelt->execute())
            return 1;
        return 0;
    }

    public function getByUserId($id)
    {
        $sql = "SELECT * FROM $this->tableName c WHERE c.user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('s', $id);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getSabtenamIdByUserIdAndCourseId($userId, $courseId)
    {
        $sql = "SELECT c.id FROM $this->tableName c WHERE c.cource_id = ? && c.user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('is', $courseId, $userId);
        if ($result->execute())
            return $result->get_result()->fetch_assoc()['id'];
        return 0;
    }

    public function getByTeacherIdAndCourseId($teacherId, $courseId)
    {
        $sql = "SELECT * FROM $this->tableName c WHERE c.cource_id = ? && c.teacher_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('is', $courseId, $teacherId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }


    public function updatecanceledFlag($sabteNameId, $code)
    {

        $sql = "UPDATE $this->tableName s SET is_canceled = ? WHERE s.id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $code, $sabteNameId);
        if ($result->execute())
            return 1;
        return 0;
    }
}