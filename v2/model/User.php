<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 11/16/2017
 * Time: 10:02 AM
 */
require_once 'uses/DBConnection.php';

class User
{
    private $con;
    private $tableName = "user";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");

    }

    public function logUpWithPass($phone, $name, $apiCode, $pass)
    {
        $status = 1;
        $sql = "INSERT INTO $this->tableName (phone, status, name, api_code, pass) VALUES(?,?,?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param("sisss", $phone, $status, $name, $apiCode, $pass);
        if ($result->execute()) {
            return true;
        } else
            return false;
    }

    public function checkPass($phone, $pass)
    {

        $sql = "SELECT * FROM $this->tableName u WHERE u.phone = ? AND u.pass = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ss', $phone, $pass);
        $result->execute();
        $data = $result->get_result()->fetch_assoc();
        if (sizeof($data) > 0)
            return $data['pass'];
        return -1;
    }

    public function chosePass($mail, $pass)
    {

        $sql = "UPDATE $this->tableName u SET u.pass = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ss', $pass, $mail);
        return $result->execute();

    }

    public function logUp($phone, $name, $apiCode)
    {
        $status = 1;
        $sql = "INSERT INTO $this->tableName (phone, status, name, api_code) VALUES(?,?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param("siss", $phone, $status, $name, $apiCode);
        if ($result->execute()) {
            return true;
        } else
            return false;
    }

    public function logIn($phone, $apiCode)
    {

        if ($this->getUser($phone)->fetch_assoc()['name'] == null)
            return 0;
        $status = 1;
        $sql = "UPDATE $this->tableName u SET status = ? , api_code = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('iss', $status, $apiCode, $phone);
        if (!$result->execute())
            return 0;
        if ($this->checkedTypeUser($phone) == 0)
            return (int)1;
        return (int)2;
    }

    public function getUser($phone)
    {
        $sql = "SELECT * FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("s", $phone);
        $result->execute();
        return $result->get_result();
    }

    public function getUserStatuse($phone)
    {

        $sql = "SELECT u.status FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        if ($result->execute())
            return $result->get_result()->fetch_assoc()['status'];
        return 0;
    }

    public function logOut($phone)
    {
        $status = 0;
        $sql = "UPDATE $this->tableName u SET status = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $status, $phone);
        if ($result->execute()) {
            return (int)1;
        } else {
            return (int)0;
        }
    }

    public function changeUserType($phone, $type)
    {

        $sql = "UPDATE $this->tableName u SET u.type = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $type, $phone);
        return $result->execute();
    }

    function checkedTypeUser($phone)
    {
        $sql = "SELECT u.type FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        $result->execute();
        return $result->get_result()->fetch_assoc()['type'];
    }

    public function getPhoneByAc($ac)
    {
        $sql = "SELECT u.phone FROM $this->tableName u WHERE u.api_code = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $ac);
        if ($result->execute())
            return $result->get_result()->fetch_assoc()['phone'];
        return "aa";
    }

    public function getAcByPhone($phone)
    {
        $sql = "SELECT u.api_code FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        if ($result->execute())
            return $result->get_result()->fetch_assoc()['api_code'];
        return "aa";
    }

    public function getUserName($phone)
    {

        $sql = "SELECT u.name FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("s", $phone);
        $result->execute();
        return $result->get_result()->fetch_assoc()['name'];
    }

    public function saveCellPhone($phone, $cellPhone)
    {
        $sql = "UPDATE $this->tableName u SET u.cell_phone = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ss', $cellPhone, $phone);
        $result->execute();
    }

    public function getCellPhone($phone)
    {
        $sql = "SELECT u.cell_phone From $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        $result->execute();
        $data = $result->get_result()->fetch_assoc();
        if (sizeof($data) > 0)
            return $data['cell_phone'];
        return 0;
    }

}