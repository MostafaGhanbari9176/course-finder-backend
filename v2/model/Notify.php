<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 7/12/2018
 * Time: 10:59 AM
 */


require_once 'uses/DBConnection.php';

class Notify
{

    private $tableName = "notify";
    private $con;

    function __construct()
    {
        $this->con = (new DBConnection())->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");

    }

    public function updateNotifySettingData($userId, $courseId, $startNotify, $days)
    {

        $sql = "UPDATE $this->tableName n SET n.start_notify = ? , n.days = ? WHERE n.user_id = ? AND n.course_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('issi', $startNotify, $days, $userId, $courseId);
        return $result->execute();


    }

    public function updateNotifyData($courseId, $days, $startDate, $endDate)
    {

        $sql = "UPDATE $this->tableName n SET n.start_date = ? , n.end_date = ? WHERE n.course_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ssi', $startDate, $endDate, $courseId);
        $result->execute();

        $char = 'a';
        $sql = "UPDATE $this->tableName n SET n.days = ? WHERE n.course_id = ? AND n.days <> ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('sis', $days, $courseId, $char);
        $result->execute();

    }

    public function saveNotifySettingData($userId, $courseId, $subject, $startNotify, $days, $startDate, $endDate)
    {

        $sql = "INSERT INTO $this->tableName ( user_id , course_id , start_notify , days , start_date , end_date , subject) VALUES (?,?,?,?,?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('siissss', $userId, $courseId, $startNotify, $days, $startDate, $endDate, $subject);
        return $result->execute();
    }

    public function getWeakNotifyData($userId)
    {

        $sql = "SELECT * FROM $this->tableName WHERE user_id = ? AND end_date > ? AND start_date <= ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('sss', $userId, getJDate(null), getJDate(null));
        $result->execute();
        return $result->get_result();
    }

    public function getStartNotifyData($userId, $tomDate)
    {

        $startNotify = 1;
        $sql = "SELECT * FROM $this->tableName WHERE user_id = ? AND start_date = ? AND start_notify = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ssi', $userId, $tomDate, $startNotify);
        $result->execute();
        return $result->get_result();
    }

    public function getSettingNotify($userId, $courseId)
    {

        $sql = "SELECT * FROM $this->tableName WHERE user_id = ? AND course_id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('si', $userId, $courseId);
        $result->execute();
        return $result->get_result();
    }

}