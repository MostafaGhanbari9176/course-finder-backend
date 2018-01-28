<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 27-Dec-17
 * Time: 4:56 PM
 */
require_once 'model/Teacher.php';
require_once 'model/City.php';
class PresenterTeacher
{

    public static function addTeacher($phone,$landPhone,$address,$subject,$tozihat,$type, $cityId){

        $model = new User();
        $res = array();
        if($model->changeUserType($phone,1)){
            $teacher = new Teacher();
            $result = $teacher->addTeacher($phone,$landPhone,$address,self::getDate(),$subject,$cityId,$tozihat,$type);
            $res["code"] = $result;
            if($result==0)
                $model->changeUserType($phone,0);

        }
        else{
            $res["code"] = 0;
        }
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getTeacher($phone){
        $teacher = new Teacher();
        $rezult = $teacher->getTeacher($phone);
        $res = array();
        while($row = $rezult->fetch_assoc()){
            $teacher = array();
            $teacher['phone'] = $row['phone'];
            $teacher['landPhone'] = $row['land_phone'];
            $teacher['type'] = $row['type'];
            $teacher['address'] = $row['address'];
            $teacher['madrak'] = $row['madrak'];
            $teacher['subject'] = $row['subject'];
            $teacher['cityId'] = $row['city_id'];
            $teacher['location'] = PresentUser::location($row['city_id']);
            $res[] = $teacher;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $res['erorr'] = "ok";
            $res['empoty'] = "ok";
            return json_encode($res);
        }
    }

    public static function updateTeacher($phone, $landPhone, $madrak, $subject, $address, $cityId){
        $teacher = new Teacher();
        $rezult = $teacher->updateTeacher($phone, $landPhone, $subject, $address, $cityId, $madrak);
        $res = array();
        $res['code'] = $rezult;
        $message = array();
        $message[] = $res;
        return json_encode($message);


    }

    static function getDate(){
       return date("Y/m/d");
    }

    static function getCityId($phone){
        $model = new City();
        $result = $model->cityId($phone);
        $row =  $result->fetch_assoc();
        return $row['city_id'];

    }

}