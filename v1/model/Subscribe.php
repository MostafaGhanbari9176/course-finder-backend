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

        $sql = "SELECT * FROM $this->buyTableName b WHERE b.user_id = ? ORDER BY b.id DESC LIMIT 1";
        $result = $this->conn->prepare($sql);
        $result->bind_param('s', $userId);
        $result->execute();
        return $result->get_result()->fetch_assoc();
    }

    public function saveUserBuy($userId, $buyDate, $endBuyDate, $token, $remainingCourse, $subscribeId)
    {

        $sql = "INSERT INTO $this->$this->buyTableName (user_id, buy_date, token, remaining_courses, end_buy_date, subscribe_id) VALUES (?, ?, ?, ?, ?, ?)";
        $result = $this->conn->prepare($sql);
        $result->bind_param('sssisi', $userId, $buyDate, $token, $remainingCourse, $endBuyDate, $subscribeId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function getSubscribe($subscribeId)
    {

        $sql = "SELECT * FROM $this->subscribListTableName s WHERE s.id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('i', $subscribeId);
        $result->execute();
        return $result->get_result()->fetch_assoc();
    }

    public function decrementRemainingCourse($userId)
    {

        $sql = "SELECT b.remaining_courses FROM $this->buyTableName b WHERE b.user_id = ? ORDER BY b.id DESC LIMIT 1";
        $result = $this->conn->prepare($sql);
        $result->bind_param('s', $userId);
        if (!$result->execute())
            return 0;

        $remainingCourse = $result->get_result()->fetch_assoc()['remaining_courses'];
        $remainingCourse = $remainingCourse - 1;
        $sql = "UPDATE $this->buyTableName b SET remaining_courses = ? WHERE b.user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('is', $remainingCourse, $userId);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function updateVaziat($buyId, $vaziat)
    {

        $sql = "UPDATE $this->buyTableName b SET b.vaziat = ? WHERE b.id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param('ii', $vaziat, $buyId);
        $result->execute();
    }


}