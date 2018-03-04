<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 22-Feb-18
 * Time: 7:30 PM
 */
require_once 'model/Comment.php';

class PresentComment
{

    public static function saveComment($userId, $teacherId, $courseId, $rat, $comment)
    {
        if (!(self::checkAvailable($userId, $courseId))) {
            $model = new Comment();
            $result = $model->saveComment($userId, $teacherId, $courseId, $rat, $comment, self::getDate());
        } else {
            $model = new Comment();
            $result = $model->upDateComment(self::checkAvailable($userId, $courseId), $userId, $teacherId, $courseId, $rat, $comment, self::getDate());
        }
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
    }

    static function getDate()
    {
        return date("Y/m/d");
    }
}