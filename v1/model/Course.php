<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 1/29/2018
 * Time: 1:15 PM
 */
require_once 'uses/DBConnection.php';

class Course
{
    private $conn;
    private $tablename = 'cource';

    public function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->connect();
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        mysqli_set_charset($this->conn, "UTF8");
    }

    public function addCourse($teacher_id, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, $start_date, $end_date, $day, $hours, $minOld, $maxOld)
    {
        $sql = "INSERT INTO $this->tablename (teacher_id, subject, tabaghe_id, type, capacity, mony, sharayet, tozihat, definition_date, start_date, end_date, day, hours, min_old, max_old) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $rezult = $this->conn->prepare($sql);
        $rezult->bind_param('ssiiiisssssssii', $teacher_id, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, date("Y/m/d"), $start_date, $end_date, $day, $hours, $minOld, $maxOld);
        if ($rezult->execute()) {
            $sql2 = "SELECT c.cource_id FROM  $this->tablename c WHERE c.teacher_id = ?";
            $rezult2 = $this->conn->prepare($sql2);
            $rezult2->bind_param('s', $teacher_id);
            $rezult2->execute();
            $rezult2 = $rezult2->get_result();
            $res = 0;
            while ($row = $rezult2->fetch_assoc()) {
                $res = $row['cource_id'];
            }
            return $res;
        }
        return (int)0;
    }

    public function getAllCourse()
    {

        $sql = "SELECT * FROM $this->tablename";
        $result = $this->conn->prepare($sql);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getCourseById($id)
    {
        $sql = "SELECT * FROM $this->tablename c WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $id);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getCourseByTeacherId($teacherId)
    {
        $sql = "SELECT * FROM $this->tablename c WHERE c.teacher_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $teacherId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getTeacherSubject($id)
    {
        $sql = "SELECT t.subject FROM teacher t WHERE t.phone = (SELECT c.teacher_id FROM $this->tablename c WHERE c.cource_id = ?)";
        $resuelt = $this->conn->prepare($sql);
        $resuelt->bind_param('i', $id);
        if ($resuelt->execute())
            return $resuelt->get_result()->fetch_assoc()['subject'];
        return 0;
    }

    public function getCourseByGroupingId($groupingId)
    {
        $sql = "SELECT * FROM $this->tablename c WHERE c.tabaghe_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $groupingId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

}