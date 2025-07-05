<?php  
if($_SESSION['user_role']==0)
{
   header("Location: http://localhost/news-cms/admin/post.php");
}
include "config.php";

$cat_id=$_GET['cid'];
$sql1="delete from category where category_id={$cat_id}";
$result1 = mysqli_query($conn, $sql1) or die("Query failed");
header("Location: http://localhost/news-cms/admin/category.php");
mysqli_close($conn);
?>