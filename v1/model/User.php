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

    public function logIn($phone)
    {

        $status = 1;
        $sql = "INSERT INTO $this->tableName (phone,status) VALUES(?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param("ii", $phone, $status);
        if ($result->execute()) {
            return (int)1;
        } else {

            $sql = "UPDATE $this->tableName u SET status = ? WHERE u.phone = ?";
            $result = $this->con->prepare($sql);
            $result->bind_param('ii', $status, $phone);
            $result->execute();
            if ($this->checkedTypeUser($phone) == 0)
                return (int)2;
            return (int)3;
        }

    }

    public function updateUser($phone, $name, $family, $status, $type, $cityID, $apiCode)
    {
        $sql = "UPDATE $this->tableName u SET phone = ?, name = ?, family = ?, status = ?, type = ?, city_id = ?, api_code = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("issiiiii", $phone, $name, $family, $status, $type, $cityID, $apiCode, $phone);
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
        $result->bind_param("i", $phone);
        $result->execute();
        return $result->get_result();
    }

    public function logOut($phone)
    {
        $status = 0;
        $sql = "UPDATE $this->tableName u SET status = ? WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('ii', $status, $phone);
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
        $result->bind_param('ii', $type, $phone);
        return $result->execute();
    }

    function checkedTypeUser($phone)
    {
        $sql = "SELECT u.type FROM $this->tableName u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $phone);
        $result->execute();
        return $result->get_result()->fetch_assoc()['type'];
    }

}