<?php
require_once 'model/Teacher.php';
$target_dir_tabaghe = "../v1/uploads/tabaghe/";
$target_dir_teacher = "../v1/uploads/teacher/";
$target_dir_video =  "../v1/uploads/newsVideo/";
$target_dir_madrak = "../v1/uploads/madrak/";
$target_dir_course = "../v1/uploads/course/";
$target_file = "";
$result = 0;
$res = array();


if (isset($_FILES['teacher']['name'])) {//5mb                                 5kb
    if ($_FILES["teacher"]["size"] > 5242880 || $_FILES["teacher"]["size"] < 5120) {
        $result = 2;
    }
}if (isset($_FILES['newsVideo']['name'])) {//5mb                                 5kb
    if ($_FILES["newsVideo"]["size"] > 5242880 || $_FILES["newsVideo"]["size"] < 5120) {
        $result = 2;
    }
}
else if (isset($_FILES['madrak']['name'])) {
    if ($_FILES["madrak"]["size"] > 5242880 || $_FILES["madrak"]["size"] < 5120) {
        $result = 2;
    }
} else if (isset($_FILES['course']['name'])) {
    if ($_FILES["course"]["size"] > 5242880 || $_FILES["course"]["size"] < 5120) {
        $result = 2;
    }
}
if ($result != 2) {
    if (isset($_FILES['teacher']['name'])) {
        $target_file = $target_dir_teacher . basename($_FILES["teacher"]["name"]);
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $result = 3;
        } else {
            move_uploaded_file($_FILES["teacher"]["tmp_name"], $target_file);
            $result = 1;
        }
    }    if (isset($_FILES['newsVideo']['name'])) {
        $target_file = $target_dir_video . basename($_FILES["newsVideo"]["name"]);
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "mkv" && $imageFileType != "mp4" && $imageFileType != "3gp" && $imageFileType != "flv") {
            $result = 3;
        } else {
            move_uploaded_file($_FILES["newsVideo"]["tmp_name"], $target_file);
            $result = 1;
        }
    }
    else if (isset($_FILES['madrak']['name'])) {
        $target_file = $target_dir_madrak . basename($_FILES["madrak"]["name"]);
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "pdf") {
            $result = 3;
        } else {
            move_uploaded_file($_FILES["madrak"]["tmp_name"], $target_file);
            $result = 1;
        }

    } else if (isset($_FILES['course']['name'])) {
        $target_file = $target_dir_course . basename($_FILES["course"]["name"]);
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $result = 3;
        } else {
            move_uploaded_file($_FILES["course"]["tmp_name"], $target_file);
            $result = 1;
        }
    }
}

    $res = array();
    $res["code"] = $result;
    $message = array();
    $message[] = $res;
    echo json_encode($message);
