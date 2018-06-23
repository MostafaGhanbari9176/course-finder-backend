<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 23-Jun-18
 * Time: 3:47 AM
 */

require_once 'model/Favorite.php';
require_once 'model/User.php';

class PresentFavorite
{
    public static function saveFavorite($teacherApi, $userApi)
    {
        $userId = (new User())->getPhoneByAc($userApi);
        $teacherId = (new User())->getPhoneByAc($teacherApi);
        $result = (new Favorite())->saveFavorite($teacherId, $userId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);
    }

    public static function checkFavorite($teacherId, $userId)
    {
        $result = (new Favorite())->checkFavorite($teacherId, $userId);
        return json_encode($result);
    }

    public static function removeFavorite($favoriteId)
    {

        $result = (new Favorite())->removeFavorite($favoriteId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);
    }
}