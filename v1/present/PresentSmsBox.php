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

    public static function getRsSms($rsId)
    {
        $rsPhone = (new User())->getPhoneByAc($rsId);
        $model = new SmsBox();
        $result = $model->getRsSms($rsPhone);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            $sms = array();
            $sms['id'] = $row['id'];
            $sms['tsId'] = $row['ts_id'];
            $sms['text'] = $row['text'];
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
            $sms = array();
            $sms['id'] = $row['id'];
            $sms['rsId'] = $row['rs_id'];
            $sms['text'] = $row['text'];
            if ($row['how_sending'] == 0)
                $sms['rsName'] = (new User())->getUserName($row['rs_id']);
            else
                $sms['rsName'] = "آموزشگاه ".(new Teacher())->getTeacherName($row['rs_id']);
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

    public static function upDateSeen($id){
        $model = new SmsBox();
        $result = $model->upDateSeen($id);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function deleteSms($id){
        $model = new SmsBox();
        $result = $model->deleteSms($id);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

}