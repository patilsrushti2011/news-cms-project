<?php 
include "header.php";

if ($_SESSION['user_role'] == 0) {
    include "config.php";
    $postid = $_GET['pid'];
    $sql2 = "SELECT author FROM post WHERE post_id = {$postid}";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    if ($row2['author'] != $_SESSION['userid']) {
        header("Location: http://localhost/news-cms/admin/post.php");
        exit;
    }
}
?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form for show edit -->
                <?php
                $postid = $_GET['pid'];
                include "config.php";

                $sql = "SELECT post.post_id, post.title, category.category_name, post.description, post.post_img, post.category, post.is_editorial 
                        FROM post 
                        LEFT JOIN category ON post.category = category.category_id 
                        LEFT JOIN user ON post.author = user.user_id 
                        WHERE post.post_id = {$postid}";

                $result = mysqli_query($conn, $sql) or die("Query failed");

                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <form action="update-savepost.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="general-form">
                            <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">

                            <!-- Post Title -->
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="post_title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                            </div>

                            <!-- Post Description -->
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea name="postdesc" class="form-control" required rows="5"><?php echo htmlspecialchars(trim($row['description'])); ?></textarea>
                            </div>

                            <!-- Post Category -->
                            <div class="form-group">
                                <label>Category</label>
                                <?php
                                $sqls = "SELECT * FROM category";
                                $results = mysqli_query($conn, $sqls) or die("Query failed");

                                if (mysqli_num_rows($results) > 0) {
                                    echo "<select name='category' class='form-control'>";
                                    while ($rows = mysqli_fetch_assoc($results)) {
                                        $selected = ($rows['category_id'] == $row['category']) ? "selected" : "";
                                        echo "<option {$selected} value='{$rows['category_id']}'>{$rows['category_name']}</option>";
                                    }
                                    echo "</select>";
                                }
                                ?>
                                <input type="hidden" name="oldcategory" value="<?php echo $row['category']; ?>">
                            </div>

                            <!-- Post Image -->
                            <div class="form-group">
                                <label>Post Image</label>
                                <input type="file" name="new-image">
                                <img src="upload/<?php echo $row['post_img']; ?>" height="150px" style="display:block;margin-top:10px;">
                                <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>">
                            </div>

                            <!-- Editorial Pick checkbox for (Admin Only) -->
                            <?php if ($_SESSION['user_role'] == 1) { ?>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_editorial" value="1" <?php echo ($row['is_editorial'] == 1) ? "checked" : ""; ?>>
                                        Mark as Editorial Pick
                                    </label>
                                </div>
                            <?php } ?>

                            <!-- Submit Button -->
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php
                    }
                } else {
                    echo "<div class='alert alert-danger'>Post not found.</div>";
                }
                ?>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>

