<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 30-May-18
 * Time: 2:52 AM
 */
require_once 'model/FeedBack.php';
require_once 'model/User.php';
require_once 'model/SendingEmail.php';

class PresentFeedBack
{
    public static function saveFeedBack($feedBackText, $ac)
    {
        $userId = (new User())->getPhoneByAc($ac);
        $result = (new FeedBack())->saveFeedBack($feedBackText, $userId, getJDate(null));
        SendingEmail::sendFeedBackForMaster($feedBackText, $userId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);
    }

}