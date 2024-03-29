<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 27-Feb-18
 * Time: 8:36 PM
 */

require_once 'model/SmsBox.php';
require_once 'model/Teacher.php';
require_once 'model/user.php';


class PresentSmsBox
{
    public static function saveSms($text, $tsId, $rsId, $courseId, $howSending)
    {
        $rsPhone = (new User())->getPhoneByAc($rsId);
        $tsPhone = (new User())->getPhoneByAc($tsId);
        $model = new SmsBox();
        $result = $model->saveSms($text, $tsPhone, $rsPhone, $courseId, "00:00", getJDate(null), $howSending);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public
    static function sendMoreSms($data, $message)
    {
        $students = json_decode($data, true);
        for ($i = 0; $i < sizeof($students); $i++) {
            PresentSmsBox::saveSms($message, $students[$i]['ac'], $students[$i]['userId'], $students[$i]['courseId'], 1);
        }
        $res = array();
        $res['code'] = 1;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public static function getRsSms($rsId)
    {
        $rsPhone = (new User())->getPhoneByAc($rsId);
        $model = new SmsBox();
        $result = $model->getRsSms($rsPhone);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            if ($row['vaziat'] == 0)
                continue;
            $sms = array();
            $sms['id'] = $row['id'];
            $sms['tsId'] = (new User())->getAcByPhone($row['ts_id']);
            $sms['text'] = $row['text'];
            $sms['date'] = $row['date'];
            $sms['seen'] = $row['seen_flag'];
            $sms['courseId'] = $row['course_id'];
            if ($row['how_sending'] == 0)
                $sms['tsName'] = (new User())->getUserName($row['ts_id']);
            else
                $sms['tsName'] = (new Teacher())->getTeacherName($row['ts_id']);
            $sms['courseName'] = (new Course())->getCourseName($row['course_id']);
            $res[] = $sms;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function getTsSms($tsId)
    {
        $tsPhone = (new User())->getPhoneByAc($tsId);
        $model = new SmsBox();
        $result = $model->getTsSms($tsPhone);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            if ($row['vaziat'] == 0)
                continue;
            $sms = array();
            $sms['id'] = $row['id'];
            $sms['rsId'] = (new User())->getAcByPhone($row['rs_id']);
            $sms['text'] = $row['text'];
            $sms['date'] = $row['date'];
            $sms['seen'] = $row['seen_flag'];
            $sms['courseId'] = $row['course_id'];
//            if ($row['how_sending'] == 0)
            $sms['rsName'] = (new User())->getUserName($row['rs_id']);
            /*            else
                            $sms['rsName'] = "آموزشگاه ".(new Teacher())->getTeacherName($row['rs_id']);*/
            $sms['courseName'] = (new Course())->getCourseName($row['course_id']);
            $res[] = $sms;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function upDateSeen($id)
    {
        $model = new SmsBox();
        $result = $model->upDateSeen($id);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function deleteSms($id)
    {
        $model = new SmsBox();
        $result = $model->deleteSms($id);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getNotifyData($userApi, $lastId)
    {
        $userId = (new User())->getPhoneByAc($userApi);
        $result = (new SmsBox())->getNotifyData($userId, $lastId);
        $res = array();
        $counter = 0;
        $lastId = 0;
        while ($row = $result->fetch_assoc()) {
            $counter++;
            $lastId = $row['id'];
        }


        $message = array();
        $message['lastId'] = $lastId;
        $message['number'] = $counter;
        $res[] = $message;


        return json_encode($res);
    }

}