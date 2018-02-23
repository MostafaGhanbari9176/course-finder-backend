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
require 'present/PresentTabaghe.php';
require 'Present/PresentCourse.php';
require 'Present/PresentSabtenam.php';
require 'jdf.php';


$app = new \Slim\App;

/*$app->get('/getOstan', function (Request $req, Response $response) {

    $result = PresentOstan::getOstan();
    $response->getBody()->write($result);
});*/

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

/*$app->get('/getCity/{flag}', function (Request $request, Response $response) {

    $flag = $request->getAttribute('flag');
    $result = PresentCity::getCity($flag);
    $response->getBody()->write($result);
});*/

/*$app->get('/updateUser/{phone}/{name}', function (Request $req, Response $res) {
    $phone = $req->getAttribute('phone');
    $name = $req->getAttribute('name');
    $result = PresentUser::updateUser($phone, $name);
    $res->getBody()->write($result);
});*/

/*$app->get('/getUser/{phone}', function (Request $request, Response $response) {
    $result = PresentUser::getUser($request->getAttribute('phone'));
    $response->getBody()->write($result);
});*/

$app->get('/createAndSaveSmsCode/{phone}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentSmsCode::creatAndSaveSmsCode($request->getAttribute('phone')));
});

$app->get('/checkedSmsCode/{phone}/{code}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentSmsCode::checkedSmsCode($request->getAttribute('phone'), $request->getAttribute('code')));
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

/*$app->get('/updateTeacher/{phone}/{landPhone}/{address}/{subject}/{cityId}/{madrak}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $landPhone = $req->getAttribute('landPhone');
    $subject = $req->getAttribute('subject');
    $address = $req->getAttribute('address');
    $cityId = $req->getAttribute('cityId');
    $madrak = $req->getAttribute('madrak');

    $res->getBody()->write(PresenterTeacher::updateTeacher($phone, $landPhone, $madrak, $subject, $address, $cityId));

});*/

$app->get('/getTabaghe/{uperId}', function (Request $req, Response $res) {

    $uperId = $req->getAttribute('uperId');
    $res->getBody()->write(PresentTabaghe::getTabaghe($uperId));
});

$app->get('/addCourse/{ac}/{subject}/{tabaghe_id}/{type}/{capacity}/{mony}/{sharayet}/{tozihat}/{start_date}/{end_date}/{day}/{hours}/{minOld}/{maxOld}',  function (Request $req, Response $res) {
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

$app->get('/getAllCourse', function (Request $req, Response $res) {
    $res->getBody()->write(PresentCourse::getAllCourse());
});

$app->get('/getCourseById/{id}', function (Request $req, Response $res) {
    $res->getBody()->write(PresentCourse::getCourseById($req->getAttribute('id')));
});

$app->get('/getCourseByTeacherId/{ac}', function (Request $req, Response $res) {
    $res->getBody()->write(PresentCourse::getCourseByTeacherId($req->getAttribute('ac')));
});

$app->get('/getUserCourse/{ac}', function (Request $req, Response $res) {
    $id = $req->getAttribute('ac');
    $res->getBody()->write(PresentCourse::getByUserId($id));
});

$app->get('/getNewCourse', function (Request $req, Response $res) {

    $res->getBody()->write(PresentCourse::getNewCourse());
});

$app->get('/checkedServer', function (Request $req, Response $res) {
    $rezuelt = array();
    $rezuelt["code"] = 1;
    $message = array();
    $message[] = $rezuelt;
    $res->getBody()->write(json_encode($message));
});

$app->get('/sabtenam/{idCourse}/{idTeacher}/{idUser}', function (Request $req, Response $res) {
    $idCourse = $req->getAttribute('idCourse');
    $idTeacher = $req->getAttribute('idTeacher');
    $idUser = $req->getAttribute('idUser');
    $res->getBody()->write(PresentSabtenam::add($idCourse, $idTeacher, $idUser));

});

$app->get('/saveComment/{ac}', function (Request $req, Response $res) {
    $id = $req->getAttribute('ac');
    $res->getBody()->write(PresentCourse::getByUserId($id));
});

$app->get('/getMs/{ac}', function (Request $req, Response $res) {
    $res->getBody()->write(PresenterTeacher::getMadrakState($req->getAttribute('ac')));
});

$app->get('/upMs/{ac}', function (Request $req, Response $res) {
    $res->getBody()->write(PresenterTeacher::updateMadrakState($req->getAttribute('ac')));
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

