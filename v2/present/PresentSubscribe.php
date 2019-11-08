<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 13-Mar-18
 * Time: 12:58 PM
 */
require_once 'model/Subscribe.php';
require_once 'model/User.php';

class PresentSubscribe
{
    public static function haveASubscription($userId)
    {
        $have = 0;
        $subs = new Subscribe();
        $row = $subs->getUserSubscribe($userId);
        if ($row['vaziat'] == 1 && $row['user_id'] == $userId && $row['remaining_courses'] > 0 && $row['end_buy_date'] >= getJDate(null))
            $have = 1;
        if ($row != null && sizeof($row) > 0 && $have == 0)
            $subs->updateVaziat($row['id'], 0);
        return $have;
    }

    public static function getSubscribeList()
    {
        $result = (new Subscribe())->getSubscribeList();
        $res = array();
        while ($row = $result->fetch_assoc()) {
            if ($row['price'] == 0)
                continue;
            $subscribe = array();
            $subscribe['id'] = $row['id'];
            $subscribe['price'] = $row['price'];
            $subscribe['period'] = $row['period'];
            $subscribe['subject'] = $row['subject'];
            $subscribe['description'] = $row['description'];
            $subscribe['remainingCourses'] = $row['remaining_courses'];
            $res[] = $subscribe;
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);

    }

    private static function decodingSubId($id)
    {
        $data = str_split($id);
        return $data[9];
    }

    public static function getUserSubscribe($ac)
    {
        $res = array();
        $userId = (new User())->getPhoneByAc($ac);
        PresentSubscribe::haveASubscription($userId);
        $subs = new Subscribe();
        $userBuy = $subs->getUserSubscribe($userId);
        if (sizeof($userBuy) > 0) {
            $subscribeData = $subs->getSubscribe($userBuy['subscribe_id']);
            $buy = array();
            $buy['userId'] = $ac;
            $buy['id'] = $userBuy['id'];
            $buy['vaziat'] = $userBuy['vaziat'];
            $buy['buyDate'] = base64_encode((base64_encode($userBuy['buy_date'])));
            $buy['price'] = $subscribeData['price'];
            $buy['endBuyDate'] = base64_encode((base64_encode($userBuy['end_buy_date'])));
            $buy['description'] = $subscribeData['description'];
            $buy['subjectSubscribe'] = $subscribeData['subject'];
            $buy['subscribeId'] = $userBuy['subscribe_id'];
            $buy['remainingCourses'] = $userBuy['remaining_courses'];
            $buy['refId'] = $userBuy['ref_id'];
            $res[] = $buy;
        }
        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);
    }

    public static function saveUserBuy($ac, $refId, $subscribeId)
    {
        $userId = (new User())->getPhoneByAc($ac);
        $subscribe = new Subscribe();
        $subscribeData = $subscribe->getSubscribe(self::decodingSubId($subscribeId));
        $result = $subscribe->saveUserBuy($userId, getJDate(null), getJDate($subscribeData['period']), $refId, $subscribeData['remaining_courses'], self::decodingSubId($subscribeId));
        $res = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);

    }

    public static function checkUserBuy($ac)
    {

        $userId = (new User())->getPhoneByAc($ac);
        $endDate = (new Subscribe())->getUserBuyDate($userId);
        $res = array();
        $message = array();
        $message['endBuyDate'] = $endDate;
        $res[] = $message;
        return json_encode($res);
    }

}