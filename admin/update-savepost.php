<?php
session_start();
include "config.php";


if (empty($_FILES['new-image']['name'])) {
    $image_name = $_POST['old-image'];
} else {
    $errors = array();
    $filename = $_FILES['new-image']['name'];
    $filetype = $_FILES['new-image']['type'];
    $filesize = $_FILES['new-image']['size'];
    $filetmp = $_FILES['new-image']['tmp_name'];

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $file_ext = strtolower($ext);
    $extensions = array("jpg", "png", "jpeg");

    if (!in_array($file_ext, $extensions)) {
        $errors[] = "Only JPG, PNG, or JPEG files are allowed.";
    }

    if ($filesize > 2097152) {
        $errors[] = "Please upload file less than 2MB.";
    }

    $newname = time() . "-" . basename($filename);
    $target = "upload/" . $newname;
    $image_name = $newname;

    if (empty($errors)) {
        move_uploaded_file($filetmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

$pid         = mysqli_real_escape_string($conn, $_POST['post_id']);
$post_title  = mysqli_real_escape_string($conn, $_POST['post_title']);
$postdesc    = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category    = mysqli_real_escape_string($conn, $_POST['category']);
$oldcategory = mysqli_real_escape_string($conn, $_POST['oldcategory']);


$is_editorial = 0;
if ($_SESSION['user_role'] == 1 && isset($_POST['is_editorial'])) {
    $is_editorial = 1;
}


$sql1 = "UPDATE post SET 
    title = '{$post_title}', 
    description = '{$postdesc}', 
    category = {$category}, 
    post_img = '{$image_name}', 
    is_editorial = {$is_editorial} 
    WHERE post_id = {$pid};";


if ($category != $oldcategory) {
    $sql1 .= "UPDATE category SET post = post + 1 WHERE category_id = {$category};";
    $sql1 .= "UPDATE category SET post = post - 1 WHERE category_id = {$oldcategory};";
}


if (mysqli_multi_query($conn, $sql1)) {
    header("Location: http://localhost/news-cms/admin/post.php");
    exit();
} else {
    echo "Query failed: " . mysqli_error($conn);
}
?>
