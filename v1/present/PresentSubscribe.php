<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 13-Mar-18
 * Time: 12:58 PM
 */
require_once 'model/Subscribe.php';

class PresentSubscribe
{
    public static function haveASubscription($ac)
    {
        $have = 0;
        $userId = (new User())->getPhoneByAc($ac);
        $subs = new Subscribe();
        $result = $subs->getUserSubscribe($userId);
        while ($row = $result->fetch_assoc()) {
            if ($row['user_id'] == $userId && $row['remaining_courses'] > 0) {/////////////////////date not checked
                $have = 1;
                break;
            }
        }
        return $have;
    }

    public static function getSubscribeList()
    {
        $result = (new Subscribe())->getSubscribeList();
        $res = array();
        while ($row = $result->fetch_assoc()) {
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

    public static function getUserSubscribe($ac)
    {
        $res = array();
        $userId = (new User())->getPhoneByAc($ac);
        $subs = new Subscribe();
        $result = $subs->getUserSubscribe($userId);
        //$subscribeData = $subs->getSubscribe()
        while ($row = $result->fetch_assoc()) {
            $subscribe = array();
            $subscribe['id'] = $row['id'];
            $subscribe['price'] = $row['user_id'];
            $subscribe['period'] = $row['buy_date'];
            $subscribe['subject'] = $row['subscribe_id'];
            $subscribe['description'] = $row['vaziat'];
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

    public static function saveUserBuy($ac, $token, $subscribeId)
    {
        $userId = (new User())->getPhoneByAc($ac);
        $subscribe = new Subscribe();
        $result = $subscribe->saveUserBuy($userId, getJDate(null), $token, $subscribe->getRemainingCourse($subscribeId), $subscribeId);
        $res = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);

    }


}