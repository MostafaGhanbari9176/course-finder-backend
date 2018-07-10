<?php
/**
 * Created by PhpStorm.
 * User: MAHNAZ
 * Date: 10/28/2017
 * Time: 12:13 PM
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '.././libs/vendor/autoload.php';
require 'present/PresentOstan.php';
require 'present/PresentCity.php';
require 'present/PresentUser.php';
require 'present/PresentVerifyCode.php';
require 'present/PresenterTeacher.php';
require 'present/PresentGrouping.php';
require 'Present/PresentCourse.php';
require 'Present/PresentSabtenam.php';
require_once 'Present/PresentSubscribe.php';
require 'Present/PresentComment.php';
require 'jdf.php';
require 'present/PresentSmsBox.php';
require 'present/PresentReport.php';
require 'present/PresentAppData.php';
require 'present/PresentFeedBack.php';
require 'present/PresentFavorite.php';
require 'present/PresentBookMark.php';
require 'present/PresentGift.php';




$app = new \Slim\App;



$app->get('/logUp/{phone}/{name}/{code}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $name = $req->getAttribute('name');
    $code = $req->getAttribute('code');
    $result = PresentUser::logUp($phone, $name, $code);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->get('/logIn/{phone}/{code}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $code = $req->getAttribute('code');
    $result = PresentUser::logIn($phone, $code);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->get('/createAndSaveSmsCode/{phone}', function (Request $request, Response $response) {
    clearstatcache();
    $response->getBody()->write(PresentVerifyCode::SendVerifyCode($request->getAttribute('phone')));
});

$app->get('/logOut/{phone}', function (Request $request, Response $response) {
    clearstatcache();
    $response->getBody()->write(PresentUser::logOut($request->getAttribute('phone')));

});

$app->get('/addTeacher/{ac}/{landPhone}/{subject}/{tozihat}/{type}/{lat}/{lon}/{address}', function (Request $req, Response $res) {

    $ac = $req->getAttribute('ac');
    $landPhone = $req->getAttribute('landPhone');
    $lat = $req->getAttribute('lat');
    $subject = $req->getAttribute('subject');
    $tozihat = $req->getAttribute('tozihat');
    $type = $req->getAttribute('type');
    $long = $req->getAttribute('lon');
    $address = $req->getAttribute('address');
    clearstatcache();
    $result = PresenterTeacher::addTeacher($ac, $landPhone, $subject, $tozihat, $type, $lat, $long, $address);
    $res->getBody()->write($result);

});

$app->get('/getTeacher/{teacherApi}/{userApi}', function (Request $req, Response $res) {

    $result = PresenterTeacher::getTeacher($req->getAttribute('teacherApi'), $req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/getAllTeacher', function (Request $req, Response $res) {

    clearstatcache();
    $res->getBody()->write(PresenterTeacher::getAllTeacher());
});

$app->get('/getSelectedTeacher', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresenterTeacher::getSelectedTeacher());
});

$app->get('/getCustomTeacherListData', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresenterTeacher::getCustomTeacherListForHome());
});

$app->get('/getTabaghe/{uperId}', function (Request $req, Response $res) {


    $uperId = $req->getAttribute('uperId');
    clearstatcache();
    $res->getBody()->write(PresentGrouping::getTabagheByUperId($uperId));
});

$app->get('/addCourse/{ac}/{subject}/{tabaghe_id}/{type}/{capacity}/{mony}/{sharayet}/{tozihat}/{start_date}/{end_date}/{day}/{hours}/{minOld}/{maxOld}', function (Request $req, Response $res) {
    $ac = $req->getAttribute('ac');
    $subject = $req->getAttribute('subject');
    $tabaghe_id = $req->getAttribute('tabaghe_id');
    $type = $req->getAttribute('type');
    $capacity = $req->getAttribute('capacity');
    $mony = $req->getAttribute('mony');
    $sharayet = $req->getAttribute('sharayet');
    $minOld = $req->getAttribute('minOld');
    $maxOld = $req->getAttribute('maxOld');
    $tozihat = $req->getAttribute('tozihat');
    $start_date = $req->getAttribute('start_date');
    $end_date = $req->getAttribute('end_date');
    $day = $req->getAttribute('day');
    $hours = $req->getAttribute('hours');

    $resuelt = PresentCourse::addCourse($ac, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet,
        $tozihat, $start_date, $end_date, $day, $hours, $minOld, $maxOld);
    clearstatcache();
    $res->getBody()->write($resuelt);
});

$app->get('/getCourseByFilter/{minOld}/{maxOld}/{startDate}/{endDate}/{Grouping}/{days}', function (Request $req, Response $res) {

    $minOld = $req->getAttribute('minOld');
    $maxOld = $req->getAttribute('maxOld');
    $start_date = $req->getAttribute('startDate');
    $end_date = $req->getAttribute('endDate');
    $group = $req->getAttribute('Grouping');
    $day = $req->getAttribute('days');
    $resuelt = PresentCourse::searchCourse($minOld, $maxOld, $start_date, $end_date, $group, $day);
    clearstatcache();
    $res->getBody()->write($resuelt);
});

$app->get('/getAllCourse', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentCourse::getAllCourse());
});/////////////////***

$app->get('/getCourseById/{id}/{userApi}', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCourseById($req->getAttribute('id'), $req->getAttribute('userApi')));
});

$app->get('/getCourseByTeacherId/{ac}', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCourseByTeacherId($req->getAttribute('ac')));
});

$app->get('/getUserCourse/{ac}', function (Request $req, Response $res) {
    $id = $req->getAttribute('ac');
    clearstatcache();
    $res->getBody()->write(PresentCourse::getByUserId($id));
});

$app->get('/getCourseForListHome/{id}', function (Request $req, Response $res) {
    $id = $req->getAttribute('id');
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCourseForListHome($id));
});

$app->get('/getCourseByGroupingId/{id}', function (Request $req, Response $res) {
    $id = $req->getAttribute('id');
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCourseByGroupingId($id));
});

$app->get('/getCustomCourseListForHome', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCustomeCourseListForHome());
});

$app->get('/sabtenam/{idCourse}/{idTeacher}/{idUser}/{cellPhone}', function (Request $req, Response $res) {
    $idCourse = $req->getAttribute('idCourse');
    $idTeacher = $req->getAttribute('idTeacher');
    $idUser = $req->getAttribute('idUser');
    $cellPhone = $req->getAttribute('cellPhone');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::add($idCourse, $idTeacher, $idUser, $cellPhone));

});

$app->get('/checkSabtenam/{idCourse}/{idUser}', function (Request $req, Response $res) {
    $idCourse = $req->getAttribute('idCourse');
    $idUser = $req->getAttribute('idUser');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::checkValieded($idUser, $idCourse));

});

$app->get('/getRegistrationsName/{idCourse}/{idTeacher}', function (Request $req, Response $res) {

    $idCourse = $req->getAttribute('idCourse');
    $acTeacher = $req->getAttribute('idTeacher');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::getRegistrationsName($idCourse, $acTeacher));

});

$app->get('/saveComment/{commentText}/{userId}/{courseId}/{teacherId}/{teacherRat}', function (Request $req, Response $res) {
    $commentText = $req->getAttribute('commentText');
    $userId = $req->getAttribute('userId');
    $courseId = $req->getAttribute('courseId');
    $teacherId = $req->getAttribute('teacherId');
    $teacherRat = $req->getAttribute('teacherRat');
    clearstatcache();
    $res->getBody()->write(PresentComment::saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat));
});

$app->get('/saveCourseRat/{userId}/{courseId}/{teacherId}/{courseRat}', function (Request $req, Response $res) {
    $userId = $req->getAttribute('userId');
    $courseId = $req->getAttribute('courseId');
    $teacherId = $req->getAttribute('teacherId');
    $courseRat = $req->getAttribute('courseRat');
    clearstatcache();
    $res->getBody()->write(PresentComment::saveCourseRat($userId, $courseId, $teacherId, $courseRat));
});

$app->get('/getCommentByTeacherId/{teacherId}', function (Request $req, Response $res) {
    $teacherId = $req->getAttribute('teacherId');
    clearstatcache();
    $res->getBody()->write(PresentComment::getCommentByTeacherId($teacherId));
});

$app->get('/commentFeedBack/{userId}/{commentId}/{isLicked}', function (Request $req, Response $res) {
    $userId = $req->getAttribute('userId');
    $commentId = $req->getAttribute('commentId');
    $isLicked = $req->getAttribute('isLicked');
    clearstatcache();
    $res->getBody()->write(PresentComment::feedBackComment($userId, $commentId, $isLicked));
});

$app->get('/getMsAndRat/{ac}', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresenterTeacher::getMadrakStateAndRat($req->getAttribute('ac')));
});

$app->get('/upMs/{ac}', function (Request $req, Response $res) {
    $ac = $req->getAttribute('ac');
    clearstatcache();
    $res->getBody()->write(PresenterTeacher::updateMadrakState($ac));
});

$app->get('/saveSms/{text}/{tsId}/{rsId}/{courseId}/{howSending}', function (Request $req, Response $res) {

    $text = $req->getAttribute('text');
    $tsId = $req->getAttribute('tsId');
    $rsId = $req->getAttribute('rsId');
    $courseId = $req->getAttribute('courseId');
    $howSending = $req->getAttribute('howSending');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::saveSms($text, $tsId, $rsId, $courseId, $howSending));

});

$app->get('/sendMoreSms/{data}/{message}', function (Request $req, Response $res) {

    $data = $req->getAttribute('data');
    $message = $req->getAttribute('message');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::sendMoreSms($data, $message));

});

$app->get('/getRsSms/{rsId}', function (Request $req, Response $res) {

    $rsId = $req->getAttribute('rsId');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::getRsSms($rsId));

});

$app->get('/getTsSms/{tsId}', function (Request $req, Response $res) {

    $tsId = $req->getAttribute('tsId');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::getTsSms($tsId));

});

$app->get('/upDateSeen/{id}', function (Request $req, Response $res) {

    $id = $req->getAttribute('id');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::upDateSeen($id));

});

$app->get('/deleteSms/{id}', function (Request $req, Response $res) {

    $id = $req->getAttribute('id');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::deleteSms($id));

});

$app->get('/updateCanceledFlag/{sabtenamId}/{code}/{courseId}/{message}/{tsId}/{rsId}', function (Request $req, Response $res) {

    $id = $req->getAttribute('sabtenamId');
    $code = $req->getAttribute('code');
    $courseId = $req->getAttribute('courseId');
    $message = $req->getAttribute('message');
    $tsId = $req->getAttribute('tsId');
    $rsId = $req->getAttribute('rsId');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::updateCanceledFlag($id, $code, $courseId, $message, $tsId, $rsId));

});

$app->get('/updateMoreCanceledFlag/{data}/{message}', function (Request $req, Response $res) {

    $data = $req->getAttribute('data');
    $message = $req->getAttribute('message');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::updateMoreCanceledFlag($data, $message));

});

$app->get('/checkedUserStatuse/{id}', function (Request $req, Response $res) {
    $UserId = $req->getAttribute('id');
    clearstatcache();
    $res->getBody()->write(PresentUser::checkUserStatuse($UserId));
});

$app->get('/confirmStudent/{sabtenamId}/{courseId}/{message}/{tsId}/{rsId}', function (Request $req, Response $res) {
    $sabtenamId = $req->getAttribute('sabtenamId');
    $courseId = $req->getAttribute('courseId');
    $message = $req->getAttribute('message');
    $tsId = $req->getAttribute('tsId');
    $rsId = $req->getAttribute('rsId');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::confirmStudent($sabtenamId, $courseId, $message, $tsId, $rsId));
});

$app->get('/confirmMoreStudent/{data}/{message}', function (Request $req, Response $res) {
    $data = $req->getAttribute('data');
    $message = $req->getAttribute('message');
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::confirmMoreStudent($data, $message));
});

$app->get('/RePoRt/{signText}/{reportText}/{spamId}/{spamerId}/{reporterId}', function (Request $req, Response $res) {
    $signText = $req->getAttribute('signText');
    $reportText = $req->getAttribute('reportText');
    $spamId = $req->getAttribute('spamId');
    $spamerId = $req->getAttribute('spamerId');
    $reporterId = $req->getAttribute('reporterId');
    clearstatcache();
    $res->getBody()->write(PresentReport::saveAReport($signText, $reportText, $spamId, $spamerId, $reporterId));
});

$app->get('/getMahoorAppData', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentAppData::getAppData());
});

$app->get('/getSubscribeList', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentSubscribe::getSubscribeList());
});

$app->get('/getUserBuySubscribe/{ac}', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentSubscribe::getUserSubscribe($req->getAttribute('ac')));
});

$app->post('/saveUserBuy', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $ac = $postParam['ac'];
    $refId = $postParam['refId'];
    $subscribeId = $postParam['subId'];
    clearstatcache();
    $res->getBody()->write(PresentSubscribe::saveUserBuy($ac, $refId, $subscribeId));

});

$app->get('/saveFeedBack/{ac}/{feedBackText}', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentFeedBack::saveFeedBack($req->getAttribute('feedBackText'), $req->getAttribute('ac')));
});

$app->get('/checkUpdate', function (Request $req, Response $res) {
    $message = array();
    $message['versionName'] = PresentUser::$versionName;
    $message['code'] = "0";
    $response = array();
    $response[] = $message;
    clearstatcache();
    $res->getBody()->write(json_encode($response));

});

$app->get('/SaveFavorite/{teacherApi}/{userApi}', function (Request $req, Response $res) {
    $result = PresentFavorite::saveFavorite($req->getAttribute('teacherApi'), $req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/RemoveFavorite/{teacherApi}/{userApi}', function (Request $req, Response $res) {
    $result = PresentFavorite::removeFavorite($req->getAttribute('teacherApi'), $req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/SaveBookMark/{courseId}/{userApi}', function (Request $req, Response $res) {
    $result = PresentBookMark::saveBookMark($req->getAttribute('courseId'), $req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/RemoveBookMark/{courseId}/{userApi}', function (Request $req, Response $res) {
    $result = PresentBookMark::removeBookMark($req->getAttribute('courseId'), $req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/getFavoriteTeachers/{userApi}', function (Request $req, Response $res) {
    $result = PresenterTeacher::getFavoriteTeachers($req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/getBookMarkCourses/{userApi}', function (Request $req, Response $res) {
    $result = PresentCourse::getBookMarkCourses($req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/checkGiftCode/{giftCode}/{userApi}', function (Request $req, Response $res) {
    $result = PresentGift::checkGift($req->getAttribute('giftCode'), $req->getAttribute('userApi'));
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/getGiftCodes', function (Request $req, Response $res) {
    $result = PresentGift::getGiftCodes();
    clearstatcache();
    $res->getBody()->write($result);
});

$app->get('/sendEmail/{code}', function (Request $req, Response $res) {
    SendingEmail::sendRequestForMaster('بازخورد از کاربر : ', $req->getAttribute('code'));
});

$app->get('/upDateCourse/{teacherApi}/{courseId}/{startDate}/{endDate}/{hours}/{days}/{state}', function (Request $req, Response $res) {

    $result = PresentCourse::upDateCourse($req->getAttribute('teacherApi'), $req->getAttribute('courseId'), $req->getAttribute('startDate'), $req->getAttribute('endDate')
        , $req->getAttribute('hours'), $req->getAttribute('days'), $req->getAttribute('state'));
    clearstatcache();
    $res->getBody()->write($result);


});

$app->get('/getSabtenamNotifyData/{apiCode}/{lastId}', function (Request $req, Response $res) {
    $result = PresentSabtenam::getNotifyData($req->getAttribute('apiCode'), $req->getAttribute('lastId'));
    $res->getBody()->write($result);
});

$app->get('/getMessageNotifyData/{apiCode}/{lastId}', function (Request $req, Response $res) {
    $result = PresentSmsBox::getNotifyData($req->getAttribute('apiCode'), $req->getAttribute('lastId'));
    $res->getBody()->write($result);
});

$app->get('/getNewCourseNotifyData/{lastId}', function (Request $req, Response $res) {

    $result = PresentCourse::getNotifyData($req->getAttribute('lastId'));
    $res->getBody()->write($result);

});

$app->get('/getNewTeacherNotifyData', function (Request $req, Response $res) {

    $result = PresenterTeacher::getNotifyData();
    $res->getBody()->write($result);

});

$app->get('/test', function (Request $req, Response $res) {


    $res->getBody()->write("1397-04-16" > getJDate(null));

});


$app->run();



