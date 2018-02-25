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

    public function updateUser($phone, $name)
    {
        $sql = "UPDATE $this->tableName u SET name = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("ss", $name, $phone);
        if ($result->execute()) {
            return (int)1;
        } else {
            return (int)0;
        }
    }

    public function getUser($phone)
    {
        $sql = "SELECT * FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("s", $phone);
        $result->execute();
        return $result->get_result();
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
        return 0;
    }

    public function getAcByPhone($phone)
    {
        $sql = "SELECT u.api_code FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        if ($result->execute())
            return $result->get_result()->fetch_assoc()['api_code'];
        return 0;
    }

}