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


$app = new \Slim\App;

$app->get('/getOstan', function (Request $req, Response $response) {

    $result = PresentOstan::getOstan();
    $response->getBody()->write($result);
});

$app->get('/logIn/{phone}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $result = PresentUser::logIn($phone);
    $res->getBody()->write($result);

});

$app->get('/getCity/{flag}', function (Request $request, Response $response) {

    $flag = $request->getAttribute('flag');
    $result = PresentCity::getCity($flag);
    $response->getBody()->write($result);
});

$app->get('/updateUser/{phone}/{name}/{family}/{status}/{type}/{cityId}/{apiCode}', function (Request $req, Response $res) {

    $phone = $req->getAttribute('phone');
    $name = $req->getAttribute('name');
    $family = $req->getAttribute('family');
    $status = $req->getAttribute('status');
    $type = $req->getAttribute('type');
    $cityId = $req->getAttribute('cityId');
    $apiCode = $req->getAttribute('apiCode');

    $result = PresentUser::updateUser($phone, $name, $family, $status, $type, $cityId, $apiCode);
    $res->getBody()->write($result);
});

$app->get('/getUser/{phone}', function (Request $request, Response $response) {
    $result = PresentUser::getUser($request->getAttribute('phone'));
    $response->getBody()->write($result);
});

$app->get('/createAndSaveSmsCode/{phone}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentSmsCode::creatAndSaveSmsCode($request->getAttribute('phone')));
});

$app->get('/checkedSmsCode/{phone}/{code}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentSmsCode::checkedSmsCode($request->getAttribute('phone'), $request->getAttribute('code')));
});

$app->get('/logOut/{phone}', function (Request $request, Response $response) {

    $response->getBody()->write(PresentUser::logOut($request->getAttribute('phone')));

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

