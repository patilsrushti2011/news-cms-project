<?php
$errors = array();
include "config.php";

if (isset($_FILES['fileToUpload'])) {
    $filename = $_FILES['fileToUpload']['name'];
    $filetype = $_FILES['fileToUpload']['type'];
    $filesize = $_FILES['fileToUpload']['size'];
    $filetmp = $_FILES['fileToUpload']['tmp_name'];

    $file_ext = strtolower(end(explode('.', $filename)));
    $extensions = array("jpg", "png", "jpeg");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "This extension file is not allowed, please choose a jpg or png image";
    }

    if ($filesize > 2097152) {
        $errors[] = "Please upload file less than or equal to 2 MB";
    }

    $newname = time() . "-" . basename($filename);
    $target = "upload/" . $newname;

    if (empty($errors) == true) {
        move_uploaded_file($filetmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

session_start();

$post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
$postdesc   = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category   = mysqli_real_escape_string($conn, $_POST['category']);
$date       = date("d M,Y");
$author     = $_SESSION['userid'];

//Editorial Pick checkbox handling
$is_editorial = ($_SESSION['user_role'] == 1 && isset($_POST['is_editorial'])) ? 1 : 0;


// Updated query with is_editorial field
$sql  = "INSERT INTO post(title, description, category, post_date, author, post_img, is_editorial)
         VALUES('{$post_title}', '{$postdesc}', '{$category}', '{$date}', {$author}, '{$newname}', {$is_editorial});";


$sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: http://localhost/news-cms/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Query failed</div>";
}
?>
