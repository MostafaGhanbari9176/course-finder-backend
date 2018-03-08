<?php
/**
 * Created by PhpStorm.
 * User: RCC1
 * Date: 22-Feb-18
 * Time: 7:30 PM
 */
require_once 'model/Comment.php';
require_once 'model/User.php';
require_once 'model/Course.php';

 class PresentComment
{

    public static function saveComment($commentText, $acUser, $courseId, $acTeacher, $teacherRat)
    {
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        if (!(self::checkAvailable($userId, $courseId))) {
            $model = new Comment();
            $result = $model->saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat, self::getDate());
        } else {
            $model = new Comment();
            $result = $model->upDateComment(self::checkAvailable($userId, $courseId), $commentText, $userId, $courseId, $teacherId, $teacherRat, self::getDate());
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }////////////checked

    public static function saveCourseRat($acUser, $courseId, $teacherId, $courseRat)
    {
        $userId = (new User())->getPhoneByAc($acUser);

        if (!(self::checkAvailable($userId, $courseId))) {
            $model = new Comment();
            $result = $model->saveCourseRat($userId, $courseId, $teacherId, $courseRat);
        } else {
            $model = new Comment();
            $result = $model->upDateCourseRat(self::checkAvailable($userId, $courseId), $courseRat);
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getCommentByTeacherId($acTeacher)
    {
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $comment = new Comment();
        $resuelt = $comment->getCommentByTeacherId($teacherId);
        $res = array();
        $totalRat = self::calculateTeacherRat($acTeacher);
        while ($row = $resuelt->fetch_assoc()) {
            $comment = array();
            if ($row['vaziat'] == 0)
                continue;
            $comment['id'] = $row['id'];
            $comment['userId'] = (new User())->getAcByPhone($row['user_id']);
            $comment['courseId'] = $row['course_id'];
            $comment['courseName'] = (new Course())->getCourseName($row['course_id']);
            $comment['userName'] = (new User())->getUserName($row['user_id']);
            $comment['teacherId'] = (new User())->getAcByPhone($row['teacher_id']);//
            $comment['startDate'] = (new Course())->getCourseById($row['course_id'])['start_date'];//
            $comment['courseRat'] = $row['course_rat'];//
            $comment['teacherRat'] = $row['teacher_rat'];//
            $comment['commentText'] = $row['comment_text'];//
            $comment['date'] = $row['date'];//
            $comment['totalRat'] = $totalRat;//
            $res[] = $comment;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $comment = array();
            $comment['empty'] = 1;
            $res[] = $comment;
            return json_encode($res);
        }
    }////////////checked

    public static function calculateCourseRat($courseId)
    {
        $comment = new Comment();
        $resuelt = $comment->getCourseRat($courseId);
        $count = sizeof($resuelt);
        $rat = 0;
        while ($row = $resuelt->fetch_assoc()) {
            $rat += $row['course_rat'];
        }
        return $rat / $count;
    }

    public static function calculateTeacherRat($acTeacher)
    {
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $comment = new Comment();
        $resuelt = $comment->getTeacherRat($teacherId);
        $count = sizeof($resuelt);
        $rat = 0;
        while ($row = $resuelt->fetch_assoc()) {

            if ($row['vaziat'] == 0)
                continue;
            $rat += $row['teacher_rat'];
        }
        return $rat / $count;
    }

    /*   public static function getRatByCourseIdAndUserId($userId)
       {
           $comment = new Comment();
           $resuelt = $comment->getCommentByCourseId($userId);
           $res = array();
           while ($row = $resuelt->fetch_assoc()) {
               $comment = array();
               $comment['id'] = $row['course_id'];
               $comment['userId'] = $row['teacher_id'];
               $comment['courseId'] = $row['subject'];
               $comment['teacherId'] = $row['type'];//
               $comment['rat'] = $row['capacity'];//
               $comment['comment'] = $row['mony'];//
               $comment['date'] = $row['mony'];//
               $res[] = $comment;
           }
           if ($res) {
               return json_encode($res);
           } else {
               $comment = array();
               $comment['empoty'] = 1;
               $res[] = $comment;
               return json_encode($res);
           }
       }////////////checked*/

    public static function upDateComment($id, $commentText, $acUser, $courseId, $acTeacher, $teacherRat)
    {////////////checked
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $model = new Comment();
        $result = $model->upDateComment($id, $commentText, $userId, $courseId, $teacherId, $teacherRat, self::getDate());
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public static function getSelectedCamment()
    {
        $comment = new Comment();
        $resuelt = $comment->getSelectedComment();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $comment = array();
            $comment['id'] = $row['cource_id'];
            $comment['userId'] = $row['teacher_id'];
            $comment['courseId'] = $row['subject'];
            $comment['teacherId'] = $row['type'];//
            $comment['rat'] = $row['capacity'];//
            $comment['comment'] = $row['mony'];//
            $comment['date'] = $row['mony'];//
            $res[] = $comment;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $comment = array();
            $comment['empoty'] = 1;
            $res[] = $comment;
            return json_encode($res);
        }
    }

    public static function getCommentByCourseId($userId)
    {
        $comment = new Comment();
        $resuelt = $comment->getCommentByCourseId($userId);
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $comment = array();
            $comment['id'] = $row['cource_id'];
            $comment['userId'] = $row['teacher_id'];
            $comment['courseId'] = $row['subject'];
            $comment['teacherId'] = $row['type'];//
            $comment['rat'] = $row['capacity'];//
            $comment['comment'] = $row['mony'];//
            $comment['date'] = $row['mony'];//
            $res[] = $comment;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $comment = array();
            $comment['empoty'] = 1;
            $res[] = $comment;
            return json_encode($res);
        }
    }


    public static function getawesomeComment()
    {
        $comment = new Comment();
        $resuelt = $comment->getawesomeComment();
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $comment = array();
            $comment['id'] = $row['cource_id'];
            $comment['userId'] = $row['teacher_id'];
            $comment['courseId'] = $row['subject'];
            $comment['teacherId'] = $row['type'];//
            $comment['rat'] = $row['capacity'];//
            $comment['comment'] = $row['mony'];//
            $comment['date'] = $row['mony'];//
            $res[] = $comment;
        }
        if ($res) {
            return json_encode($res);
        } else {
            $comment = array();
            $comment['empoty'] = 1;
            $res[] = $comment;
            return json_encode($res);
        }
    }

    static function checkAvailable($userId, $courseId)
    {
        $comment = new Comment();
        $resuelt = $comment->checkAvailable($userId, $courseId);
        $res = $resuelt->fetch_assoc()['id'];
        if ($res)
            return $res;
        else
            return false;
    }////////////checked

    static function getDate()////////////checked
    {
        return date("Y/m/d");
    }
}