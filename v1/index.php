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
require 'present/PresentSmsCode.php';
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
require 'model/SendingEmail.php';


$app = new \Slim\App;

$app->get('/logUp/{phone}/{name}/{code}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $name = $req->getAttribute('name');
    $code = $req->getAttribute('code');
    $result = PresentUser::logUp($phone, $name, $code);
    $res->getBody()->write($result);

});

$app->get('/logIn/{phone}/{code}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $code = $req->getAttribute('code');
    $result = PresentUser::logIn($phone, $code);
    $res->getBody()->write($result);

});

$app->get('/createAndSaveSmsCode/{phone}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentSmsCode::creatAndSaveSmsCode($request->getAttribute('phone')));
});

$app->get('/logOut/{phone}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentUser::logOut($request->getAttribute('phone')));

});

$app->get('/addTeacher/{ac}/{landPhone}/{subject}/{tozihat}/{type}/{lat}/{lon}', function (Request $req, Response $res) {

    $ac = $req->getAttribute('ac');
    $landPhone = $req->getAttribute('landPhone');
    $lat = $req->getAttribute('lat');
    $subject = $req->getAttribute('subject');
    $tozihat = $req->getAttribute('tozihat');
    $type = $req->getAttribute('type');
    $long = $req->getAttribute('lon');
    $result = PresenterTeacher::addTeacher($ac, $landPhone, $subject, $tozihat, $type, $lat, $long);
    $res->getBody()->write($result);

});

$app->get('/getTeacher/{ac}', function (Request $req, Response $res) {

    $res->getBody()->write(PresenterTeacher::getTeacher($req->getAttribute('ac')));
});

$app->get('/getAllTeacher', function (Request $req, Response $res) {

    $res->getBody()->write(PresenterTeacher::getAllTeacher());
});

$app->get('/getSelectedTeacher', function (Request $req, Response $res) {

    $res->getBody()->write(PresenterTeacher::getSelectedTeacher());
});

$app->get('/getCustomTeacherListData', function (Request $req, Response $res) {
    $res->getBody()->write(PresenterTeacher::getCustomTeacherListForHome());
});

$app->get('/getTabaghe/{uperId}', function (Request $req, Response $res) {

    $uperId = $req->getAttribute('uperId');
    $res->getBody()->write(PresentGrouping::getTabagheByUperId($uperId));
});

/////////////////////////////courseMethods

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
    $res->getBody()->write($resuelt);
});

$app->get('/getAllCourse', function (Request $req, Response $res) {
    $res->getBody()->write(PresentCourse::getAllCourse());
});/////////////////***

$app->get('/getCourseById/{id}', function (Request $req, Response $res) {
    $res->getBody()->write(PresentCourse::getCourseById($req->getAttribute('id')));
});//////////////////**

$app->get('/getCourseByTeacherId/{ac}', function (Request $req, Response $res) {
    $res->getBody()->write(PresentCourse::getCourseByTeacherId($req->getAttribute('ac')));
});/////////////**

$app->get('/getUserCourse/{ac}', function (Request $req, Response $res) {
    $id = $req->getAttribute('ac');
    $res->getBody()->write(PresentCourse::getByUserId($id));
});/////////////**

$app->get('/getCourseForListHome/{id}', function (Request $req, Response $res) {
    $id = $req->getAttribute('id');
    $res->getBody()->write(PresentCourse::getCourseForListHome($id));
});

$app->get('/getCourseByGroupingId/{id}', function (Request $req, Response $res) {
    $id = $req->getAttribute('id');
    $res->getBody()->write(PresentCourse::getCourseByGroupingId($id));
});

$app->get('/getCustomCourseListForHome', function (Request $req, Response $res) {

    $res->getBody()->write(PresentCourse::getCustomeCourseListForHome());
});

/////////////////////////////sabtenamMethods

$app->get('/sabtenam/{idCourse}/{idTeacher}/{idUser}', function (Request $req, Response $res) {
    $idCourse = $req->getAttribute('idCourse');
    $idTeacher = $req->getAttribute('idTeacher');
    $idUser = $req->getAttribute('idUser');
    $res->getBody()->write(PresentSabtenam::add($idCourse, $idTeacher, $idUser));

});

$app->get('/checkSabtenam/{idCourse}/{idUser}', function (Request $req, Response $res) {
    $idCourse = $req->getAttribute('idCourse');
    $idUser = $req->getAttribute('idUser');
    $res->getBody()->write(PresentSabtenam::checkValieded($idUser, $idCourse));

});

$app->get('/getRegistrationsName/{idCourse}/{idTeacher}', function (Request $req, Response $res) {

    $idCourse = $req->getAttribute('idCourse');
    $acTeacher = $req->getAttribute('idTeacher');
    $res->getBody()->write(PresentSabtenam::getRegistrationsName($idCourse, $acTeacher));

});

