<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 27-Dec-17
 * Time: 4:56 PM
 */
require_once 'model/Teacher.php';
require_once 'model/City.php';
require_once 'model/User.php';
require_once 'PresentSubscribe.php';
require_once 'model/Favorite.php';

class PresenterTeacher
{


    public static function addTeacher($ac, $landPhone, $subject, $tozihat, $type, $lat, $lon, $address)
    {
        $phone = (new User())->getPhoneByAc($ac);
        $model = new User();
        $res = array();
        if ($model->changeUserType($phone, 1)) {
            $teacher = new Teacher();
            $result = $teacher->addTeacher($phone, $landPhone, getJDate(null), $subject, $tozihat, $type, $lat, $lon, $phone, $address);
            $res["code"] = $result;
            if ($result == 0)
                $model->changeUserType($phone, 0);

        } else {
            $res["code"] = 0;
        }
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getFavoriteTeachers($userApi)
    {
        $userId = (new User())->getPhoneByAc($userApi);
        $teacher = new Teacher();
        $rezult = $teacher->getAllTeacher();
        $res = array();
        while ($row = $rezult->fetch_assoc()) {
            if ($row['madrak'] != 2 /*|| ((new Subscribe())->getUserBuyDate($row['phone'])) < getJDate(null)*/)
                continue;
            if ((new Favorite())->checkFavorite($row['phone'], $userId) == 1) {
                $teacher = array();
                $teacher['ac'] = $row['phone'];
                $teacher['subject'] = $row['subject'];
                $teacher['lt'] = $row['lat'];
                $teacher['lg'] = $row['lon'];
                $teacher['pictureId'] = $row['picture_id'];
                $res[] = $teacher;
            }
        }
        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return json_encode($res);

    }

    public static function getTeacher($teacherId, $userApi)
    {

        $userId = (new User())->getPhoneByAc($userApi);
        $result = (new Teacher())->getTeacher($teacherId);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            $teacher = array();
            $teacher['landPhone'] = $row['land_phone'];
            $teacher['pictureId'] = $row['picture_id'];
            $teacher['favorite'] = (new Favorite())->checkFavorite($teacherId, $userId);
            $teacher['phone'] = $row['phone'];
            $teacher['type'] = $row['type'];
            $teacher['m'] = $row['madrak'];
            $teacher['subject'] = $row['subject'];
            $teacher['lt'] = $row['lat'];
            $teacher['lg'] = $row['lon'];
            $teacher['tozihat'] = $row['tozihat'];
            $teacher['address'] = $row['address'];
            $res[] = $teacher;
        }
        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return json_encode($res);

    }

    public static function getSelectedTeacher()
    {

        $teacher = new Teacher();
        $rezult = $teacher->getAllTeacher();
        $res = array();
        while ($row = $rezult->fetch_assoc()) {
            $TeacherRat = PresentComment::calculateTeacherRat($row['phone']);
            if ($TeacherRat < (float)3.5/* || ((new Subscribe())->getUserBuyDate($row['phone'])) < getJDate(null)*/ || $row['madrak'] != 2)
                continue;
            $teacher = array();
            $teacher['pictureId'] = $row['picture_id'];
            $teacher['ac'] = $row['phone'];
            $teacher['subject'] = $row['subject'];
            $teacher['teacherRat'] = $TeacherRat;
            $res[] = $teacher;
        }

        if (sizeof($res) >= 10) {
            $index = array();
            $limitedRes = array();
            $counter = 0;
            $index[] = rand(0, sizeof($res));
            $limitedRes[] = $res[$index[0]];
            for ($i = 0; $i < sizeof($res); $i++) {
                if ($counter >= 5)
                    break;
                $randome = rand(0, sizeof($res));
                $flag = true;
                for ($j = 0; $j < sizeof($index); $j++) {
                    if ($randome == $index[$j]) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    $limitedRes[] = $res[$randome];
                    $index[] = $randome;
                    $counter++;
                }
            }
            if ($limitedRes)
                return json_encode($limitedRes);
        }
        if ($res) {
            return json_encode($res);
        } else {
            $message = array();
            $res['empty'] = (int)1;
            $message[] = $res;
            return json_encode($message);
        }
    }

    public static function getNewTeacher()
    {
        $model = new Teacher();
        $result = $model->getNewTeacher();
        $res = array();
        while ($row = $result->fetch_assoc()) {
            if ($row['madrak'] != 2 /*|| ((new Subscribe())->getUserBuyDate($row['phone'])) < getJDate(null)*/)
                continue;
            $teacher = array();
            $teacher['pictureId'] = $row['picture_id'];
            $teacher['ac'] = $row['phone'];
            $teacher['subject'] = $row['subject'];
            $teacher['teacherRat'] = PresentComment::calculateTeacherRat($row['phone']);
            $res[] = $teacher;
        }
        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return $res;
    }

    public static function getCustomTeacherListForHome()
    {
        $res = array();
        $item = array();
        $item['teachers'] = self::getNewTeacher();
        $item['groupSubject'] = 'آموزشگاهای جدید';
        $res[] = $item;
        if (!$res) {
            $message = array();
            $message ['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);
    }

    public static function getAllTeacher()
    {
        $teacher = new Teacher();
        $rezult = $teacher->getAllTeacher();
        $res = array();
        while ($row = $rezult->fetch_assoc()) {
            if ($row['madrak'] != 2 /*|| ((new Subscribe())->getUserBuyDate($row['phone'])) < getJDate(null)*/)
                continue;
            $teacher = array();
            $teacher['ac'] = $row['phone'];
            $teacher['subject'] = $row['subject'];
            $teacher['lt'] = $row['lat'];
            $teacher['lg'] = $row['lon'];
            $teacher['pictureId'] = $row['picture_id'];
            $res[] = $teacher;
        }
        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return json_encode($res);
    }


    public static function updateMadrakState($ac)
    {
        $phone = (new User())->getPhoneByAc($ac);
        $teacher = new Teacher();
        $result = $teacher->updateMadrakState($phone, 1);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getMadrakStateAndRat($ac)
    {
        $res = array();
        $phone = (new User())->getPhoneByAc($ac);
        $teacher = new Teacher();
        $rezult = $teacher->getMadrakState($phone);

        if ($rezult == -1) {
            $res['ms'] = base64_encode((base64_encode("error")));
            $res['code'] = -1;
        } else if ($rezult == 0) {
            $res['ms'] = base64_encode((base64_encode("notbar")));
            $res['code'] = -1;
        } else if ($rezult == 1) {
            $res['ms'] = base64_encode((base64_encode("yesbarnotok")));
            $res['code'] = -1;
        } else if ($rezult == 2) {
            $res['ms'] = base64_encode((base64_encode("barok")));
            $res['code'] = (new PresentComment())->calculateTeacherRat((new User())->getPhoneByAc($ac));
        }
        //  $res['code'] = $rezult;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    static function getCityId($phone)
    {
        $model = new City();
        $result = $model->cityId($phone);
        $row = $result->fetch_assoc();
        return $row['city_id'];

    }

    public static function getNotifyData()
    {

        $result = (new Teacher())->getNotifyData(getJDate(null));
        $res = array();
        while ($row = $result->fetch_assoc()) {

            $notifyData = array();
            $notifyData['apiCode'] = $row['phone'];
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