<?php include 'header.php'; 
       include 'config.php';?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->

                <div class="post-container">
                    <?php
                   if (isset($_GET['aid'])) {
                    $auth_id = $_GET['aid'];
                   
                     }

                    $sql1 = "select * from post join user on post.author=user.user_id where post.author={$auth_id}";
                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed");
                    $row1 = mysqli_fetch_assoc($result1)

                    ?>

                    <h2 class="page-heading"><?php echo $row1['username']; ?></h2>
                    <?php




                    $limit = 3;
                    //    $page=$_GET['page'];
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }

                    $offset = ($page - 1) *  $limit;
                    include "config.php";
                    $sql = "select * from post 
                                join category on post.category=category.category_id
                                join user on post.author=user.user_id 
                                where post.author= {$auth_id}
                                order by post.post_id desc limit {$offset},{$limit}";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {


                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt="no image found" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                            <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row['category'] ;?>'><?php echo $row['category_name'] ;?></a>
                                            </span>
                                                <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?aid=<?php echo $row['author'] ;?>'><?php echo $row['username'] ;?></a>
                                            </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date']; ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 120) . "...."; ?>
                                                <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }

                    if (mysqli_num_rows($result1)) {

                        $totalrecords = mysqli_num_rows($result1);
                        //  echo $totalrecords;
                        //  die();
                        $totalpage = ceil($totalrecords / $limit);
                        echo "<ul class='pagination admin-pagination'>";
                        if ($page > 1) {
                            echo '<li><a href="author.php?aid=' . $auth_id . '&page=' . ($page - 1) . '">Prev</a></li>';
                        } //prev
                        for ($i = 1; $i <= $totalpage; $i++) {
                            if ($page == $i) {
                                $active = "active";
                            } else {
                                $active = "";
                            }
                            echo '<li class="' . $active . '"><a href="author.php?aid=' . $auth_id . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($page < $totalpage) { //next
                            echo '<li><a href="author.php?aid=' . $auth_id . '&page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }

                    
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'latest-news.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>