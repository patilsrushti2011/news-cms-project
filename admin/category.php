<?php

use PSpell\Config;

 include "header.php";
if ($_SESSION['user_role'] == 0) {
    header("Location: http://localhost/news-cms/admin/post.php");
} ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                       
                            <?php
                            include "config.php";
                            $limit=5;
                            //    $page=$_GET['page'];
                            if(isset($_GET['page'])){
                                $page=$_GET['page'];
                               }else{
                                $page=1;
                               }
                             
                               $offset=($page-1)*  $limit;
                            $serial=$offset+1;


                            $sql = "select * from category order by category_id limit {$offset},{$limit}";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result))
                             { 
                                while($row=mysqli_fetch_assoc($result))
                                {
                            ?>
                            <tr>
                            <td class='id'><?php echo $serial ?></td>
                            <td><?php echo $row['category_name'] ?></td>
                            <td><?php echo $row['post'] ?></td>
                            <td class='edit'><a href='update-category.php?cid=<?php echo $row['category_id']; ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?cid=<?php echo $row['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php
                        $serial++;
                                  }
                                }
                            ?>
                    </tbody>
                </table>
              

                <?php
                
                $sql1="select * from category";
                $result1=mysqli_query($conn,$sql1) or die("Query Failed");
                if(mysqli_num_rows($result1)){
               
                $totalrecords=mysqli_num_rows($result1);
                $totalpage=ceil( $totalrecords/$limit);
                echo "<ul class='pagination admin-pagination'>";
                if($page>1){
                echo '<li><a href="category.php?page='.($page-1).'">Prev</a></li>';}
                for($i=1;$i<=$totalpage;$i++)
                {
                    if($page==$i){
                        $active="active";
                    }else{
                        $active="";
                    }
                    echo '<li class="'.$active.'"><a href="category.php?page='.$i.'">'.$i.'</a></li>';
                   
                }
                if($page < $totalpage){
                echo '<li><a href="category.php?page='.($page+1).'">Next</a></li>';}
                echo"</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
