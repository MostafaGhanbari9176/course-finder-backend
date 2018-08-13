<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 26-Jun-18
 * Time: 11:24 PM
 */

require_once 'model/Gift.php';
require_once 'model/User.php';
require_once 'model/Subscribe.php';

class PresentGift
{
    //0 ==> notValid  1==> ok   -1==> choseAgain
    public static function checkGift($giftCode, $userApi)
    {
        $code = 0;
        $userId = (new User())->getPhoneByAc($userApi);
        $userSub = (new Subscribe())->getUserSubscribe($userId);
        $gift = new Gift();
        $giftData = $gift->getGifData($giftCode);
        if (sizeof($giftData) > 0 && self::checkGiftValidation($giftData)) {
            $subId = $giftData['subscribe_id'];

            if (sizeof($userSub) > 0) {
                if ($subId == $userSub['subscribe_id'])
                    $code = -1;
                else {
                    $code = self::buy($giftData['subscribe_id'], $userApi);
                    $gift->decrementCounter($giftCode);
                }
            } else {
                $code = self::buy($giftData['subscribe_id'], $userApi);
                $gift->decrementCounter($giftCode);
            }
        }
        $res = array();
        $message['code'] = $code;
        $res[] = $message;
        return json_encode($res);

    }

    public static function getGiftCodes()
    {
        $result = (new Gift())->getGiftCodes();
        $res = array();
        while ($row = $result->fetch_assoc()) {

            if (self::checkGiftValidation($row)) {
                $giftData = array();
                $giftData['giftCode'] = $row['gift_code'];
                $giftData['counter'] = $row['counter'];
                $giftData['endHours'] = $row['end_hours'];
                $giftData['endDate'] = $row['end_date'];
                $giftData['state'] = $row['state'];
                $res[] = $giftData;
            }

        }
        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return json_encode($res);
    }

    private static function checkGiftValidation($giftData)
    {
        if ($giftData['counter'] > 0) {
            if (getJDate(null) < $giftData['end_date'])
                return true;
            else if (getJDate(null) == $giftData['end_date']) {
                if (date("H") <= $giftData['end_hours'])
                    return true;
            }

        }
        return false;
    }


    private static function buy($subId, $userApi)
    {
        PresentSubscribe::saveUserBuy($userApi, "هدیه", "123456789".$subId);
        return 1;
    }
}