<div class="container">
    <h3 class="text-primary h3-heading">Latest News >></h3>
    <div class="row">
        <?php
        include "config.php";

        // Get one latest post per category
        $sql = "SELECT p.post_id, p.title, p.description, p.post_date, p.post_img,
               c.category_name, c.category_id,
               u.username, u.user_id
        FROM post p
        INNER JOIN (
            SELECT MAX(post_id) as latest_post_id
            FROM post
            WHERE is_editorial = 0
            GROUP BY category
        ) as latest ON p.post_id = latest.latest_post_id
        LEFT JOIN category c ON p.category = c.category_id
        LEFT JOIN user u ON p.author = u.user_id
        ORDER BY p.post_id DESC 
        LIMIT 4";


        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="col-sm-6 col-md-3">
                    <div class="panel panel-default editorial-card" style="height: 300px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="panel-heading" style="height: 45px; overflow: hidden;">
                            <strong>

                                <a href="single.php?id=<?php echo $row['post_id']; ?>"
                                    style="display: block; text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">

                                    <?php echo $row['title']; ?>
                                </a>
                            </strong>
                        </div>


                        <div class="panel-body" style="padding: 15px; display: flex; flex-direction: column; height: 500px;">
                            <!-- Image -->
                            <div style="height: 120px; overflow: hidden; text-align: center;">
                                <a href="single.php?id=<?php echo $row['post_id']; ?>">
                                    <img src="admin/upload/<?php echo $row['post_img']; ?>"
                                        class="img-responsive"
                                        style="max-width: 100%; height: auto; display: inline-block;"
                                        alt="Post Image">
                                </a>
                            </div>



                            <p style="margin: 6px 0 4px; font-size: 12px;  color: #777;">
                                <i class="fa fa-tags"></i>
                                <a href="category.php?cid=<?php echo $row['category_id']; ?>">
                                    <?php echo $row['category_name']; ?>
                                </a>
                                <i class="fa fa-calendar" style="margin-left:20px"></i> <?php echo $row['post_date']; ?>
                            </p>

                            <div>
                                <p class="description">
                                    <?php echo substr($row['description'], 0, 50) . "...."; ?></p>
                            </div>

                            <!-- Read More -->
                            <a href="single.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs " style="margin-top: 8px;">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>

        <?php
            }
        } else {
            echo "<p>No editorial picks found.</p>";
        }
        ?>
    </div>
</div>