<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 30-May-18
 * Time: 2:43 AM
 */

class FeedBack
{
    private $con;
    private $tabaleName = 'feed_back';

    public function __construct()
    {
        $this->con = (new DBConnection())->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function saveFeedBack($feedBackText, $userId, $date)
    {
        $sql = "INSERT INTO $this->tabaleName (feed_back_text , user_id , feed_back_date) VALUES (? , ? , ?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('sss', $feedBackText, $userId, $date);
        if ($result->execute())
            return 1;
        return 0;
    }

}