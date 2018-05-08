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

//require 'present/PresentSmsBox.php';

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
        $result = -1;//////  هنگام ثبتنام نداشتن منفی یک بر میگردد اصلاح شود
        $vaziat = -1;
        $isCanceled = -1;
        while ($row = $resuelt1->fetch_assoc()) {
            if ($idCourse == $row['cource_id']) {
                $vaziat = $row['vaziat'];
                $isCanceled = $row['is_canceled'];
                if ($isCanceled == 2)
                    continue;
                $result = (new Comment())->getRatByCourseIdAndUserId($idCourse, $idUser);
                break;
            }
        }

        if ($result == null)
            $result = 0;
        $res = array();
        if ($isCanceled == 1)
            $res['code'] = -3;
        else if ($vaziat == 0)
            $res['code'] = -2;
        else
            $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public static function updateCanceledFlag($sabteNameId, $code, $courseId, $message, $tsId, $rsId)
    {
        $model = new Sabtenam();
        $result = 0;
        if ($model->updatecanceledFlag($sabteNameId, $code)) {
            $result = 1;
            if ($code == 1) {
                (new Course())->incrementCapacity($courseId);
                PresentSmsBox::saveSms($message, $tsId, $rsId, $courseId, 1);
            }
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public
    static function updateMoreCanceledFlag($data, $message)
    {
        $students = json_decode($data, true);
        $model = new Sabtenam();
        $course = new Course();
        for ($i = 0; $i < sizeof($students); $i++) {
            $model->updatecanceledFlag($students[$i]['sabtenamId'], 1);
            $course->incrementCapacity($students[$i]['courseId']);
            PresentSmsBox::saveSms($message, $students[$i]['ac'], $students[$i]['userId'], $students[$i]['courseId'], 1);
        }
        $res = array();
        $res['code'] = 1;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public
    static function confirmStudent($SabtenamId, $courseId, $message, $tsId, $rsId)
    {

        $model = new Sabtenam();
        $result = 0;
        if ($model->confirmStudent($SabtenamId)) {
            $result = (new Course())->decrementCapacity($courseId);
            PresentSmsBox::saveSms($message, $tsId, $rsId, $courseId, 1);
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }


    public
    static function confirmMoreStudent($data, $message)
    {

        $students = json_decode($data, true);
        $sabtenam = new Sabtenam();
        $course = new Course();
        for ($i = 0; $i < sizeof($students); $i++) {
            $sabtenam->confirmStudent($students[$i]['sabtenamId']);
            $course->decrementCapacity($students[$i]['courseId']);
            PresentSmsBox::saveSms($message, $students[$i]['ac'], $students[$i]['userId'], $students[$i]['courseId'], 1);
        }
        $res = array();
        $res['code'] = 1;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public
    static function getRegistrationsName($courseId, $acTeacher)
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

    public
    static function getNumberOfWaitingStudent($teacherId, $courseId)
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