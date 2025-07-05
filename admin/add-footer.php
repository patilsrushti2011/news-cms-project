<?php include "header.php";
if($_SESSION['user_role']==0)
{
   header("Location: http://localhost/news-cms/admin/post.php");
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Edit Footer</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST"  class="general-form">
                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea name="about" class="form-control" autocomplete="off"  ></textarea>
                        
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" autocomplete="off" >
                    </div>
                  
                       <div class="form-group">
                        <label for="contactnumber">Contact Number</label>
                        <input type="text" name="contactnumber" class="form-control" autocomplete="off" >
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
                <!--/Form -->
            </div>
        </div>
    </div>
</div>
<?php

include "config.php"; 

if (isset($_POST['submit'])) {

    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['contactnumber']);

   
    $sql = "INSERT INTO site_settings (about, email, phone) 
            VALUES ('$about', '$email', '$phonenumber')";

  
    if (mysqli_query($conn, $sql)) {
        echo "Site settings saved successfully.";
         header("Location: http://localhost/news-cms/admin/footer.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

