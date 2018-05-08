<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 13-Mar-18
 * Time: 12:56 PM
 */
require_once 'uses/DBConnection.php';

class Subscribe
{
    private $conn;
    private $subscribListTableName = 'subscribe';
    private $buyTableName = 'buy';

    function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->connect();
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        mysqli_set_charset($this->conn, "UTF8");
    }

    public function getSubscribeList()
    {
        $sql = "SELECT * FROM $this->subscribListTableName";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->get_result();
    }

    public function getUserSubscribe($userId)
    {

        $sql = "SELECT * FROM $this->buyTableName b WHERE b.user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $userId);
        $result->execute();
        return $result->get_result();
    }

    public function saveUserBuy($userId, $buyDate, $token, $remainingCourse, $subscribeId)
    {

        $sql = "INSERT INTO $this->$this->buyTableName (`user_id`, `buy_date`, `token`, `remaining_courses`, `subscribe_id`) VALUES (?, ?, ?, ?, ?)";
        $result = $this->conn->prepare($sql);
        $result->bind_param('sssii', $userId, $buyDate, $token, $remainingCourse, $subscribeId);
        if ($result->execute())
            return 1;
        return 0;
    }
}