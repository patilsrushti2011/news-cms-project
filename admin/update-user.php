<?php 
include "header.php"; 

if ($_SESSION['user_role'] == 0) {
    header("Location: http://localhost/news-cms/admin/post.php");
}

include "config.php";

if (isset($_POST['submit'])) {
    $userid    = mysqli_real_escape_string($conn, $_POST['user_id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lastname  = mysqli_real_escape_string($conn, $_POST['l_name']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $role      = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "UPDATE user SET 
            first_name = '{$firstname}', 
            last_name = '{$lastname}', 
            username = '{$username}', 
            role = '{$role}' 
            WHERE user_id = {$userid}";

    $result = mysqli_query($conn, $sql) or die("Query failed");

    header("Location: http://localhost/news-cms/admin/users.php");
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
                $userid = $_GET['id'];
                $sql = "SELECT user_id, first_name, last_name, username, role FROM user WHERE user_id = '{$userid}'";
                $result = mysqli_query($conn, $sql) or die("Query failed");

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $userid; ?>" method="POST" class="general-form">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>User Role</label>
                            <select class="form-control" name="role">
                                <option value="0" <?php if ($row['role'] == 0) echo "selected"; ?>>Normal</option>
                                <option value="1" <?php if ($row['role'] == 1) echo "selected"; ?>>Admin</option>
                            </select>
                        </div>

                        <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                    </form>
                <?php
                } else {
                    echo "<div class='alert alert-danger'>User not found.</div>";
                }
                ?>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>

