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
    public static function add($idCourse, $idTeacher, $acUser, $cellPhone)
    {
        $idUser = (new User())->getPhoneByAc($acUser);
        $sabtenam = new Sabtenam();
        $result = $sabtenam->add($idCourse, $idTeacher, $idUser, getJDate(null));
        (new User())->saveCellPhone($idUser, $cellPhone);
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function checkValieded($ac, $courseId)
    {
        $message = array();
        $userId = (new User())->getPhoneByAc($ac);
        $registerList = (new Sabtenam())->getByUserId($userId);
        while ($row = $registerList->fetch_assoc()) {
            if ($courseId == $row['cource_id']) {
                if ($row['is_canceled'] == 2)
                    continue;
                else if ($row['vaziat'] == 0)
                    $message['code'] = -2;
                else if ($row['is_canceled'] == 1)
                    $message['code'] = -3;
                else {
                    $message['code'] = (new Comment())->getRatByCourseIdAndUserId($courseId, $userId);
                    break;
                }
            }
        }
        if (!$message)
            $message['code'] = -1;
        $res = array();
        $res [] = $message;
        return json_encode($res);

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
            $user = array();
            $user['sabtenamId'] = $row['id'];
            $user['name'] = (new User())->getUserName($row['user_id']);
            $user['apiCode'] = $row['user_id'];
            $user['status'] = $row['vaziat'];
            $user['cellPhone'] = (new User())->getCellPhone($idTeacher);
            $user['isCanceled'] = $row['is_canceled'];
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

    public static function getNotifyData($teacherApi, $lastId)
    {

        $teacherId = (new User())->getPhoneByAc($teacherApi);
        $result = (new Sabtenam())->getNotifyData($teacherId, $lastId);
        $res = array();
        while ($row = $result->fetch_assoc()) {

            $notifyData = array();
            $notifyData['name'] = (new Course())->getCourseName($row['cource_id']);
            $notifyData['lastId'] = $row['id'];
            $res [] = $notifyData;

        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);
    }

}