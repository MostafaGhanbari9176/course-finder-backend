<?php
/**
 * Created by PhpStorm.
 * User: M-gh
 * Date: 17-Aug-18
 * Time: 2:31 PM
 */

$targetDir = '../apk/';
$target_file = "";
$result = 0;
$res = array();

if (isset($_FILES['uploadingMGApp']['name'])) {
    if ($_FILES["uploadingMGApp"]["size"] > 5242880 || $_FILES["uploadingMGApp"]["size"] < 2242880) {
        $target_file = $targetDir . basename($_FILES["uploadingMGApp"]["name"]);
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($fileType != "apk") {
            $result = 3;
        } else {
            move_uploaded_file($_FILES["uploadingMGApp"]["tmp_name"], $target_file);
            $result = 1;
        }
    } else
        $result = 2;

}

$res = array();
$res["code"] = $result;
$message = array();
$message[] = $res;
echo json_encode($message);