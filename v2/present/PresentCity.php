<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 11/21/2017
 * Time: 12:31 PM
 */
require_once 'model/City.php';
class PresentCity
{
    public static function getCity($flag){

        $city = new City();
        $result = $city->getCity($flag);
        $res = array();
        while ($row = $result->fetch_assoc()){
            $city = array();
            $city['name'] = $row['city_name'];
            $city['ostanId'] = $row['ostan_id'];
            $city['cityId'] = $row['city_id'];
            $res[] = $city;

        }
        if($res){
            return json_encode($res);
        }else{
            $res['erorr'] ="ok";
            $res['emopty'] ="ok";
            return json_encode($res);
        }
    }


}