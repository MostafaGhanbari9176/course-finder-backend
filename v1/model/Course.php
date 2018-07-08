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
        $result = $this->conn->prepare($sql);
        $result->bind_param('ssiiiisssssssii', $teacher_id, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, getJDate(null), $start_date, $end_date, $day, $hours, $minOld, $maxOld);
        if ($result->execute()) {
            $sql2 = "SELECT c.cource_id FROM  $this->tablename c WHERE c.teacher_id = ? ORDER BY c.cource_id DESC LIMIT 1";
            $result2 = $this->conn->prepare($sql2);
            $result2->bind_param('s', $teacher_id);
            $result2->execute();
            $res = $result2->get_result()->fetch_assoc()['cource_id'];
            return $res;
        }
        return (int)0;
    }

    public function getAllCourse()
    {

        $sql = "SELECT * FROM $this->tablename c ORDER BY c.cource_id DESC";
        $result = $this->conn->prepare($sql);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function updateDeletedFlag($courseId, $code)
    {

        $sql = "UPDATE $this->tablename c SET is_deleted = ? WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $code, $courseId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function getCourseName($courceId)
    {

        $sql = "SELECT c.subject FROM $this->tablename c WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $courceId);
        $result->execute();
        return $result->get_result()->fetch_assoc()['subject'];

    }

    public function decrementCapacity($courseId)
    {
        $sql = "SELECT c.capacity FROM $this->tablename c WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $courseId);
        if (!$result->execute())
            return 0;

        $capacity = $result->get_result()->fetch_assoc()['capacity'];
        $capacity = $capacity - 1;
        $sql = "UPDATE $this->tablename c SET capacity = ? WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $capacity, $courseId);
        if ($result->execute())
            return 1;
        return 0;

    }

    public function incrementCapacity($courseId)
    {
        $sql = "SELECT c.capacity FROM $this->tablename c WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $courseId);
        if (!$result->execute())
            return 0;

        $capacity = $result->get_result()->fetch_assoc()['capacity'];
        $capacity = $capacity + 1;
        $sql = "UPDATE $this->tablename c SET capacity = ? WHERE c.cource_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $capacity, $courseId);
        if ($result->execute())
            return 1;
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

        $sql = "SELECT * FROM $this->tablename c WHERE c.teacher_id = ? ORDER BY c.cource_id DESC";
        $result = $this->conn->prepare($sql);
        $result->bind_param('s', $teacherId);
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
        $sql = "SELECT * FROM $this->tablename c WHERE c.tabaghe_id = ? ORDER BY c.cource_id DESC";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $groupingId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getNewCourse()
    {

        $sql = "SELECT * FROM $this->tablename c ORDER BY c.cource_id DESC LIMIT 10";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->get_result();
    }

    public function getEndCourses()
    {
        $vaziat = 1;
        $state = 3;
        $sql = "SELECT * FROM $this->tablename c WHERE c.state = ? And c.vaziat = ? ORDER BY c.cource_id DESC ";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $state, $vaziat);
        $result->execute();
        return $result->get_result();

    }

    public function getFullCapacityCourses()
    {
        $vaziat = 1;
        $state = 4;
        $sql = "SELECT * FROM $this->tablename c WHERE c.state = ? And c.vaziat = ? ORDER BY c.cource_id DESC ";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $state, $vaziat);
        $result->execute();
        return $result->get_result();

    }

    public function upDateCourse($teacherId, $courseId, $startDate, $endDate, $hours, $days, $state)
    {

        $sql = "UPDATE $this->tablename c set c.start_date = ? , c.end_date = ? , c.hours = ? , c.day = ? , c.state = ?  WHERE  c.cource_id = ? && c.teacher_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ssssiis', $startDate, $endDate, $hours, $days, $state, $courseId, $teacherId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function getNotifyData($lastId)
    {
        $vaziat = 1;
        $sql = "SELECT * FROM $this->tablename c WHERE c.cource_id > ? AND c.vaziat = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $lastId, $vaziat);
        $result->execute();
        return $result->get_result();
    }

}