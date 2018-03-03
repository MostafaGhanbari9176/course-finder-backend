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
require_once 'model/Tabaghe.php';
require_once 'present/PresentGrouping.php';


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
            if ($row['is_deleted'] != 0)
                continue;
            $course = array();
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    /*    public static function getNewCourse()
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
                $course['empty'] = 1;
                $res[] = $course;
                return json_encode($res);
            }
        }

        public static function getFullCapacityCourse()
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
                    $course['id'] = $row['cource_id'];
    //              $course['idTeacher'] = $row['teacher_id'];
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
                $course['empty'] = 1;
                $res[] = $course;
                return json_encode($res);
            }
        }*/

    public static function updateDeletedFlag($courseId, $code)
    {
        $model = new Course();
        $resuelt = $model->updateDeletedFlag($courseId ,$code);
        $res = array();
        $res['code'] = $resuelt;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getCourseById($id)
    {
        $course = new Course();
        $resuelt = $course->getCourseById($id);
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $course = array();
            $course['id'] = $row['cource_id'];
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
            $course['CourseName'] = $row['subject'];
            $course['type'] = $row['type'];//
            $course['capacity'] = $row['capacity'];//
            $course['mony'] = $row['mony'];//
            $course['sharayet'] = $row['sharayet'];//
            $course['tozihat'] = $row['tozihat'];//
            $course['endDate'] = $row['end_date'];//
            $course['startDate'] = $row['start_date'];
            $course['day'] = $row['day'];//
            $course['hours'] = $row['hours'];//
            $course['minOld'] = $row['min_old'];//
            $course['maxOld'] = $row['max_old'];//
            $course['idTabaghe'] = $row['tabaghe_id'];//

            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['tabaghe'] = (new Tabaghe())->getGroupingSubjectByCourseId($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
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
            $course['tabaghe'] = (new Tabaghe())->getGroupingSubjectByCourseId($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
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
        while ($sabtenam = $resuelt1->fetch_assoc()) {
            $course = new Course();
            $resuelt = $course->getCourseById($sabtenam['cource_id']);

            while ($row = $resuelt->fetch_assoc()) {
                if ($row['is_deleted'] == 2 ||  $sabtenam['is_canceled'] == 2)
                    continue;
                $course = array();
                $course['id'] = $row['cource_id'];
                $course['isCanceled'] = $sabtenam['is_canceled'];
                $course['sabtenamId'] = (new Sabtenam())->getSabtenamIdByUserIdAndCourseId($sabtenam['user_id'], $row['cource_id']);
                $course['CourseName'] = $row['subject'];
                $course['startDate'] = $row['start_date'];
                $course['isDeleted'] = $row['is_deleted'];
                $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                $res[] = $course;
            }
        }

        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    public static function getCourseByGroupingId($id)
    {
        $res = array();
        $arr = self::creatGroupingArr($id);
        for ($i = 0; $i < count($arr); $i++) {
            $model = new Course();
            $result = $model->getCourseByGroupingId($arr[$i]['id']);
            $item = array();
            $courses = array();
            while ($row = $result->fetch_assoc()) {
                $course = array();
                $course['id'] = $row['cource_id'];
                $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                $course['CourseName'] = $row['subject'];

                /*                $course['idTeacher'] = $row['teacher_id'];
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
                                $course['tabaghe'] = (new Tabaghe())->getGroupingSubject($row['cource_id']);*/

                $courses[] = $course;
            }
            if ($courses) {
                $item['courses'] = $courses;
                $item['GroupingSubject'] = $arr[$i]['subject'];
                $res[] = $item;
            }
        }

        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    static function creatGroupingArr($id)
    {
        $model = new Tabaghe();
        $rezult = $model->getTabaghe($id);
        $res = array();
        while ($row = $rezult->fetch_assoc()) {
            $tabaghe = array();
            $tabaghe['id'] = $row['id'];
            $tabaghe['subject'] = $row['subject'];
            $res[] = $tabaghe;
        }
        for ($i = 0; $i < count($res); $i++) {

            $rezult = $model->getTabaghe($res[$i]['id']);
            while ($row = $rezult->fetch_assoc()) {
                $tabaghe = array();
                $tabaghe['id'] = $row['id'];
                $tabaghe['subject'] = $row['subject'];
                $res[] = $tabaghe;
            }
        }
        $tabaghe = array();
        $tabaghe['id'] = $id;
        $tabaghe['subject'] = (new Tabaghe())->getGroupingSubjectByGroupId($id);
        $res[] = $tabaghe;
        return $res;
    }

    static function searchCourse($minOld, $maxOld, $startDate, $endDate, $group, $day)
    {
        if ($day == "-1" && $group == -1)
            return self::serachEfectLessDaysAndGrouping($minOld, $maxOld, $startDate, $endDate);
        if ($group == -1)
            return self::serachEfectLessGrouping($minOld, $maxOld, $startDate, $endDate, $day);
        if ($day == "-1")
            return self::serachEfectLessDays($minOld, $maxOld, $startDate, $endDate, $group);

        return self::serchWithAllElements($minOld, $maxOld, $startDate, $endDate, $group, $day);
    }

    static function serachEfectLessDaysAndGrouping($minOld, $maxOld, $startDate, $endDate)
    {
        $model = new Course();
        $resuelt = $model->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $miOld = $row['min_old'];
            $maOld = $row['max_old'];
            $sD = $row['start_date'];
            $eD = $row['end_date'];
            if (!($miOld <= $minOld && $minOld <= $maOld))
                continue;
            if (!($miOld <= $maxOld && $maxOld <= $maOld))
                continue;
            if (!($startDate <= $sD && $sD <= $endDate))
                continue;
            if (!($startDate <= $eD && $eD <= $endDate))
                continue;
            $course = array();
            /*            $course['endDate'] = $eD;
                        $course['startDate'] = $sD;
                        $course['minOld'] = $miOld;
                        $course['maxOld'] = $maOld;*/
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    static function serachEfectLessGrouping($minOld, $maxOld, $startDate, $endDate, $day)
    {
        $model = new Course();
        $resuelt = $model->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $miOld = $row['min_old'];
            $maOld = $row['max_old'];
            $sD = $row['start_date'];
            $eD = $row['end_date'];
            $d = $row['day'];
            if (!($minOld <= $miOld && $miOld <= $maxOld))
                continue;
            if (!($minOld <= $maOld && $maOld <= $maxOld))
                continue;
            if (!($startDate <= $sD && $sD <= $endDate))
                continue;
            if (!($startDate <= $eD && $eD <= $endDate))
                continue;
            if (stripos($day, $d) != 0)
                continue;
            $course = array();
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    static function serachEfectLessDays($minOld, $maxOld, $startDate, $endDate, $group)
    {
        $model = new Course();
        $resuelt = $model->getCourseByGroupingId($group);
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $miOld = $row['min_old'];
            $maOld = $row['max_old'];
            $sD = $row['start_date'];
            $eD = $row['end_date'];
            if (!($minOld <= $miOld && $miOld <= $maxOld))
                continue;
            if (!($minOld <= $maOld && $maOld <= $maxOld))
                continue;
            if (!($startDate <= $sD && $sD <= $endDate))
                continue;
            if (!($startDate <= $eD && $eD <= $endDate))
                continue;
            $course = array();
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    static function serchWithAllElements($minOld, $maxOld, $startDate, $endDate, $group, $day)
    {
        $model = new Course();
        $resuelt = $model->getCourseByGroupingId($group);
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $miOld = $row['min_old'];
            $maOld = $row['max_old'];
            $sD = $row['start_date'];
            $eD = $row['end_date'];
            $d = $row['day'];
            if (!($minOld <= $miOld && $miOld <= $maxOld))
                continue;
            if (!($minOld <= $maOld && $maOld <= $maxOld))
                continue;
            if (!($startDate <= $sD && $sD <= $endDate))
                continue;
            if (!($startDate <= $eD && $eD <= $endDate))
                continue;
            if (stripos($day, $d) != 0)
                continue;
            $course = array();
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

}