<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/21/2017
 * Time: 1:25 PM
 */

require_once 'uses/DBConnection.php';

class Teacher
{

    public $con;
    public $tableName = 'teacher';

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function addTeacher($phone, $landPhone, $definitionDate, $subject, $tozihat, $type, $lat, $lon)
    {

        $sql = "INSERT INTO $this->tableName (`phone`,`land_phone`, `type`, `subject`,`definition_date`, `tozihat`, `lat`, `lon`) VALUES (?,?,?,?,?,?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('ssisssss', $phone, $landPhone, $type, $subject, $definitionDate, $tozihat, $lat, $lon);
        if ($result->execute())
            return 1;
        return 0;

    }

    public function getTeacher($phone)
    {
        $sql = "SELECT * FROM $this->tableName WHERE phone = ?";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('s', $phone);
        if ($rezult->execute())
            return $rezult->get_result();
        return 0;
    }

    public function getAllTeacher()
    {
        $sql = "SELECT * FROM $this->tableName ";
        $rezult = $this->con->prepare($sql);
        if ($rezult->execute())
            return $rezult->get_result();
        return 0;
    }

    public function getMadrakState($phone)
    {
        $sql = "SELECT t.madrak  FROM $this->tableName t WHERE phone = ?";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('s', $phone);
        if ($rezult->execute())
            return $rezult->get_result()->fetch_assoc()['madrak'];
        return -1;
    }

    public function updateMadrakState($phone, $value)
    {
        $sql = "UPDATE $this->tableName t SET t.madrak = ? WHERE phone = ?";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('is', $value, $phone);
        if ($rezult->execute())
            return 1;
        return 0;
    }

    public function getTeacherName($phone)
    {
        $sql = "SELECT t.subject FROM $this->tableName t WHERE t.phone = ?";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('s', $phone);
        $rezult->execute();
        return $rezult->get_result()->fetch_assoc()['subject'];

    }

    public function updateTeacher($phone, $landPhone, $subjecy, $address, $cityId, $madrak)
    {
        $sql = "UPDATE $this->tableName u SET land_phone = ?, subject = ?, address = ?, madrak = ?, city_id = ? WHERE u.phone = ?";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('sssiis', $landPhone, $subjecy, $address, $madrak, $cityId, $phone);
        if ($rezult->execute())
            return 1;
        return 0;
    }
}