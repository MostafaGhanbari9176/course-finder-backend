<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 1/29/2018
 * Time: 1:38 PM
 */
require_once 'model/Course.php';
require_once 'model/User.php';

class PresentCourse
{

    public static function addCourse($ac, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, $start_date, $end_date, $day, $hours, $minOld, $maxOld)
    {
        $teacher_id = (new User())->getPhoneByAc($ac);
        $course = new Course();
        $rezult = $course->addCourse($teacher_id, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, $start_date, $end_date, $day, $hours, $minOld, $maxOld);
        $res = array();
        $res['code'] = $rezult;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getAllCourse()
    {
        $course = new Course();
        $resuelt = $course->getAllCourse();
        $res = array();
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
        if ($res) {
            return json_encode($res);
        } else {
            $res['erorr'] = "ok";
            $res['empoty'] = "ok";
            return json_encode($res);
        }
    }

    public static function getCourseById($id){
        $course = new Course();
        $resuelt = $course->getCourseById($id);
        $res = array();
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
        if ($res) {
            return json_encode($res);
        } else {
            $res['erorr'] = "ok";
            $res['empoty'] = "ok";
            return json_encode($res);
        }
    }
    public static function getCourseByTeacherId($id){
        $course = new Course();
        $resuelt = $course->getCourseByTeacherId($id);
        $res = array();
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
        if ($res) {
            return json_encode($res);
        } else {
            $res['erorr'] = "ok";
            $res['empoty'] = "ok";
            return json_encode($res);
        }
    }

}