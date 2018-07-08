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
require_once 'model/Subscribe.php';
require_once 'model/SendingEmail.php';
require_once 'present/PresentGrouping.php';


class PresentCourse
{

    public static function addCourse($ac, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, $start_date, $end_date, $day, $hours, $minOld, $maxOld)
    {
        $res = array();
        $teacher_id = (new User())->getPhoneByAc($ac);
        if (PresentSubscribe::haveASubscription($teacher_id) == 0) {
            $res['code'] = 404;
            $res['sub'] = base64_encode((base64_encode("BnAoD")));
        } else {

            (new Subscribe())->decrementRemainingCourse($teacher_id);
            $course = new Course();
            $result = $course->addCourse($teacher_id, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet, $tozihat, $start_date, $end_date, $day, $hours, $minOld, $maxOld);
            $res['code'] = $result;
            $res['sub'] = base64_encode((base64_encode("YoEkS")));
        }
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getBookMarkCourses($userApi)
    {
        $userId = (new User())->getPhoneByAc($userApi);
        $course = new Course();
        $resuelt = $course->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            if ((new BookMark())->checkBookMark($row['cource_id'], $userId) == 1) {
                $course = array();
                $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
                $course['startDate'] = $row['start_date'];
                $course['id'] = $row['cource_id'];
                $course['CourseName'] = $row['subject'];
                $course['vaziat'] = $row['vaziat'];
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

    public static function getAllCourse()
    {
        $course = new Course();
        $resuelt = $course->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            $course = array();
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['vaziat'] = $row['vaziat'];
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

    public static function getCourseByGroupingId($groupingId)
    {
        $course = new Course();
        $resuelt = $course->getCourseByGroupingId($groupingId);
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            $course = array();
            $course['startDate'] = $row['start_date'];
            $course['vaziat'] = $row['vaziat'];
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
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

    public static function updateDeletedFlag($courseId, $code)
    {
        $model = new Course();
        $resuelt = $model->updateDeletedFlag($courseId, $code);
        $res = array();
        $res['code'] = $resuelt;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getCourseById($id, $userApi)
    {
        $user = new User;
        $course = new Course();
        $result = $course->getCourseById($id);
        $res = array();
        while ($row = $result->fetch_assoc()) {
            $course = array();
            $course['id'] = $row['cource_id'];
            $course['idTeacher'] = $user->getAcByPhone($row['teacher_id']);
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
            $course['idTabaghe'] = $row['tabaghe_id'];
            $course['state'] = $row['state'];
            $course['bookMark'] = (new BookMark())->checkBookMark($id, $user->getPhoneByAc($userApi));;
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['tabaghe'] = (new Tabaghe())->getRootGroupingSubject($row['tabaghe_id']);
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
            $course['vaziat'] = $row['vaziat'];
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
            $course['CourseName'] = $row['subject'];
            $course['capacity'] = $row['capacity'];//
            $course['startDate'] = $row['start_date'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['numberOfWaitingStudent'] = self::getNumberOfWaitingStudent($phone, $row['cource_id']);
            $res[] = $course;
        }
        if ($res) {
            return json_encode(self::sortWithNumberOfWaitingStudent($res));
        } else {
            $course = array();
            $course['empty'] = 1;
            $res[] = $course;
            return json_encode($res);
        }
    }

    static function sortWithNumberOfWaitingStudent($res)
    {
        for ($i = 0; $i < count($res); $i++) {
            for ($j = $i; $j < count($res); $j++) {

                if ($res[$i]['numberOfWaitingStudent'] < $res[$j]['numberOfWaitingStudent']) {
                    $helpArray = $res[$i];
                    $res[$i] = $res[$j];
                    $res[$j] = $helpArray;
                }
            }
        }
        return $res;
    }

    public static function getNumberOfWaitingStudent($teacherId, $courseId)
    {
        return PresentSabtenam::getNumberOfWaitingStudent($teacherId, $courseId);
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
                if ($row['is_deleted'] == 2 || $sabtenam['is_canceled'] == 2 || $row['vaziat'] == 0)
                    continue;
                $course = array();
                $course['id'] = $row['cource_id'];
                $course['vaziat'] = $row['vaziat'];
                $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
                $course['isCanceled'] = $sabtenam['is_canceled'];
                $course['vaziat'] = $sabtenam['vaziat'];
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

    /////////////

    public static function getCourseForListHome($id)
    {
        if ($id == -1)
            return self::courseByrootIdForHomeList();
        return self::courseByGroupingIdForListHome($id);

    }

    static function courseByGroupingIdForListHome($rootId)
    {

        $model = new Tabaghe();
        $courseModel = new Course();
        $rezult = $model->getFinalBranchGroupByRootId($rootId);
        $res = array();
        while ($rowOfGroupList = $rezult->fetch_assoc()) {
            $counter = 0;
            $courses = array();
            $item = array();
            $courseResult = $courseModel->getCourseByGroupingId($rowOfGroupList['id']);
            while ($row = $courseResult->fetch_assoc()) {
                if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0 || $row['state'] == 4 || $row['state'] == 3 || $row['capacity'] <= 0 || $row['start_date'] < getJDate(null))
                    continue;
                $counter++;
                $course = array();
                if ($counter >= 10) {
                    $course['endOfList'] = 1;
                    $course['idTabaghe'] = $rowOfGroupList['id'];
                    $courses[] = $course;
                    break;
                }
                $course['idTabaghe'] = $row['tabaghe_id'];
                $course['vaziat'] = $row['vaziat'];
                $course['startDate'] = $row['start_date'];
                $course['endOfList'] = 0;
                $course['id'] = $row['cource_id'];
                $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                $course['CourseName'] = $row['subject'];
                $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
                $courses[] = $course;

            }

            if ($courses) {
                $item['courses'] = $courses;
                $item['groupSubject'] = $rowOfGroupList['subject'];
                $res[] = $item;
            } else {
                $item['empty'] = 1;
                $item['courses'] = null;
                $item['groupSubject'] = $rowOfGroupList['subject'];
                $res[] = $item;
            }

        }

        if ($res) {
            return json_encode(self::sortWithCourseNumber($res));
        } else {
            $item = array();
            $item['empty'] = 1;
            $item['courses'] = null;
            $item['groupSubject'] = $model->getGroupingSubjectByGroupId($rootId);
            $res[] = $item;
            return json_encode($res);
        }
    }

    static function courseByrootIdForHomeList()
    {
        $arr = self::creatGroupingArr(-1);
        $model = new Course();
        $res = array();
        for ($i = 0; $i < count($arr); $i++) {
            $counter = 0;
            $courses = array();
            $item = array();
            for ($j = 0; $j < count($arr[$i]['subCategory']); $j++) {
                $result = $model->getCourseByGroupingId($arr[$i]['subCategory'][$j]);

                while ($row = $result->fetch_assoc()) {
                    if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0 || $row['state'] == 4 || $row['state'] == 3 || $row['capacity'] <= 0 || $row['start_date'] < getJDate(null))
                        continue;
                    $counter++;
                    $course = array();
                    if ($counter >= 10)
                        break;

                    $course['idTabaghe'] = $row['tabaghe_id'];
                    $course['startDate'] = $row['start_date'];
                    $course['vaziat'] = $row['vaziat'];
                    $course['endOfList'] = 0;
                    $course['id'] = $row['cource_id'];
                    $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                    $course['CourseName'] = $row['subject'];
                    $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
                    $courses[] = $course;

                }
                if ($counter >= 10) {
                    $course['endOfList'] = 1;
                    $course['idTabaghe'] = $arr[$i]['id'];
                    $courses[] = $course;
                    break;
                }
            }
            if ($courses) {
                $item['courses'] = self::sortCourse($courses);
                $item['groupSubject'] = $arr[$i]['subject'];
                $res[] = $item;
            } else {
                $item['empty'] = 1;
                $item['courses'] = null;
                $item['groupSubject'] = $arr[$i]['subject'];
                $res[] = $item;
            }
        }


        if ($res) {
            return json_encode(self::sortWithCourseNumber($res));
        } else {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
            return json_encode($res);
        }
    }

    static function sortCourse($course)
    {

        for ($i = 0; $i < count($course); $i++) {
            for ($j = $i; $j < count($course); $j++) {

                if ($course[$i]['id'] < $course[$j]['id']) {
                    $helpArray = $course[$i];
                    $course[$i] = $course[$j];
                    $course[$j] = $helpArray;
                }
            }
        }
        return $course;
    }

    static function sortWithCourseNumber($res)
    {
        for ($i = 0; $i < count($res); $i++) {
            for ($j = $i; $j < count($res); $j++) {

                if (count($res[$i]['courses']) < count($res[$j]['courses'])) {
                    $helpArray = $res[$i];
                    $res[$i] = $res[$j];
                    $res[$j] = $helpArray;
                }
            }
        }
        return $res;
    }

    public static function getCustomeCourseListForHome()
    {
        $res = array();
        $item = array();
        $item['courses'] = self::getNewCourse();
        $item['groupSubject'] = 'دوره های جدید';
        $res[] = $item;
        $item['courses'] = self::getEndCourses();
        $item['groupSubject'] = 'دوره های خاتمه یافته';
        $res[] = $item;
        $item['courses'] = self::getFullCapacityCourses();
        $item['groupSubject'] = 'دوره های تکمیل ظرفیت شده';
        $res[] = $item;
        $item['courses'] = self::getStartedCourse();
        $item['groupSubject'] = 'دوره های شروع شده';
        $res[] = $item;
        if (!$res) {
            $message = array();
            $message ['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);

    }

    private static function getNewCourse()
    {
        $course = new Course();
        $resuelt = $course->getNewCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {

            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0 || $row['state'] == 4 || $row['state'] == 3 || $row['capacity'] <= 0 || $row['start_date'] < getJDate(null))
                continue;
            $course = array();
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
            $course['vaziat'] = $row['vaziat'];
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return $res;

    }

    private static function getEndCourses()
    {

        $course = new Course();
        $resuelt = $course->getEndCourses();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {

            if ($row['is_deleted'] !== 0 || $row['capacity'] <= 0 || $row['start_date'] < getJDate(null))
                continue;
            $course = array();
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
            $course['vaziat'] = $row['vaziat'];
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $res[] = $course;
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return $res;

    }

    private static function getFullCapacityCourses()
    {

        $course = new Course();
        $resuelt = $course->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {

            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            if ($row['state'] == 4 || $row['capacity'] <= 0) {
                $course = array();
                $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
                $course['vaziat'] = $row['vaziat'];
                $course['startDate'] = $row['start_date'];
                $course['id'] = $row['cource_id'];
                $course['CourseName'] = $row['subject'];
                $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                $res[] = $course;
            }
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return $res;

    }

    private static function getStartedCourse()
    {

        $course = new Course();
        $resuelt = $course->getAllCourse();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {

            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            if ($row['start_date'] < getJDate(null) || $row['state'] == 2) {
                $course = array();
                $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
                $course['vaziat'] = $row['vaziat'];
                $course['startDate'] = $row['start_date'];
                $course['id'] = $row['cource_id'];
                $course['CourseName'] = $row['subject'];
                $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
                $res[] = $course;
            }
        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }
        return $res;

    }

    ///////////////

    public static function upDateCourse($teacherApi, $courseId, $startDate, $endDate, $hours, $days, $state)
    {
        $teacherId = (new User())->getPhoneByAc($teacherApi);
        $result = (new Course())->upDateCourse($teacherId, $courseId, $startDate, $endDate, $hours, $days, $state);
        $res = array();
        $message = array();
        $message['code'] = $result;
        $res[] = $message;
        return json_encode($res);


    }

    static function creatGroupingArr($id)
    {
        $model = new Tabaghe();
        $rezult = $model->getTabagheByRootId($id);
        $res = array();
        while ($row = $rezult->fetch_assoc()) {
            $tabaghe = array();
            $tabaghe['id'] = $row['id'];
            $tabaghe['subject'] = $row['subject'];
            $finalRezult = $model->getFinalBranchGroupByRootId($row['id']);
            $final = array();
            while ($row = $finalRezult->fetch_assoc()) {
                $final[] = $row['id'];
            }
            $tabaghe['subCategory'] = $final;
            $res[] = $tabaghe;
        }
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
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            $course = array();
            /*            $course['endDate'] = $eD;
                        $course['startDate'] = $sD;
                        $course['minOld'] = $miOld;
                        $course['maxOld'] = $maOld;*/
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['vaziat'] = $row['vaziat'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
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
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            $course = array();
            $course['vaziat'] = $row['vaziat'];
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
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
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            $course = array();
            $course['vaziat'] = $row['vaziat'];
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
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
            if ($row['is_deleted'] !== 0 || $row['vaziat'] == 0)
                continue;
            $course = array();
            $course['vaziat'] = $row['vaziat'];
            $course['startDate'] = $row['start_date'];
            $course['id'] = $row['cource_id'];
            $course['CourseName'] = $row['subject'];
            $course['MasterName'] = (new Course())->getTeacherSubject($row['cource_id']);
            $course['idTeacher'] = (new User())->getAcByPhone($row['teacher_id']);
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

    public static function getNotifyData($lastId)
    {


        $result = (new Course())->getNotifyData($lastId);
        $res = array();
        while ($row = $result->fetch_assoc()) {

            $notifyData = array();
            $notifyData['name'] = $row['subject'];
            $notifyData['lastId'] = $row['cource_id'];
            $res [] = $notifyData;

        }

        if (!$res) {
            $message = array();
            $message['empty'] = 1;
            $res[] = $message;
        }

        return json_encode($res);
    }

}