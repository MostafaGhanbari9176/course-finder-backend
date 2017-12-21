<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/21/2017
 * Time: 1:25 PM
 */

require_once 'uses/DBConnection.php';

class Teacher
{

    public $con;
    public $tableName = 'teacher';

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function addTeacher($phone, $address, $subject, $cityId, $startDate,$tozihat,$type){

        $sql = "INSERT INTO $this->$this->tableName (`phone`, `type`, `address`, `madrak`, `subject`, `vaziat`, `start_date`, `taied_date`, `end_date`, `tozihat`, `city_id`) VALUES ('123', '0', 'jk', '0', 'kj', '0', '2017-12-07', NULL, NULL, 'ty', '2');";
    }
}