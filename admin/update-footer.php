<?php 
include "header.php"; 
include "config.php"; 

if (isset($_POST['submit'])) {
    $id = $_POST['user_id'];

    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactnumber = mysqli_real_escape_string($conn, $_POST['contactnumber']);

    $sql = "UPDATE site_settings SET 
            about = '{$about}', 
            email = '{$email}', 
            phone = '{$contactnumber}' 
            WHERE id = {$id}";

    $result = mysqli_query($conn, $sql) or die("Query failed");

    header("Location: http://localhost/news-cms/admin/footer.php");
    mysqli_close($conn);
}
?>


<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <?php
                $id = $_GET['id'];
                $sql = "SELECT id, about, email, phone FROM site_settings WHERE id = '{$id}'";
                $result = mysqli_query($conn, $sql) or die("Query failed");

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST" class="general-form">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">

                   <div class="form-group">
    <label for="about">About</label>
    <textarea name="about" class="form-control"><?php echo $row['about']; ?></textarea>
</div>

                    <div class="form-group">
                        <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>" >
                    </div>
                  
                       <div class="form-group">
                        <label for="contactnumber">Contact Number</label>
                        <input type="text" name="contactnumber" class="form-control" value="<?php echo $row['phone']; ?>" >
                    </div>
                

                        <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                    </form>
                <?php
                } else {
                    echo "<div class='alert alert-danger'>Not updated</div>";
                }
                ?>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>

