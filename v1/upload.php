<?php
$target_dir_tabaghe = "uploads/tabaghe/";
$target_dir_teacher = "uploads/teacher/";
$target_dir_madrak = "uploads/madrak/";
$target_dir_course = "uploads/course/";
$target_file = "";
$result = 0;
$res = array();
if (file_exists($target_file)) {
    unlink($target_file);
}

if (isset($_FILES['tabaghe']['name'])) {
    if ($_FILES["tabaghe"]["size"] > 5000000) {
        $result = 2;
    }

} else if (isset($_FILES['teacher']['name'])) {
    if ($_FILES["teacher"]["size"] > 5000000) {
        $result = 2;
    }
} else if (isset($_FILES['madrak']['name'])) {
    if ($_FILES["madrak"]["size"] > 5000000) {
        $result = 2;
    }
} else if (isset($_FILES['course']['name'])) {
    if ($_FILES["course"]["size"] > 5000000) {
        $result = 2;
    }
}
if ($result != 2) {
    if (isset($_FILES['tabaghe']['name'])) {
        $target_file = $target_dir_tabaghe . basename($_FILES["tabaghe"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["tabaghe"]["tmp_name"], $target_file);
        $result = 1;

    } else if (isset($_FILES['teacher']['name'])) {
        $target_file = $target_dir_teacher . basename($_FILES["teacher"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["teacher"]["tmp_name"], $target_file);
        $result = 1;
    } else if (isset($_FILES['madrak']['name'])) {
        $target_file = $target_dir_madrak . basename($_FILES["madrak"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["madrak"]["tmp_name"], $target_file);
        $result = 1;
    } else if (isset($_FILES['course']['name'])) {
        $target_file = $target_dir_course . basename($_FILES["course"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["course"]["tmp_name"], $target_file);
        $result = 1;
    }
}
$res = array();
$res["code"] = $result;
$message = array();
$message[] = $res;
echo json_encode($message);

