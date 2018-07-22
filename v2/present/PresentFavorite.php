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
    public static function saveFavorite($teacherId, $userApi)
    {
        $user = new User();
        $userId = $user->getPhoneByAc($userApi);
        $result = (new Favorite())->saveFavorite($teacherId, $userId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);
    }

    public static function removeFavorite($teacherId, $userApi)
    {
        $user = new User();
        $userId = $user->getPhoneByAc($userApi);
        $result = (new Favorite())->removeFavorite($teacherId, $userId);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);
    }
}