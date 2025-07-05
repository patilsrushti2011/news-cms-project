<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                
                <form action="save-post.php" method="POST" enctype="multipart/form-data" class="general-form">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <?php
                        include "config.php";
                        $sql1 = "SELECT * FROM category";
                        $result1 = mysqli_query($conn, $sql1) or die("Query failed");
                        if (mysqli_num_rows($result1) > 0) {
                            echo '<select name="category" class="form-control">';
                            while ($row = mysqli_fetch_assoc($result1)) {
                                echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Post Image</label>
                        <h5>Upload only jpg/png/jpeg file</h5>
                        <input type="file" name="fileToUpload" required>
                    </div>

                    <!--  Editorial Pick for (Admin only) -->
                    <?php if ($_SESSION['user_role'] == 1) { ?>
                        <div class="form-group">
                            <label><input type="checkbox" name="is_editorial" value="1"> Mark as Editorial Pick</label>
                        </div>
                    <?php } ?>

                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
   
            </div>
        </div>
    </div>
</div>

