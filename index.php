<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row" >
            <div class="col-md-12">
                <?php include 'latest-news.php'; ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    $limit = 3;
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }

                    $offset = ($page - 1) * $limit;
                    include "config.php";

                    $sql = "SELECT * FROM post 
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id 
                            ORDER BY post.post_id DESC 
                            LIMIT {$offset}, {$limit}";

                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>">
                                    <img src="admin/upload/<?php echo $row['post_img']; ?>" alt="no image found"/>
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3>
                                        <a href='single.php?id=<?php echo $row['post_id']; ?>'>
                                            <?php echo $row['title']; ?>
                                            <?php if ($row['is_editorial'] == 1): ?>
                                                <span style="color:#fd7e14; font-size: 14px; margin-left: 8px;">★ Editorial</span>
                                            <?php endif; ?>
                                        </a>
                                    </h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row['description'], 0, 200) . "...."; ?>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }

                    $sql1 = "SELECT * FROM post";
                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed");
                    if (mysqli_num_rows($result1)) {
                        $totalrecords = mysqli_num_rows($result1);
                        $totalpage = ceil($totalrecords / $limit);
                        echo "<ul class='pagination admin-pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="index.php?page=' . ($page - 1) . '">Prev</a></li>';
                        }
                        for ($i = 1; $i <= $totalpage; $i++) {
                            $active = ($page == $i) ? "active" : "";
                            echo '<li class="' . $active . '"><a href="index.php?page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($page < $totalpage) {
                            echo '<li><a href="index.php?page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
        </div>
    </div>
</div>

<?php include 'editorial.php'; ?>
<?php include 'footer.php'; ?>
