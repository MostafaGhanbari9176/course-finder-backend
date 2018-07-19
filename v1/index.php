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
require 'present/PresentNotify.php';


header("Pragma: no-cache");

$app = new \Slim\App;


$app->post('/logUp', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $phone = $postParam['email'];
    $name = $postParam['name'];
    $code = $postParam['code'];
    $result = PresentUser::logUp($phone, $name, $code);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->post('/logIn', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $phone = $postParam['email'];
    $code = $postParam['code'];
    $result = PresentUser::logIn($phone, $code);
    clearstatcache();
    $res->getBody()->write($result);

});


$app->post('/SiteLogUp', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $email = $postParam['email'];
    $name = $postParam['name'];
    $verifyCode = $postParam['verifyCode'];
    $pass = $postParam['pass'];
    $result = PresentUser::logUPWithPass($email, $name, $verifyCode, $pass);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->post('/SiteLogIn', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $email = $postParam['email'];
    $pass = $postParam['pass'];
    $result = PresentUser::logInWithPass($email, $pass);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->post('/chosePass', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $email = $postParam['email'];
    $verifyCode = $postParam['verifyCode'];
    $pass = $postParam['pass'];
    $result = PresentUser::logUPWithPass($email, $verifyCode, $pass);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->post('/createAndSaveSmsCode', function (Request $request, Response $response) {
    $postParam = $request->getParsedBody();
    $phone = $postParam['email'];
    $result = PresentVerifyCode::createAndSaveSmsCode($phone);
    clearstatcache();
    $response->getBody()->write($result);
});

$app->post('/logOut', function (Request $request, Response $response) {

    $postParam = $request->getParsedBody();
    $email = $postParam['email'];
    clearstatcache();
    $response->getBody()->write(PresentUser::logOut($request->getAttribute($email)));

});

$app->post('/addTeacher', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $ac = $postParam['ac'];
    $landPhone = $postParam['landPhone'];
    $lat = $postParam['lat'];
    $subject = $postParam['subject'];
    $tozihat = $postParam['tozihat'];
    $type = $postParam['type'];
    $long = $postParam['lon'];
    $address = $postParam['address'];
    clearstatcache();
    $result = PresenterTeacher::addTeacher($ac, $landPhone, $subject, $tozihat, $type, $lat, $long, $address);
    $res->getBody()->write($result);

});

$app->post('/getTeacher', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $result = PresenterTeacher::getTeacher($postParam['teacherApi'], $postParam['userApi']);
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

$app->post('/addCourse', function (Request $req, Response $res) {
    $posParam = $req->getParsedBody();
    $ac = $posParam['ac'];
    $teacherName = $posParam['teacherName'];
    $subject = $posParam['subject'];
    $tabaghe_id = $posParam['tabagheId'];
    $type = $posParam['type'];
    $capacity = $posParam['capacity'];
    $mony = $posParam['mony'];
    $sharayet = $posParam['sharayet'];
    $minOld = $posParam['minOld'];
    $maxOld = $posParam['maxOld'];
    $tozihat = $posParam['tozihat'];
    $start_date = $posParam['startDate'];
    $end_date = $posParam['endDate'];
    $day = $posParam['day'];
    $hours = $posParam['hours'];

    $resuelt = PresentCourse::addCourse($ac, $teacherName, $subject, $tabaghe_id, $type, $capacity, $mony, $sharayet,
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

$app->post('/getCourseById', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCourseById($postParam['id'], $postParam['userApi']));
});

$app->get('/getCourseByTeacherId/{phone}', function (Request $req, Response $res) {
    clearstatcache();
    $res->getBody()->write(PresentCourse::getCourseByTeacherId($req->getAttribute('phone')));
});

$app->post('/getUserCourse', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $id = $postParam['ac'];
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

$app->post('/sabtenam', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $idCourse = $postParam['idCourse'];
    $idTeacher = $postParam['idTeacher'];
    $idUser = $postParam['idUser'];
    $cellPhone = $postParam['cellPhone'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::add($idCourse, $idTeacher, $idUser, $cellPhone));

});

$app->post('/checkSabtenam', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $idCourse = $postParam['idCourse'];
    $idUser = $postParam['idUser'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::checkValieded($idUser, $idCourse));

});

$app->post('/getRegistrationsName', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $idCourse = $postParam['idCourse'];
    $acTeacher = $postParam['idTeacher'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::getRegistrationsName($idCourse, $acTeacher));

});

$app->post('/saveComment', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $commentText = $postParam['commentText'];
    $userId = $postParam['userId'];
    $courseId = $postParam['courseId'];
    $teacherId = $postParam['teacherId'];
    $teacherRat = $postParam['teacherRat'];
    clearstatcache();
    $res->getBody()->write(PresentComment::saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat));
});

$app->post('/saveCourseRat', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $userId = $postParam['userId'];
    $courseId = $postParam['courseId'];
    $teacherId = $postParam['teacherId'];
    $courseRat = $postParam['courseRat'];
    clearstatcache();
    $res->getBody()->write(PresentComment::saveCourseRat($userId, $courseId, $teacherId, $courseRat));
});

$app->get('/getCommentByTeacherId/{teacherId}', function (Request $req, Response $res) {
    $teacherId = $req->getAttribute('teacherId');
    clearstatcache();
    $res->getBody()->write(PresentComment::getCommentByTeacherId($teacherId));
});

$app->post('/commentFeedBack', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $userId = $postParam['userId'];
    $commentId = $postParam['commentId'];
    $isLicked = $postParam['isLicked'];
    clearstatcache();
    $res->getBody()->write(PresentComment::feedBackComment($userId, $commentId, $isLicked));
});

