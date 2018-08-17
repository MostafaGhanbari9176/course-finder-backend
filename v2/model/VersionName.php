<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 17-Aug-18
 * Time: 2:52 PM
 */

require_once 'uses/DBConnection.php';

class VersionName
{
    private $dbConn;
    private $tableName = 'version_name';

    public function __construct()
    {
        $this->dbConn = (new DBConnection())->connect();
    }

    public function getVersionNme()
    {
        $sql = "SELECT t.version_name FROM $this->tableName t ORDER BY t.`v_date` DESC";
        $result = $this->dbConn->prepare($sql);
        $result->execute();
        return $result->get_result()->fetch_assoc()['version_name'];
    }

}