$app->get('/saveComment/{commentText}/{userId}/{courseId}/{teacherId}/{teacherRat}', function (Request $req, Response $res) {
    $commentText = $req->getAttribute('commentText');
    $userId = $req->getAttribute('userId');
    $courseId = $req->getAttribute('courseId');
    $teacherId = $req->getAttribute('teacherId');
    $teacherRat = $req->getAttribute('teacherRat');

    $res->getBody()->write(PresentComment::saveComment($commentText, $userId, $courseId, $teacherId, $teacherRat));
});

/*$app->get('/updateComment/{id}/{commentText}/{userId}/{courseId}/{teacherId}/{teacherRat}/{courseRat}', function (Request $req, Response $res) {
    $id = $req->getAttribute('id');
    $commentText = $req->getAttribute('commentText');
    $userId = $req->getAttribute('userId');
    $courseId = $req->getAttribute('courseId');
    $teacherId = $req->getAttribute('teacherid');
    $teacherRat = $req->getAttribute('teacherRat');
    $courseRat = $req->getAttribute('courseRat');
    $res->getBody()->write(PresentComment::upDateComment($id, $commentText, $userId, $courseId, $teacherId, $teacherRat, $courseRat));
});*/

$app->get('/saveCourseRat/{userId}/{courseId}/{teacherId}/{courseRat}', function (Request $req, Response $res) {
    $userId = $req->getAttribute('userId');
    $courseId = $req->getAttribute('courseId');
    $teacherId = $req->getAttribute('teacherId');
    $courseRat = $req->getAttribute('courseRat');
    $res->getBody()->write(PresentComment::saveCourseRat($userId, $courseId, $teacherId, $courseRat));
});


$app->get('/getCommentByTeacherId/{teacherId}', function (Request $req, Response $res) {
    $teacherId = $req->getAttribute('teacherId');
    $res->getBody()->write(PresentComment::getCommentByTeacherId($teacherId));
});

$app->get('/commentFeedBack/{userId}/{commentId}/{isLicked}', function (Request $req, Response $res) {
    $userId = $req->getAttribute('userId');
    $commentId = $req->getAttribute('commentId');
    $isLicked = $req->getAttribute('isLicked');
    $res->getBody()->write(PresentComment::feedBackComment($userId, $commentId, $isLicked));
});

$app->get('/getMsAndRat/{ac}', function (Request $req, Response $res) {
    $res->getBody()->write(PresenterTeacher::getMadrakStateAndRat($req->getAttribute('ac')));
});

$app->get('/upMs/{ac}', function (Request $req, Response $res) {
    $res->getBody()->write(PresenterTeacher::updateMadrakState($req->getAttribute('ac')));
});

$app->get('/saveSms/{text}/{tsId}/{rsId}/{courseId}/{howSending}', function (Request $req, Response $res) {

    $text = $req->getAttribute('text');
    $tsId = $req->getAttribute('tsId');
    $rsId = $req->getAttribute('rsId');
    $courseId = $req->getAttribute('courseId');
    $howSending = $req->getAttribute('howSending');
    $res->getBody()->write(PresentSmsBox::saveSms($text, $tsId, $rsId, $courseId, $howSending));

});

$app->get('/sendMoreSms/{data}/{message}', function (Request $req, Response $res) {

    $data = $req->getAttribute('data');
    $message = $req->getAttribute('message');
    $res->getBody()->write(PresentSmsBox::sendMoreSms($data, $message));

});

$app->get('/getRsSms/{rsId}', function (Request $req, Response $res) {

    $rsId = $req->getAttribute('rsId');
    $res->getBody()->write(PresentSmsBox::getRsSms($rsId));

});

$app->get('/getTsSms/{tsId}', function (Request $req, Response $res) {

    $tsId = $req->getAttribute('tsId');
    $res->getBody()->write(PresentSmsBox::getTsSms($tsId));

});

$app->get('/upDateSeen/{id}', function (Request $req, Response $res) {

    $id = $req->getAttribute('id');
    $res->getBody()->write(PresentSmsBox::upDateSeen($id));

});

$app->get('/deleteSms/{id}', function (Request $req, Response $res) {

    $id = $req->getAttribute('id');
    $res->getBody()->write(PresentSmsBox::deleteSms($id));

});

//$app->get('/updateDeletedFlag/{courseId}/{code}', function (Request $req, Response $res) {
//
//    $id = $req->getAttribute('courseId');
//    $code = $req->getAttribute('code');
//    $res->getBody()->write(PresentCourse::updateDeletedFlag($id, $code));
//
//});

$app->get('/updateCanceledFlag/{sabtenamId}/{code}/{courseId}/{message}/{tsId}/{rsId}', function (Request $req, Response $res) {

    $id = $req->getAttribute('sabtenamId');
    $code = $req->getAttribute('code');
    $courseId = $req->getAttribute('courseId');
    $message = $req->getAttribute('message');
    $tsId = $req->getAttribute('tsId');
    $rsId = $req->getAttribute('rsId');
    $res->getBody()->write(PresentSabtenam::updateCanceledFlag($id, $code, $courseId, $message, $tsId, $rsId));

});

