<div class="container">
      <h3 class="text-primary h3-heading"> Editorial Picks >></h3>
    <div class="row" style="display: flex; flex-wrap: wrap;">
        <?php
        include "config.php";
        $sql = "SELECT * FROM post 
                JOIN category ON post.category = category.category_id 
                JOIN user ON post.author = user.user_id 
                WHERE post.is_editorial = 1 
                ORDER BY post.post_date DESC 
                LIMIT 3";

        $result = mysqli_query($conn, $sql) or die("Query Failed");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-sm-4" style="display: flex;">
            <div class="panel panel-default" style="display: flex; flex-direction: column; height: 100%; width: 100%;">
                
                <img src="admin/upload/<?php echo $row['post_img']; ?>" 
                     class="img-responsive" 
                     style="height: 180px; width: 100%; object-fit: cover; border-bottom: 1px solid #ccc;" 
                     alt="Editorial Image">

                <div class="panel-body" >

                    <h4 style="margin: 10px 0; font-size: 16px; font-weight: bold; line-height: 1.5; overflow: hidden; white-space: wrap; text-overflow:ellipsis ; color:#1e90ff">
                        <?php echo $row['title']; ?>
                    </h4>

                    <!-- Description -->
                    <p class="text-justify" style="flex-grow: 1; margin-bottom: 10px;">
                        <?php echo substr($row['description'], 0, 100) . "..."; ?>
                    </p>

                    <!-- Read More Button -->
                    <a href="single.php?id=<?php echo $row['post_id']; ?>" 
                       class="btn btn-primary btn-xs pull-right" 
                       style="margin-top: auto;">
                        Read More
                    </a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-md-12'><p>No Editorial Picks Found.</p></div>";
        }
        ?>
    </div>
</div>
