<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 25-Jun-18
 * Time: 11:58 PM
 */

require_once 'model/BookMark.php';
require_once 'model/User.php';

class PresentBookMark
{
    public static function saveBookMark($courseId, $userApi)
    {

        $userId = (new User())->getPhoneByAc($userApi);
        $result = (new BookMark())->saveBookMark($courseId, $userId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);

    }


    public static function removeBookMark($courseId, $userApi)
    {

        $userId = (new User())->getPhoneByAc($userApi);
        $result = (new BookMark())->removeBookMark($courseId, $userId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);
    }

}