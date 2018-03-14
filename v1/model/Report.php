<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 14-Mar-18
 * Time: 1:02 PM
 */

require_once 'uses/DBConnection.php';

class Report
{
    private $con;
    private $tableName = "report";

    public function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function saveAReport($signText, $reportText, $spamId, $spamerId, $reporterId)
    {
        $sql = "INSERT INTO $this->tableName (sign_text, report_text, spam_id, spamer_id, reporter_id) VALUES (?, ?, ?, ?, ?)";
        $rezuelt = $this->con->prepare($sql);
        $rezuelt->bind_param('ssiss', $signText, $reportText, $spamId, $spamerId, $reporterId);
        if ($rezuelt->execute())
            return 1;
        return 0;
    }

}