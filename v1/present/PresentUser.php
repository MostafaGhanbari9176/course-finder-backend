<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 11/16/2017
 * Time: 1:03 PM
 */
require_once 'model/User.php';
require_once 'model/Sabtenam.php';

class PresentUser
{
    public static function logUP($phone, $name, $code)//0-->badCod  1-->ok  2--> badLogUp
    {
        $apiCode = PresentUser::createApiCode($phone);
        $res = array();
        if (PresentSmsCode::checkedSmsCode($phone, $code)) {
            $model = new User();
            $result = $model->logUp($phone, $name, $apiCode);
            if ($result) {
                $res["code"] = 1;
                $res["apiCode"] = $apiCode;
            } else
                $res["code"] = 2;
        } else
            $res["code"] = 0;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function logIn($phone, $code)//0-->badCod  1-->okAndIsUser  2-->okAndIsTeacher  3--> badLogIn
    {
        $apiCode = PresentUser::createApiCode($phone);
        $res = array();
        if (PresentSmsCode::checkedSmsCode($phone, $code)) {
            $model = new User();
            $result = $model->logIn($phone, $apiCode);
            if ($result == 1) {
                $res["name"] = (new User())->getUser($phone)->fetch_assoc()['name'];
                $res["code"] = 1;
                $res["apiCode"] = $apiCode;
            } else if ($result == 2) {
                $res["name"] = (new User())->getUser($phone)->fetch_assoc()['name'];
                $res["code"] = 2;
                $res["apiCode"] = $apiCode;
            } else if ($result == 0) {
                $res["code"] = 3;
            }
        } else
            $res["code"] = 0;
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

    public static function checkUserStatuse($userAc)
    {

        if (hash_equals($userAc, "OP's"))
            $result = 0;
        else {

            $model = new User();
            $userId = $model->getPhoneByAc($userAc);
            $result = $model->getUserStatuse($userId);
        }
        $res = array();
        $user = array();
        $user['code'] = $result;
        $res[] = $user;
        return json_encode($res);

    }

    public
    static function updateUser($phone, $name)
    {
        $model = new User();
        $result = $model->updateUser($phone, $name);
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public
    static function getUser($phone)
    {
        $model = new User();
        $result = $model->getUser($phone);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            $user = array();
            $user['phone'] = $row['phone'];
            $user['name'] = $row['name'];
            $user['family'] = $row['family'];
            $user['status'] = $row['status'];
            $user['type'] = $row['type'];
            $user['cityId'] = $row['city_id'];
            $user['apiCode'] = $row['api_code'];
            $user['location'] = PresentUser::location($row['city_id']);
            $res[] = $user;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $user = array();
            $user['erorr'] = "ok";
            $user['empoty'] = "ok";
            $res[] = $user;
            return json_encode($res);
        }
    }

    public
    static function logOut($phone)
    {
        $model = new User();
        $result = $model->logOut($phone);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public
    static function location($cityId)
    {

        $model = new City();
        $result = $model->locatin($cityId);
        $row = $result->fetch_assoc();
        return $row['name'] . " , " . $row['city_name'];
    }

    public
    static function createApiCode($phone)
    {
        $min = array();
        $apiCode = "";
        $milliseconds = str_split(round(microtime(true) * 1000));
        $phone = str_split($phone);
        if (sizeof($phone) >= sizeof($milliseconds)) {
            $min = $milliseconds;
        } else {
            $min = $phone;
        }
        for ($i = count($min) - 1; $i >= 0; $i--) {
            $apiCode = $apiCode . $phone[$i] . $milliseconds[$i];
        }
        return $apiCode;
    }
}