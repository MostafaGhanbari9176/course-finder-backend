<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/17/2017
 * Time: 3:17 PM
 */
require_once 'model/SmsCode.php';

class PresentSmsCode
{

    public static function creatAndSaveSmsCode($phone)
    {
        $model = new SmsCode();
        $result = $model->saveSmsCode($phone, rand(100000, 999999));
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function checkedSmsCode($phone, $code)
    {
        $model = new SmsCode();
        $getCode = $model->getSmsCode($phone);
        $res = 0;
        while ($row = $getCode->fetch_assoc()) {
            $res = $row['verify_code'];
        }

        if ($res == $code) {
            $res = array();
            $res["code"] = PresentSmsCode::logIn($phone);
            $message = array();
            $message[] = $res;
        } else {
            $res = array();
            $res["code"] = 0;
            $message = array();
            $message[] = $res;
        }
        return json_encode($message);
    }

    static function logIn($phone)
    {
        $model = new User();
        return $model->logIn($phone);
    }
}