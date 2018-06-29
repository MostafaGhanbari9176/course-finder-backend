<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 26-Jun-18
 * Time: 11:16 PM
 */

require_once 'uses/DBConnection.php';

class Gift
{

    private $tableName = "gift";
    private $con;

    function __construct()
    {
        $this->con = (new DBConnection())->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function getGifData($giftCode)
    {
        $state = 1;
        $sql = "SELECT * FROM $this->tableName WHERE gift_code = ? AND state = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('si', $giftCode, $state);
        $result->execute();
        return $result->get_result()->fetch_assoc();
    }

    public function decrementCounter($giftCode)
    {

        $sql = "SELECT g.counter FROM $this->tableName g WHERE g.gift_code = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('s', $giftCode);
        if (!$result->execute())
            return 0;

        $counter = $result->get_result()->fetch_assoc()['counter'];
        $counter = $counter - 1;
        $sql = "UPDATE $this->tableName g SET counter = ? WHERE g.gift_code = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('is', $counter, $giftCode);
        if ($result->execute())
            return 1;
        return 0;
    }

    public function getGiftCodes()
    {
        $sql = "SELECT * FROM $this->tableName";
        $result = $this->con->prepare($sql);
        $result->execute();
        return $result->get_result();
    }
}