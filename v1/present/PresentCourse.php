<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 1/29/2018
 * Time: 1:38 PM
 */
require_once 'model/Course.php';
require_once 'model/User.php';
require_once 'model/Sabtenam.php';


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
            $course['range'] = $row['min_old'];//
            $course['idTabaghe'] = $row['tabaghe_id'];//
            $course['startDate'] = $row['start_date'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['tabaghe'] = (new Course())->getTabaghe($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empoty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function getNewCourse()
    {

        $arr = array();
        $course = new Course();
        $resuelt = $course->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $course = array();
            $arr['date'] = $row['definition_date'];
            $arr['delay'] = 7;
            $range_date = getJDate($arr);
            if (strcmp($range_date, getJDate(null)) > 0) {
                $course['id'] = $range_date;
                $course['idTeacher'] = getJDate(null);
                $course['CourseName'] = $row['subject'];
                $course['type'] = $row['type'];//
                $course['capacity'] = $row['capacity'];//
                $course['mony'] = $row['mony'];//
                $course['sharayet'] = $row['sharayet'];//
                $course['tozihat'] = $row['tozihat'];//
                $course['endDate'] = $row['end_date'];//
                $course['day'] = $row['day'];//
                $course['hours'] = $row['hours'];//
                $course['range'] = $row['min_old'];//
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
            $course = array();
            $course['empoty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function getCourseById($id)
    {
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
            $course['range'] = $row['min_old'];//
            $course['idTabaghe'] = $row['tabaghe_id'];//
            $course['startDate'] = $row['start_date'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['tabaghe'] = (new Course())->getTabaghe($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empoty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function getCourseByTeacherId($ac)
    {
        $phone = (new User())->getPhoneByAc($ac);
        $course = new Course();
        $resuelt = $course->getCourseByTeacherId($phone);
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
            $course['range'] = $row['min_old'];//
            $course['idTabaghe'] = $row['tabaghe_id'];//
            $course['startDate'] = $row['start_date'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['tabaghe'] = (new Course())->getTabaghe($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empoty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function getByUserId($ac)
    {
        $phone = (new User())->getPhoneByAc($ac);
        $sabtenam = new Sabtenam();
        $resuelt1 = $sabtenam->getByUserId($phone);

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
                $course['range'] = $row['min_old'];//
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
            $course = array();
            $course['empoty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }


}