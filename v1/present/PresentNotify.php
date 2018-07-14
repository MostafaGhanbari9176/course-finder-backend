<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 7/12/2018
 * Time: 11:28 AM
 */

require_once 'model/Notify.php';
require_once 'model/Course.php';
require_once 'model/User.php';

class PresentNotify
{

    public static function saveOrUpDateNotifyData($ac, $courseId, $startNotify, $weakNotify)
    {

        $courseData = (new Course())->getCourseById($courseId)->fetch_assoc();
        $userId = (new User())->getPhoneByAc($ac);
        $model = new Notify();
        $result = $model->saveNotifySettingData($userId, $courseId, $courseData['subject'], $startNotify, $weakNotify == 1 ? $courseData['day'] : 'a', $courseData['start_date'], $courseData['end_date']);
        if (!$result)
            $model->updateNotifySettingData($userId, $courseId, $startNotify, $weakNotify == 1 ? $courseData['day'] : 'a');
        $res = array();
        $message = array();
        $message['code'] = 1;
        $res[] = $message;
        return json_encode($res);

    }

    public static function getWeakNotify($ac)
    {

        $result = (new Notify())->getWeakNotifyData((new User())->getPhoneByAc($ac));
        $res = array();
        while ($row = $result->fetch_assoc()) {

            $courseData = array();
            $courseData['name'] = $row['subject'];
            $courseData['days'] = $row['days'];
            $res[] = $courseData;
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);
    }

    public static function getStartNotify($ac, $tomDate)
    {

        $result = (new Notify())->getStartNotifyData((new User())->getPhoneByAc($ac), $tomDate);
        $res = array();
        while ($row = $result->fetch_assoc()) {

            $courseData = array();
            $courseData['name'] = $row['subject'];
            $res[] = $courseData;
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);
    }

    public static function getSettingNotify($ac, $courseId)
    {

        $result = (new Notify())->getSettingNotify((new User())->getPhoneByAc($ac), $courseId);
        $res = array();
        while ($row = $result->fetch_assoc()) {

            $courseData = array();
            $courseData['startNotify'] = $row['start_notify'];
            $courseData['weakNotify'] = $row['days'] === 'a' ? 0 : 1;
            $res[] = $courseData;
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);

    }
}