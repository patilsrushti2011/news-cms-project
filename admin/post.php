<?php include "header.php"; 
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
              <?php
               
                  
               
               $limit=5;
            //    $page=$_GET['page'];
            if(isset($_GET['page'])){
                $page=$_GET['page'];
               

               }else{
                $page=1;
              
               }
      
               $offset=($page-1)*  $limit;
               $serial=$offset+1;
            //    echo $serial;
            //    die();
                include "config.php";
                if($_SESSION['user_role']=='1')
                {
                $sql = "select * from post 
                left join category on post.category=category.category_id
                 left join user on post.author=user.user_id 
                 order by post.post_id desc limit {$offset},{$limit}";}
                 elseif($_SESSION['user_role']=='0'){
                 $sql = "select * from post 
                 left join category on post.category=category.category_id
                 left join user on post.author=user.user_id 
                 where post.author={$_SESSION['userid']}
                 order by post.post_id desc limit {$offset},{$limit}";

                 }
                 
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)) 
                 {
                
                     
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                    
                      
                
                      <tbody>
                      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                          <tr>
                              <td class='id'><?php echo $serial ?></td>
                              <td><?php echo $row['title'] ?></td>
                              <td><?php echo $row['category_name'] ?></td>
                              <td><?php echo $row['post_date'] ?></td>
                              <td><?php echo $row['username']?></td>
                              <td class='edit'><a href='update-post.php?pid=<?php echo $row['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?cat_id=<?php echo $row['category_id'];?>&pid=<?php echo $row['post_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          $serial++;
                      } ?>
                      </tbody>
                  </table>
                  <?php
                      }
                   
                 if($_SESSION['user_role']==0)
                  {
                       $sql1="SELECT * from post join user ON post.author = user.user_id where user.role = 0";
                   }
                   else{
                    $sql1="select * from post ";
                   }
                 
                $result1=mysqli_query($conn,$sql1) or die("Query Failed");
                if(mysqli_num_rows($result1)){
                    
                $totalrecords=mysqli_num_rows($result1);
                $totalpage=ceil( $totalrecords/$limit);
                echo "<ul class='pagination admin-pagination'>";
                if($page>1){
                echo '<li><a href="post.php?page='.($page-1).'">Prev</a></li>';}
                for($i=1;$i<=$totalpage;$i++)
                {
                    if($page==$i){
                        $active="active";
                    }
                    else{
                        $active="";
                    }
                    echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                   
                }
                if($page < $totalpage){
                echo '<li><a href="post.php?page='.($page+1).'">Next</a></li>';}
                echo"</ul>";
              }   
              
                 ?>
                  
              </div>
          </div>
      </div>
  </div>

