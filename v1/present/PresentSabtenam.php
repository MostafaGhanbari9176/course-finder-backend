<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 2/1/2018
 * Time: 11:53 AM
 */
require_once 'model/Sabtenam.php';

class PresentSabtenam
{
    public static function add($idCourse, $idTeacher, $idUser)
    {
        $result = 2;
        if (self::checkValieded($idUser, $idCourse)) {
            $sabtenam = new Sabtenam();
            $result = $sabtenam->add($idCourse, $idTeacher, $idUser, self::getDate());
        }
        $res = array();
        $res["code"] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getByUserId($id)
    {
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByUserId($id);

        $res = array();
        while ($courseId = $resuelt1->fetch_assoc()) {
            $course = new Course();
            $resuelt = $course->getCourseById($courseId['cource_id']);
            while ($row = $resuelt->fetch_assoc()) {
                $course = array();
                $course['id'] = $row['cource_id'];
                $course['idTeacher'] = $row['teacher_id'];
                $course['CourseName'] = $row['subject'];
                $course['type'] = $row['type'];//
                $course['capacity'] = $row['capacity'];//
                $course['mony'] = $row['mony'];//
                $course['sharayet'] = $row['sharayet'];//
                $course['tozihat'] = $row['tozihat'];//
                $course['endDate'] = $row['end_date'];//
                $course['day'] = $row['day'];//
                $course['hours'] = $row['hours'];//
                $course['range'] = $row['old_range'];//
                $course['idTabaghe'] = $row['tabaghe_id'];//
                $course['startDate'] = $row['start_date'];
                $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                $course['tabaghe'] = (new Course())->getTabaghe($row['cource_id']);
                $res[] = $course;
            }
        }

        if ($res) {
            return json_encode($res);
        } else {
            $res['erorr'] = "ok";
            $res['empoty'] = "ok";
            return json_encode($res);
        }
    }

    public static function checkValieded($idUser, $idCourse)
    {
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByUserId($idUser);
        while ($row = $resuelt1->fetch_assoc()) {
            if ($idCourse == $row['cource_id'])
                return false;
        }
        return true;
    }

    static function getDate()
    {
        return date("Y/m/d");
    }
}