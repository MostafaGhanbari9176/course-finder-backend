<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/17/2017
 * Time: 3:05 PM
 */

require_once 'uses/DBConnection.php';

class SmsCode
{
    private $con;
    private $tableName = "sms_code";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");

    }

    public function saveSmsCode($phone, $vCode)
    {
        $sql = "INSERT INTO $this->tableName (phone ,verify_code ) VALUES (?,?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('ii', $phone, $vCode);
        if ($result->execute()) {
            return (int)1;
        } else {
            return (int)0;
        }
    }

    public function getSmsCode($phone)
    {
        $sql = "SELECT s.verify_code FROM $this->tableName s WHERE s.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i', $phone);
        $result->execute();
        return $result->get_result();

    }

}