$app->post('/getMsAndRat', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresenterTeacher::getMadrakStateAndRat($postParam['ac']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/upMs', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $ac = $postParam['ac'];
    clearstatcache();
    $res->getBody()->write(PresenterTeacher::updateMadrakState($ac));
});

$app->post('/saveSms', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $text = $postParam['text'];
    $tsId = $postParam['tsId'];
    $rsId = $postParam['rsId'];
    $courseId = $postParam['courseId'];
    $howSending = $postParam['howSending'];
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::saveSms($text, $tsId, $rsId, $courseId, $howSending));

});

$app->post('/sendMoreSms', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $data = $postParam['data'];
    $message = $postParam['message'];
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::sendMoreSms($data, $message));

});

$app->post('/getRsSms', function (Request $req, Response $res) {

    $rsId = $req->getParsedBody()['rsId'];
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::getRsSms($rsId));

});

$app->post('/getTsSms', function (Request $req, Response $res) {

    $tsId = $req->getParsedBody()['tsId'];
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::getTsSms($tsId));

});

$app->get('/upDateSeen/{id}', function (Request $req, Response $res) {

    $id = $req->getAttribute('id');
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::upDateSeen($id));

});

$app->post('/deleteSms', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $id = $postParam['id'];
    $api = $postParam['ac'];
    clearstatcache();
    $res->getBody()->write(PresentSmsBox::deleteSms($id, $api));

});

$app->post('/updateCanceledFlag', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $id = $postParam['sabtenamId'];
    $code = $postParam['code'];
    $courseId = $postParam['courseId'];
    $message = $postParam['message'];
    $tsId = $postParam['tsId'];
    $rsId = $postParam['rsId'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::updateCanceledFlag($id, $code, $courseId, $message, $tsId, $rsId));

});

$app->post('/updateMoreCanceledFlag', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $data = $postParam['data'];
    $message = $postParam['message'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::updateMoreCanceledFlag($data, $message));

});

$app->post('/checkedUserStatuse', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $UserId = $postParam['id'];
    clearstatcache();
    $res->getBody()->write(PresentUser::checkUserStatuse($UserId));
});

$app->post('/confirmStudent', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $sabtenamId = $postParam['sabtenamId'];
    $courseId = $postParam['courseId'];
    $message = $postParam['message'];
    $tsId = $postParam['tsId'];
    $rsId = $postParam['rsId'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::confirmStudent($sabtenamId, $courseId, $message, $tsId, $rsId));
});

$app->post('/confirmMoreStudent', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $data = $postParam['data'];
    $message = $postParam['message'];
    clearstatcache();
    $res->getBody()->write(PresentSabtenam::confirmMoreStudent($data, $message));
});

$app->post('/RePoRt', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $signText = $postParam['signText'];
    $reportText = $postParam['reportText'];
    $spamId = $postParam['spamId'];
    $spamerId = $postParam['spamerId'];
    $reporterId = $postParam['reporterId'];
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

$app->post('/getUserBuySubscribe', function (Request $req, Response $res) {
    $result = PresentSubscribe::getUserSubscribe($req->getParsedBody()['ac']);
    clearstatcache();
    $res->getBody()->write($result);
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

$app->post('/SaveFavorite', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentFavorite::saveFavorite($postParam['teacherApi'], $postParam['userApi']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/RemoveFavorite', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentFavorite::removeFavorite($postParam['teacherApi'], $postParam['userApi']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/SaveBookMark', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentBookMark::saveBookMark($postParam['courseId'], $postParam['userApi']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/RemoveBookMark', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentBookMark::removeBookMark($postParam['courseId'], $postParam['userApi']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/getFavoriteTeachers', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresenterTeacher::getFavoriteTeachers($postParam['userApi']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/getBookMarkCourses', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentCourse::getBookMarkCourses($postParam['userApi']);
    clearstatcache();
    $res->getBody()->write($result);
});

$app->post('/checkGiftCode', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();
    $result = PresentGift::checkGift($postParam['giftCode'], $postParam['userApi']);
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

$app->post('/upDateCourse', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentCourse::upDateCourse($postParam['teacherApi'], $postParam['courseId'], $postParam['startDate'], $postParam['endDate']
        , $postParam['hours'], $postParam['days'], $postParam['state']);
    clearstatcache();
    $res->getBody()->write($result);


});

$app->post('/getSabtenamNotifyData', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentSabtenam::getNotifyData($postParam['apiCode'], $postParam['lastId']);
    $res->getBody()->write($result);
});

$app->post('/getMessageNotifyData', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentSmsBox::getNotifyData($postParam['apiCode'], $postParam['lastId']);
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

$app->post('/notifySetting', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentNotify::saveOrUpDateNotifyData($postParam['apiCode'], $postParam['courseId'], $postParam['startNotify'], $postParam['weakNotify']);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->post('/getWeakNotifyData', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentNotify::getWeakNotify($postParam['apiCode']);
    $res->getBody()->write($result);

});

$app->post('/getStartNotifyData', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentNotify::getStartNotify($postParam['apiCode'], $postParam['tomDate']);
    $res->getBody()->write($result);

});

$app->post('/getSettingNotifyData', function (Request $req, Response $res) {
    $postParam = $req->getParsedBody();
    $result = PresentNotify::getSettingNotify($postParam['apiCode'], $postParam['courseId']);
    clearstatcache();
    $res->getBody()->write($result);

});

$app->get('/test', function (Request $req, Response $res) {


    $res->getBody()->write("wizard 1997" xor "wizard 1997");

});


$app->run();



