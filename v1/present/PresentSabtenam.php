<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 2/1/2018
 * Time: 11:53 AM
 */
require_once 'model/Sabtenam.php';
require_once 'model/User.php';
require_once 'model/Comment.php';

class PresentSabtenam
{
    public static function add($idCourse, $acTeacher, $acUser)
    {
        $idTeacher = (new User())->getPhoneByAc($acTeacher);
        $idUser = (new User())->getPhoneByAc($acUser);
        $sabtenam = new Sabtenam();
        $result = $sabtenam->add($idCourse, $idTeacher, $idUser, getJDate(null));
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function checkValieded($acUser, $idCourse)
    {
        $idUser = (new User())->getPhoneByAc($acUser);
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByUserId($idUser);
        $result = -1;
        while ($row = $resuelt1->fetch_assoc()) {
            if ($idCourse == $row['cource_id']) {
                $result = (new Comment())->getRatByCourseIdAndUserId($idCourse, $idUser);
                break;
            }
        }
        if ($result == null)
            $result = 0;
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public static function updateCanceledFlag($sabteNameId, $code)
    {
        $model = new Sabtenam();
        $resuelt = $model->updatecanceledFlag($sabteNameId, $code);
        $res = array();
        $res['code'] = $resuelt;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }


}