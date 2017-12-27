<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 11/21/2017
 * Time: 12:28 PM
 */
require_once 'uses/DBConnection.php';

class City
{
    private $con;
    private $tableName = "city";

    function __construct()
    {
        $db = new DBConnection();
        $this->con = $db->connect();
        mysqli_query($this->con, "SET NAMES 'utf8'");
        mysqli_set_charset($this->con, "UTF8");
    }

    public function getCity($flag)
    {
        $sql = " SELECT c.city_name , c.city_id , c.ostan_id FROM ostan o , city c WHERE c.ostan_id = (SELECT o.id WHERE o.name =?)";
        $result = $this->con->prepare($sql);
        $result->bind_param('s',$flag);
        $result->execute();
        return $result->get_result();

    }

    public function locatin($cityId)
    {

        $sql = " SELECT c.city_name , o.name FROM ostan o , city c WHERE o.id = ( SELECT c.ostan_id WHERE c.city_id = ? )";
        $result = $this->con->prepare($sql);
        $result->bind_param('i',$cityId);
        $result->execute();
        return $result->get_result();
    }

    public function cityId($phone){
        $sql = "SELECT u.city_id FROM user u WHERE u.phone = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param('i',$phone);
        $result->execute();
        return $result->get_result();
    }

}