<?php

$target_dir_1 = "model/";
$target_dir_2 = "present/";
$target_file = "";
$result = 0;
$res = array();

if (isset($_FILES['MoStAfARePlAcESaRvArFiLe']['name'])) {
    $target_file = basename($_FILES["MoStAfARePlAcESaRvArFiLe"]["name"]);
    if (file_exists($target_file)) {
        unlink($target_file);
        move_uploaded_file($_FILES["MoStAfARePlAcESaRvArFiLe"]["tmp_name"], $target_file);
        $result = 1;
    } else if (file_exists($target_dir_1 . $target_file)) {
        unlink($target_dir_1 . $target_file);
        move_uploaded_file($_FILES["MoStAfARePlAcESaRvArFiLe"]["tmp_name"], $target_dir_1 . $target_file);
        $result = 2;
    } else if (file_exists($target_dir_2 . $target_file)) {
        unlink($target_dir_2 . $target_file);
        move_uploaded_file($_FILES["MoStAfARePlAcESaRvArFiLe"]["tmp_name"], $target_dir_2 . $target_file);
        $result = 3;
    }
}


$res = array();
$res["code"] = $result;
$message = array();
$message[] = $res;
echo json_encode($message);
