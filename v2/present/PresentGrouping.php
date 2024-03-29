<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 1/29/2018
 * Time: 9:13 AM
 */

require_once 'model/Tabaghe.php';

class PresentGrouping
{
    public static function getTabagheByUperId($uperId)
    {
        $tabaghe = new Tabaghe();
        $rezult = $tabaghe->getTabagheByUperId($uperId);
        $res = array();
        while ($row = $rezult->fetch_assoc()) {
            $tabaghe = array();
            $tabaghe['id'] = $row['id'];
            $tabaghe['subject'] = $row['subject'];
            $tabaghe['uperId'] = $row['uper_id'];
            $tabaghe['isFinaly'] = $row['final'];
            $res[] = $tabaghe;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $tabaghe = array();
            $tabaghe['empty'] = 1;
            $res[] = $tabaghe;
            return json_encode($res);
        }
    }


    public static function getAllGrouping($uperId)
    {

        $tabaghe = new Tabaghe();
        $res = array();
        $groups = $tabaghe->getTabagheByUperId($uperId);
        // echo "uperID = " . $uperId;
        while ($row = $groups->fetch_assoc()) {
            $group = array();
            $group['id'] = $row['id'];
            $group['subject'] = $row['subject'];
            $group['uperId'] = $row['uper_id'];
            $group['isFinaly'] = $row['final'];
            if ($row['final'] == 0)
                $group['subCat'] = self::getAllGrouping($row['id']);
            else {
                $message = array();
                $message['empty'] = 1;
                $res2 = array();
                $res2 [] = $message;
                $group['subCat'] = $res2;
            }

            $res[] = $group;
        }
        return $res;
    }

}