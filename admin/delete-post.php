 <?php  
// if($_SESSION['user_role']==0)
// {
//    header("Location: http://localhost/news-cms/admin/post.php");
// } 
include "config.php";

$post_id=$_GET['pid'];
$sql="select * from post where post_id={$post_id}";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
// echo"<pre>";
// print_r($row);
// echo"</pre>";
// die();
unlink("upload/".$row['post_img']);//to delete image in server we use this command
$cat_id=$_GET['cat_id'];
$sql1="delete from post where post_id={$post_id};";
$sql1.="update category set post=post - 1 where category_id={$cat_id}";

if (mysqli_multi_query($conn, $sql1))
{
   header("Location: http://localhost/news-cms/admin/post.php");
}
else
{
   echo "Query Failed";
}

mysqli_close($conn);
?>