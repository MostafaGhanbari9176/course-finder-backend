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
        if (((new SmsCode())->getCounter($phone)) < 3) {
            $model = new SmsCode();
            $result = $model->saveSmsCode($phone, rand(100000, 999999));
        } else
            $result = 0;
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
        if ($getCode == $code) {
            return true;
        } else {
            return false;
        }
    }
}