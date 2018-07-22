<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/17/2017
 * Time: 3:05 PM
 */

require_once 'uses/DBConnection.php';

class VerifyCode
{
    private $con;
    private $tableName = "verify_code";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");

    }

    public function saveSmsCode($phone, $vCode, $sendingDay)
    {
        $sql = "INSERT INTO $this->tableName (phone ,code , sending_day) VALUES (?,?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('sis', $phone, $vCode, $sendingDay);
        if ($result->execute()) {
            return (int)1;
        } else {
            //$this->updateCounter($phone);
            $sql = "UPDATE $this->tableName s SET s.code = ? , s.sending_day = ? WHERE s.phone = ?";
            $result = $this->con->prepare($sql);
            $result->bind_param('iss', $vCode, $sendingDay, $phone);
            if ($result->execute()) {
                return (int)1;
            } else
                return 0;
        }
    }

    public function getVerifyCodeData($phone)
    {

        $sql = "SELECT * FROM $this->tableName WHERE phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        $result->execute();
        return $result->get_result();
    }

    public function getSmsCode($phone)
    {
        $sql = "SELECT s.code FROM $this->tableName s WHERE s.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        $result->execute();
        return $result->get_result()->fetch_assoc()['code'];

    }

    public function getCounter($phone)
    {
        $sql = "SELECT s.counter FROM $this->tableName s WHERE s.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        $result->execute();
        return $result->get_result()->fetch_assoc()['counter'];

    }

    public function updateCounter($phone)
    {
        $counter = VerifyCode::getCounter($phone) + 1;
        $sql = "UPDATE $this->tableName s SET s.counter = ? WHERE s.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $counter, $phone);
        $result->execute();


    }

    public function removeVerifyCode($phone)
    {

        $sql = "DELETE FROM $this->tableName WHERE phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $phone);
        $result->execute();
    }

}