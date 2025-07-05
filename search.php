<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    include "config.php";

                    $search_txt = ""; // default to prevent undefined error

                    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                        $search_txt = mysqli_real_escape_string($conn, $_GET['search']);

                        $sql1 = "SELECT * FROM post 
                               JOIN category ON post.category = category.category_id
                               JOIN user ON post.author = user.user_id
                               WHERE post.title LIKE '%{$search_txt}%'
                               OR post.description LIKE '%{$search_txt}%'
                               OR user.username LIKE '%{$search_txt}%'";

                        $result1 = mysqli_query($conn, $sql1) or die("Query Failed");
                        $totalrecords = mysqli_num_rows($result1);
                    } else {
                        echo "<h2 class='page-heading'>Search: No search keyword entered.</h2>";
                        exit(); // Stop page if no search
                    }

                    // Display heading
                    if ($totalrecords > 0) {
                        echo '<h2 class="page-heading">Search: ' . htmlspecialchars($search_txt) . '</h2>';
                    } else {
                        echo '<h2 class="page-heading">Search: No Record Found</h2>';
                    }

                    $limit = 3;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT * FROM post 
                            JOIN category ON post.category = category.category_id
                            JOIN user ON post.author = user.user_id 
                            WHERE post.title LIKE '%{$search_txt}%' 
                            OR post.description LIKE '%{$search_txt}%' 
                            OR user.username LIKE '%{$search_txt}%' 
                            ORDER BY post.post_id DESC 
                            LIMIT {$offset},{$limit}";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>">
                                            <img src="admin/upload/<?php echo $row['post_img']; ?>" alt="no image found" />
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
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
                                                <?php echo substr($row['description'], 0, 120) . "...."; ?>
                                                <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }

                    
                    if ($totalrecords > 0) {
                        $totalpage = ceil($totalrecords / $limit);

                        echo "<ul class='pagination admin-pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="search.php?search=' . urlencode($search_txt) . '&page=' . ($page - 1) . '">Prev</a></li>';
                        }

                        for ($i = 1; $i <= $totalpage; $i++) {
                            $active = ($page == $i) ? "active" : "";
                            echo '<li class="' . $active . '"><a href="search.php?search=' . urlencode($search_txt) . '&page=' . $i . '">' . $i . '</a></li>';
                        }

                        if ($page < $totalpage) {
                            echo '<li><a href="search.php?search=' . urlencode($search_txt) . '&page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php include 'latest-news.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>