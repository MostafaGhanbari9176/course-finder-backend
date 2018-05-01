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
require_once 'model/Course.php';

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
        $vaziat = -1;
        while ($row = $resuelt1->fetch_assoc()) {
            if ($idCourse == $row['cource_id']) {
                $vaziat = $row['vaziat'];
                $result = (new Comment())->getRatByCourseIdAndUserId($idCourse, $idUser);
                break;
            }
        }

        if ($result == null)
            $result = 0;
        $res = array();
        if ($vaziat == 0)
            $res["code"] = -2;
        else
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

    public static function updateMoreCanceledFlag($data)
    {

        $students = json_decode($data);
        $resuelt = 0;
        $model = new Sabtenam();
        for ($i = 0; $i < sizeof($students); $i++) {
            if ($model->updatecanceledFlag($students[$i]['sabtenamId'], 1))
                $resuelt = (new Course())->incrementCapacity($students[$i]['courseId']);
        }
        $res = array();
        $res['code'] = 1;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public static function confirmStudent($ac, $SabtenamId, $courseId)
    {

        $idUser = (new User())->getPhoneByAc($ac);
        $model = new Sabtenam();
        $resuelt = $model->confirmStudent($SabtenamId, $idUser);
        $rezuelt2 = 0;
        if ($resuelt == 1)
            $rezuelt2 = (new Course())->decrementCapacity($courseId);
        $res = array();
        $res['code'] = $rezuelt2;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }


    public static function confirmMoreStudent($data)
    {

        $students = json_decode($data);
        $resuelt = 0;
        $user = new User();
        $sabtenam = new Sabtenam();
        for ($i = 0; $i < sizeof($students); $i++) {
            $idUser = $user->getPhoneByAc($students[$i]['ac']);
            if ($sabtenam->confirmStudent($students[$i]['sabtenamId'], $idUser))
                $resuelt = (new Course())->decrementCapacity($students[$i]['courseId']);
        }
        $res = array();
        $res['code'] = 1;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public static function getRegistrationsName($courseId, $acTeacher)
    {
        $idTeacher = (new User())->getPhoneByAc($acTeacher);
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByTeacherIdAndCourseId($idTeacher, $courseId);
        $res = array();
        while ($row = $resuelt1->fetch_assoc()) {
            if ($row['is_canceled'] != 0)
                continue;
            $user = array();
            $user['sabtenamId'] = $row['id'];
            $user['name'] = (new User())->getUserName($row['user_id']);
            $user['apiCode'] = (new User())->getAcByPhone($row['user_id']);
            $user['status'] = $row['vaziat'];
            $res[] = $user;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $user = array();
            $user['empty'] = 1;
            $res[] = $user;
            return json_encode($res);
        }

    }

    public static function getNumberOfWaitingStudent($teacherId, $courseId)
    {
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByTeacherIdAndCourseId($teacherId, $courseId);
        $counter = 0;
        while ($row = $resuelt1->fetch_assoc()) {
            if ($row['is_canceled'] != 0)
                continue;
            if ($row['vaziat'] == 0)
                $counter++;
        }
        return $counter;

    }

}