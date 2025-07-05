<?php  
if($_SESSION['user_role']==0)
{
   header("Location: http://localhost/news-cms/admin/post.php");
}
include "config.php";

$userid=$_GET['id'];
$sql1="delete from user where user_id={$userid}";
$result1 = mysqli_query($conn, $sql1) or die("Query failed");
header("Location: http://localhost/news-cms/admin/users.php");
mysqli_close($conn);
?>