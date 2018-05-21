<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 27-Feb-18
 * Time: 8:14 PM
 */

require_once 'uses/DBConnection.php';

class SmsBox
{
    private $con;
    private $tableName = "sms_box";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function saveSms($text, $tsId, $rsId, $courseId, $time, $date, $howSending)
    {
        $seenFlag = 0;
        $sql = "INSERT INTO $this->tableName (text , ts_id, rs_id, seen_flag, course_id, time, date, how_sending) VALUES (?,?,?,?,?,?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('sssiissi', $text, $tsId, $rsId, $seenFlag, $courseId, $time, $date, $howSending);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function getRsSms($rsId)
    {
        $sql = "SELECT * FROM $this->tableName s WHERE s.rs_id = ? ORDER BY s.id DESC";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $rsId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function getTsSms($tsId)
    {
        $sql = "SELECT * FROM $this->tableName s WHERE s.ts_id = ? ORDER BY s.id DESC";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $tsId);
        if ($result->execute())
            return $result->get_result();
        return 0;
    }

    public function upDateSeen($id)
    {
        $seenFlag = 1;
        $sql = "UPDATE $this->tableName s SET s.seen_flag = ? WHERE s.id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ii', $seenFlag, $id);
        if ($result->execute())
            return 1;
        return 0;

    }

    public function deleteSms($id)
    {

        $sql = "DELETE FROM $this->tableName WHERE id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $id);
        if ($result->execute())
            return 1;
        return 0;
    }

}