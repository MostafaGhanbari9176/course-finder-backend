<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 2/1/2018
 * Time: 11:53 AM
 */
require_once 'model/Sabtenam.php';
require_once 'model/User.php';

class PresentSabtenam
{
    public static function add($idCourse, $acTeacher, $acUser)
    {
        $idTeacher = (new User())->getPhoneByAc($acTeacher);
        $idUser = (new User())->getPhoneByAc($acUser);
        $result = 2;
        if (self::checkValieded($idUser, $idCourse)) {
            $sabtenam = new Sabtenam();
            $result = $sabtenam->add($idCourse, $idTeacher, $idUser, getJDate(null));
        }
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function checkValieded($idUser, $idCourse)
    {
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByUserId($idUser);
        while ($row = $resuelt1->fetch_assoc()) {
            if ($idCourse == $row['cource_id'])
                return false;
        }
        return true;
    }




}