<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 22-Feb-18
 * Time: 7:30 PM
 */
require_once 'model/Comment.php';
require_once 'model/User.php';

class PresentComment
{

    public static function saveComment($commentText, $acUser, $courseId, $acTeacher, $teacherRat, $courseRat)
    {
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        if (!(self::checkAvailable($userId, $courseId))) {
            $model = new Comment();
            $result = $model->saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat, $courseRat, self::getDate());
        } else {
            $model = new Comment();
            $result = $model->upDateComment(self::checkAvailable($userId, $courseId), $commentText, $userId, $courseId, $teacherId, $teacherRat, $courseRat);
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }////////////checked

    public static function getCommentByTeacherId($acTeacher)
    {
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $comment = new Comment();
        $resuelt = $comment->getCommentByTeacherId($teacherId);
        $res = array();
        while ($row = $resuelt->fetch_assoc()) {
            $comment = array();
            if (strcmp("not", $row['comment_text']) == 0)
                continue;
            $comment['id'] = $row['id'];
            $comment['userId'] = (new User())->getAcByPhone($row['user_id']);
            $comment['courseId'] = $row['course_id'];
            $comment['teacherId'] = (new User())->getAcByPhone($row['teacher_id']);//
            $comment['courseRat'] = $row['course_rat'];//
            $comment['teacherRat'] = $row['teacher_rat'];//
            $comment['commentText'] = $row['comment_text'];//
            $comment['date'] = $row['date'];//
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

    public static function upDateComment($id, $commentText, $acUser, $courseId, $acTeacher, $teacherRat, $courseRat)
    {////////////checked
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $model = new Comment();
        $result = $model->upDateComment($id, $commentText, $userId, $courseId, $teacherId, $teacherRat, $courseRat);
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