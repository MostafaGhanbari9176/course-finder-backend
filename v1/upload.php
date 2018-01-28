<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
$res = array();
if(isset($_POST["submit"])) {
    //$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

}
// Check if file already exists
if (file_exists($target_file)) {
    $res['code'] = 1;
    $res['message'] = "Sorry, file already exists.";
    apc_delete_file($target_file);
    echo json_encode($res);
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $res['code'] = 1;
    $res['message'] = "Sorry, your file is too large.";

    echo json_encode($res);
    $uploadOk = 0;
}
// Allow certain file formats
/*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $res['code'] = 1;
    $res['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

    echo json_encode($res);
    $uploadOk = 0;
}*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

// if everything is ok, try to upload file
} else {
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    /*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $res['code'] = 1;
        $res['message'] = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        echo json_encode($res);
    } else {
        $res['code'] = 1;
        $res['message'] = "Sorry, there was an error uploading your file.";

        echo json_encode($res);
    }*/
}
