<?php include 'header.php'; ?>


<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    include "config.php";

                    // Check if 'id' parameter is present and valid
                    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                        $postid = $_GET['id'];

                        // Query to get post with category and author info
                        $sql = "SELECT * FROM post 
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id 
                                WHERE post.post_id = {$postid}";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                                <div class="post-content single-post">
                                    <h3><?php echo $row['title']; ?></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category']; ?>'>
                                                <?php echo $row['category_name']; ?>
                                            </a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author']; ?>'>
                                                <?php echo $row['username']; ?>
                                            </a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
                                    </div>
                                    
                                    <!-- Featured Image with fixed size -->
                                    <img class="single-feature-image img-responsive" 
                                         src="admin/upload/<?php echo $row['post_img']; ?>" 
                                         alt="Post Image" />

                                    <p class="description">
                                        <?php echo $row['description']; ?>
                                    </p>
                                </div>
                    <?php
                            }
                        } else {
                            echo "<h2>No Post Found.</h2>";
                        }
                    } else {
                        echo "<h2>Invalid or Missing Post ID.</h2>";
                    }
                    ?>
                </div>
                <!-- /post-container -->
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
