<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 11/12/2017
 * Time: 11:56 AM
 */
require_once 'model/Ostan.php';

class PresentOstan
{
    public static function getOstan(){

        $model = new Ostan();
        $result = $model->getOstan();
        $res = array();
        while ($row = $result->fetch_assoc()){
            $ostan = array();
            $ostan['id'] = $row['id'];
            $ostan['name'] = $row['name'];
            $res[] = $ostan;
        }

        if($res){
            return json_encode($res);
        }else{
            $res['erorr'] ="ok";
            $res['emopty'] ="ok";
            return json_encode($res);
        }

    }

    public static function search($flag){
        $ostan = new Ostan();
        $result = $ostan->search($flag);
        $res = array();
        while ($row = $result->fetch_assoc()){
            $ostan = array();
            $ostan['id'] = $row['id'];
            $ostan['name'] = $row['name'];
            $res[] = $ostan;
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