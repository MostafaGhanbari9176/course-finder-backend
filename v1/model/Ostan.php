<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 11/12/2017
 * Time: 11:51 AM
 */
require_once 'uses/DBConnection.php';

class ostan
{
    private $conn;
    private $tableName = "ostan";

    function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->connect();
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        mysqli_set_charset($this->conn, "UTF8");
    }

    public function getOstan(){

       // $sql  = " SELECT c.name , c.city_id , ostan_id FROM ostan o , city c WHERE c.ostan_id = (SELECT o.id WHERE o.name = 'آذربایجان شرقی')";
        $sql = "SELECT * FROM $this->tableName";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->get_result();
    }

    public function search($flag){
        $sql = "SELECT * FROM  $this->tableName WHERE name LIKE '%" . $flag . "%'";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->get_result();
    }


}