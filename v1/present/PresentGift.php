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

    private static function checkGiftValidation($giftData)
    {
        if (getJDate(null) <= $giftData['end_date']) {

            if (date("H") <= $giftData['end_hours']) {

                if ($giftData['counter'] > 0)
                    return true;
            }
        }

        return false;
    }

    private static function buy($subId, $userApi)
    {
        PresentSubscribe::saveUserBuy($userApi, "هدیه", $subId);
        return 1;
    }
}