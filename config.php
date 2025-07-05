<?php
$conn=mysqli_connect("localhost","root","","news-site") or die("connection failed :".mysqli_connect_error());
?>
<?php
// if you are not logged in and you know filename then you can easily
//     access that files so we put here condition if your login is not set means not exist then you canit see any file
//     if you enter login details and you ogged in then you see alls files
