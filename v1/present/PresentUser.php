<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 11/16/2017
 * Time: 1:03 PM
 */
require_once 'model/User.php';

class PresentUser
{
    public static function logIn($phone)
    {

        $model = new User();
        $result = $model->logIn($phone);
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function updateUser($phone, $name, $family, $status, $type, $cityID, $apiCode)
    {
        $model = new User();
        $result = $model->updateUser($phone, $name, $family, $status, $type, $cityID, $apiCode);
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getUser($phone)
    {
        $model = new User();
        $result = $model->getUser($phone);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            $user = array();
            $user['phone'] = $row['phone'];
            $user['name'] = $row['name'];
            $user['family'] = $row['family'];
            $user['status'] = $row['status'];
            $user['type'] = $row['type'];
            $user['cityId'] = $row['city_id'];
            $user['apiCode'] = $row['api_code'];
            $user['location'] = PresentUser::location($row['city_id']);
            $res[] = $user;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $res['erorr'] = "ok";
            $res['empoty'] = "ok";
            return json_encode($res);
        }
    }

    public static function logOut($phone)
    {
        $model = new User();
        $result = $model->logOut($phone);
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function location($cityId)
    {

        $model = new City();
        $result = $model->locatin($cityId);
        $row = $result->fetch_assoc();
        return $row['name'] . " , " . $row['city_name'];
    }
}