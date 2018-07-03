<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 12/17/2017
 * Time: 3:17 PM
 */


require_once 'model/VerifyCode.php';

class PresentVerifyCode
{

    public static function SendVerifyCode($phone)
    {

        $result = (new VerifyCode())->getVerifyCodeData($phone);
        $row = $result->fetch_assoc();
        if (sizeof($row) > 0) {
            if (getJDate(null) <= $row['sending_day']) {
                SendingEmail::sendVerifyCode($phone, $row['code']);
                $res = array();
                $message = array();
                $message['code'] = 1;
                $res[] = $message;
                return json_encode($res);
            } else
                return self::createAndSaveSmsCode($phone);
        }
        return self::createAndSaveSmsCode($phone);
    }

    public static function createAndSaveSmsCode($phone)
    {
        $verifyCode = rand(100000, 999999);
        $model = new VerifyCode();
        $result = $model->saveSmsCode($phone, $verifyCode, getJDate(null));
        SendingEmail::sendVerifyCode($phone, $verifyCode);
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function checkedSmsCode($phone, $code)
    {
        $model = new VerifyCode();
        $getCode = $model->getSmsCode($phone);
        if ($getCode == $code) {
            $model->removeVerifyCode($phone);
            return true;
        } else {
            return false;
        }
    }
}