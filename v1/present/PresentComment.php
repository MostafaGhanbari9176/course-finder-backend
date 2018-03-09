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
require_once 'model/LikeSaver.php';

class PresentComment
{

    public static function saveComment($commentText, $acUser, $courseId, $acTeacher, $teacherRat)
    {
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        if (!(self::checkAvailable($userId, $courseId))) {
            $model = new Comment();
            $result = $model->saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat, getJDate(null));
        } else {
            $model = new Comment();
            $result = $model->upDateComment(self::checkAvailable($userId, $courseId), $commentText, $userId, $courseId, $teacherId, $teacherRat, getJDate(null));
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }////////////checked

    public static function saveCourseRat($acUser, $courseId, $acTeacher, $courseRat)
    {
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
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


    public static function feedBackComment($acUser, $commentId, $isLicked)
    {

        $userId = (new User())->getPhoneByAc($acUser);
        $model = new LikeSaver();
        if ($model->checkValidation($userId, $commentId, $isLicked))
            $result = 0;
        else {
            if ($model->checkForInverting($userId, $commentId)) {
                $result = $model->upDateLike($userId, $commentId, $isLicked);
                if ($result == 1 && $isLicked == 1) {
                    self::changeLike(1, $commentId);
                    self::changeDisLike(-1, $commentId);
                } else if ($result == 1 && $isLicked == 0) {
                    self::changeDisLike(1, $commentId);
                    self::changeLike(-1, $commentId);
                }
            } else {

                $result = $model->saveLike($userId, $commentId, $isLicked);
                if ($result == 1 && $isLicked == 1)
                    self::changeLike(1, $commentId);
                else if ($result == 1 && $isLicked == 0)
                    self::changeDisLike(1, $commentId);
            }
            $result = 1;
        }
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);

    }

    public
    static function changeLike($addNumber, $commentId)
    {
        $model = new Comment();
        $likeNum = $model->getCommentById($commentId)->fetch_assoc()['like_num'];
        $likeNum = $likeNum + $addNumber;
        $model->changeLike($likeNum, $commentId);

    }

    public
    static function changeDisLike($addNumber, $commentId)
    {
        $model = new Comment();
        $disLikeNum = $model->getCommentById($commentId)->fetch_assoc()['dislike_num'];
        $disLikeNum = $disLikeNum + $addNumber;
        $model->changeDisLike($disLikeNum, $commentId);
    }

    public
    static function getCommentByTeacherId($acTeacher)
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
            $comment['courseName'] = (new Course())->getCourseName($row['course_id']);
            $comment['userName'] = (new User())->getUserName($row['user_id']);
            $comment['startDate'] = (new Course())->getCourseById($row['course_id'])->fetch_assoc()['start_date'];//
            $comment['teacherRat'] = $row['teacher_rat'];//
            $comment['commentText'] = $row['comment_text'];//
            $comment['date'] = $row['cm_date'];//
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

    public
    static function calculateCourseRat($courseId)
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

    public
    static function calculateTeacherRat($acTeacher)
    {

        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $comment = new Comment();
        $resuelt = $comment->getTeacherRat($teacherId);
        $count = 0;
        $rat = 0;
        while ($row = $resuelt->fetch_assoc()) {
            $count += 1;
            if ($row['vaziat'] == 0)
                continue;
            $rat += $row['teacher_rat'];
        }
//        echo "count  =  " . $count;
//        echo " , rat = " . $rat;
        if ($count == 0 || $rat == 0)
            return 0;
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

    public
    static function upDateComment($id, $commentText, $acUser, $courseId, $acTeacher, $teacherRat)
    {////////////checked
        $userId = (new User())->getPhoneByAc($acUser);
        $teacherId = (new User())->getPhoneByAc($acTeacher);
        $model = new Comment();
        $result = $model->upDateComment($id, $commentText, $userId, $courseId, $teacherId, $teacherRat, getJDate(null));
        $res = array();
        $res['code'] = $result;
        $message = array();
        $message[] = $res;
        return json_encode($message);
    }

    public
    static function getSelectedCamment()
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

    public
    static function getCommentByCourseId($userId)
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


    public
    static function getawesomeComment()
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