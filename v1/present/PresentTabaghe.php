<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 1/29/2018
 * Time: 9:13 AM
 */

require_once 'model/Tabaghe.php';
class PresentTabaghe
{
    public static function getTabaghe($uperId){
        $tabaghe = new Tabaghe();
        $rezult = $tabaghe->getTabaghe($uperId);
        $res = array();
        while($row = $rezult->fetch_assoc()){
            $tabaghe = array();
            $tabaghe['id'] = $row['id'];
            $tabaghe['subject'] = $row['subject'];
            $tabaghe['uperId'] = $row['uper_id'];
            $res[] = $tabaghe;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $tabaghe = array();
            $tabaghe['id'] = -1;
            $tabaghe['subject'] = -1;
            $tabaghe['uperId'] = -1;
            $res[] = $tabaghe;
            return json_encode($res);
        }
    }

}