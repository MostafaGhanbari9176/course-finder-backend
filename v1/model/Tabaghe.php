<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 1/29/2018
 * Time: 9:13 AM
 */

require_once 'uses/DBConnection.php';
class Tabaghe
{
   private $con;
   private $tableName = 'tabaghe';
    public function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function getTabaghe($uperId){
        $sql ="SELECT * FROM tabaghe t WHERE t.uper_id = ?";
        $rezult = $this->con->prepare($sql);
        $rezult->bind_param('i',$uperId);
        if($rezult->execute())
            return $rezult->get_result();
        return 0;
    }

    public function getGroupingSubjectByCourseId($id)
    {
        $sql = "SELECT t.subject FROM tabaghe t WHERE t.id = (SELECT c.tabaghe_id FROM cource c WHERE c.cource_id = ?)";
        $resuelt = $this->con->prepare($sql);
        $resuelt->bind_param('i', $id);
        if ($resuelt->execute())
            return $resuelt->get_result()->fetch_assoc()['subject'];
        return 0;
    }

    public function getGroupingSubjectByGroupId($id)
    {
        $sql = "SELECT t.subject FROM tabaghe t WHERE t.id = ?";
        $resuelt = $this->con->prepare($sql);
        $resuelt->bind_param('i', $id);
        if ($resuelt->execute())
            return $resuelt->get_result()->fetch_assoc()['subject'];
        return 0;
    }

}