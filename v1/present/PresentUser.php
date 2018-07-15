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
    public static $versionName = '1.0.6';


    public static function logUPWithPass($phone, $name, $code, $pass)//0-->badCod  1-->ok  2--> badLogUp
    {
        $apiCode = PresentUser::createApiCode($phone);
        $res = array();
        if (PresentVerifyCode::checkedSmsCode($phone, $code)) {
            $model = new User();
            $result = $model->logUpWithPass($phone, $name, $apiCode, $pass);
            if ($result) {
                $res["userType"] = 0;
                $res["apiCode"] = $apiCode;
            } else {
                $res["userType"] = 0;
                $res["apiCode"] = 2;
            }

        } else
            $res["userType"] = 0;
        $res["apiCode"] = 0;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }


    public static function logInWithPass($phone, $pass)//0-->badCod  1-->okAndIsUser  2-->okAndIsTeacher  3--> badLogIn
    {

        $res = array();
        if (self::checkPass($phone, $pass)) {
            $result = (new User())->getUser($phone)->fetch_assoc();
            if ($result['type'] == 0) {
                $res["apiCode"] = $result['api_code'];
                $res["name"] = $result['name'];
                $res["email"] = $result['phone'];
                $res["userType"] = $result['type'];
            } else
                return self::getTeacher($phone);

        } else {
            $res["apiCode"] = 0;
            $res["name"] = 0;
            $res["email"] = 0;
            $res["userType"] = 0;
        }
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }


    public function chosePass($email, $verifyCode, $pass)
    {

        $res = array();
        if (PresentVerifyCode::checkedSmsCode($email, $verifyCode)) {

            if ((new User())->chosePass($email, $pass))
                $res['code'] = 1;
            else
                return 2;

        } else
            $res["code"] = 0;
        $res["apiCode"] = 0;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    private static function getTeacher($phone)
    {

        $teacherData = (new Teacher())->getTeacher($phone)->fetch_assoc();
        $subData = (new Subscribe())->getUserSubscribe($phone);

        $buy = array();

        $buy['id'] = $subData['id'];
        $buy['vaziat'] = PresentSubscribe::haveASubscription($phone);
        $buy['buyDate'] = $subData['buy_date'];
        $buy['endBuyDate'] = $subData['end_buy_date'];
        $buy['remainingCourses'] = $subData['remaining_courses'];
        $buy['refId'] = $subData['ref_id'];

        $res = array();
        $user = array();
        $user['apiCode'] = (new User())->getAcByPhone($phone);
        $user['address'] = $teacherData['address'];
        $user['email'] = $teacherData['phone'];
        $user['subject'] = $teacherData['subject'];
        $user['landPhone'] = $teacherData['land_phone'];
        $user['madrak'] = $teacherData['madrak'];
        $user['MasterType'] = $teacherData['type'];
        $res["userType"] = 1;
        $user['sub'] = $buy;

        $res[] = $user;

        return json_encode($res);

    }

    private static function checkPass($phone, $pass)
    {

        return $result = (new User())->checkPass($phone, $pass);

    }

    public static function logUP($phone, $name, $code)//0-->badCod  1-->ok  2--> badLogUp
    {
        $apiCode = PresentUser::createApiCode($phone);
        $res = array();
        if (PresentVerifyCode::checkedSmsCode($phone, $code)) {
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
        if (PresentVerifyCode::checkedSmsCode($phone, $code)) {
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
        $user['versionName'] = self::$versionName;
        $res[] = $user;
        return json_encode($res);

    }


    public
    static function getUser($phone)
    {

        $buy = array();

        $buy['id'] = "subId";
        $buy['vaziat'] = "0=> notValid 1=>valid";
        $buy['buyDate'] = "1397-02-04";
        $buy['price'] = "per Month";
        $buy['endBuyDate'] = "1397-02-04";
        $buy['description'] = "description";
        $buy['subjectSubscribe'] = "subjectSubscribe";
        $buy['remainingCourses'] = "remainingCourses";
        $buy['refId'] = "refId";

        $res = array();
        $user = array();
        $user['apiCode'] = "apiCode";
        $user['name'] = "name";
        $user['address'] = "address";
        $user['email'] = "email";
        $user['subject'] = "subject";
        $user['landPhone'] = "landPhone";
        $user['madrak'] = "0=>notUploading 1=>uploadAndNotChecking 2=>uploadAndOK";
        $user['type'] = "0=>public 1=>private";
        $user['sub'] = $buy;

        $res[] = $user;

        return json_encode($res);


    }

    public
    static function logOut($ac)
    {
        $model = new User();
        $result = $model->logOut((new User())->getPhoneByAc($ac));
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