$app->get('/updateMoreCanceledFlag/{data}/{message}', function (Request $req, Response $res) {

    $data = $req->getAttribute('data');
    $message = $req->getAttribute('message');
    $res->getBody()->write(PresentSabtenam::updateMoreCanceledFlag($data, $message));

});

$app->get('/checkedServerStatuse', function (Request $req, Response $res) {
    $rezuelt = array();
    $rezuelt["code"] = 1;
    $message = array();
    $message[] = $rezuelt;
    $res->getBody()->write(json_encode($message));
});

$app->get('/checkedUserStatuse/{id}', function (Request $req, Response $res) {
    $UserId = $req->getAttribute('id');
    $res->getBody()->write(PresentUser::checkUserStatuse($UserId));
});

$app->get('/confirmStudent/{sabtenamId}/{courseId}/{message}/{tsId}/{rsId}', function (Request $req, Response $res) {
    $sabtenamId = $req->getAttribute('sabtenamId');
    $courseId = $req->getAttribute('courseId');
    $message = $req->getAttribute('message');
    $tsId = $req->getAttribute('tsId');
    $rsId = $req->getAttribute('rsId');
    $res->getBody()->write(PresentSabtenam::confirmStudent($sabtenamId, $courseId, $message, $tsId, $rsId));
});

$app->get('/confirmMoreStudent/{data}/{message}', function (Request $req, Response $res) {
    $data = $req->getAttribute('data');
    $message = $req->getAttribute('message');
    $res->getBody()->write(PresentSabtenam::confirmMoreStudent($data, $message));
});

$app->get('/RePoRt/{signText}/{reportText}/{spamId}/{spamerId}/{reporterId}', function (Request $req, Response $res) {
    $signText = $req->getAttribute('signText');
    $reportText = $req->getAttribute('reportText');
    $spamId = $req->getAttribute('spamId');
    $spamerId = $req->getAttribute('spamerId');
    $reporterId = $req->getAttribute('reporterId');
    $res->getBody()->write(PresentReport::saveAReport($signText, $reportText, $spamId, $spamerId, $reporterId));
});

$app->get('/getMahoorAppData', function (Request $req, Response $res) {

    $res->getBody()->write(PresentAppData::getAppData());
});

$app->get('/getSubscribeList', function (Request $req, Response $res) {

    $res->getBody()->write(PresentSubscribe::getSubscribeList());
});

$app->get('/getUserBuySubscribe/{ac}', function (Request $req, Response $res) {

    $res->getBody()->write(PresentSubscribe::getUserSubscribe($req->getAttribute('ac')));
});

$app->post('/saveUserBuy', function (Request $req, Response $res) {

    $postParam = $req->getParsedBody();

    $tableName = $postParam['table_name'];
    $phone = $postParam['phone'];
    $phone = $postParam['phone'];

    //$res->getBody()->write(json_encode($responseArray));
});

$app->get('/test/{number}', function (Request $req, Response $res) {
    $res->getBody()->write("");
    $i = 0;
    $res->getBody()->write(getJDate($req->getAttribute('number')));
    //str_replace("-","",$req->getAttriute('id'))

});

$app->run();

















/*
 *
$app->get('/getCity/{ostanName}', function (Request $request, Response $response) {

    $name = $request->getAttribute('name');
   // $result = PresentOstanha::getcity($name);
  //  $response->getBody()->write($result);
    return $response;

});

$app->get('/ostan',function (Request $request,Response $response){

    $response->getBody()->write(PresentOstan::getOstan());
    return $response;

});
$app->get('/test', function (Request $request, Response $response) {

    $p = new Person();
    $result = $p->select();

    $res = array();

    while ($row = $result->fetch_assoc()){
        $person = array();
        $person['id'] = $row['کد استان'];
        $person['name'] = $row['نام استان'];
        $res[] = $person;
    }

    $response->getBody()->write(json_encode($res));
});
 *
 *
 *
 *
 *
 *
 *
 *
 * $myInt = 15;
$myFloat = 3.14;
$myString = "salam";

$jsonA = array();

$jsonA[0] = 10;
$jsonA[1] = "hello";
$jsonA['token'] = "aSDFASDF ASD ASDF ";

$s = $jsonA['token'];

$res  = getCourse();

echo json_encode($res);


function getCourse(){
    $respone = array();
    $respone['error'] = false;

    $allCourse = array();

    for($i = 0; $i < 10; $i++){
        $course = array();

        $course['id'] = $i;
        $course['name'] = "test " . $i;
        $course['seen'] =  $i * 1000;

        $allCourse[] = $course;
    }
    $respone['result']['course'] = $allCourse;
    $respone['result']['data'] = array();

    return $respone;
}*/

