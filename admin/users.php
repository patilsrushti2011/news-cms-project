<?php include "header.php"; 
 if($_SESSION['user_role']==0)
 {
    header("Location: http://localhost/news-cms/admin/post.php");
 }
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
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
               $serial= $offset+1;
                include "config.php";
                $sql = "select * from user order by user_id desc limit {$offset},{$limit}";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)) {

                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class='id'><?php echo $serial ?>  </td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td> <?php
                                            if ($row['role'] == 1) {
                                                echo "Admin";
                                            } else {
                                                echo "Normal";
                                            } ?></td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                                
                            <?php
                            $serial++;
                         }
                            
                            ?>
                        </tbody>
                        </table>
                    <?php
                }
                $sql1="select * from user";
                $result1=mysqli_query($conn,$sql1) or die("Query Failed");
                if(mysqli_num_rows($result1)){
                    
                $totalrecords=mysqli_num_rows($result1);
                $totalpage=ceil( $totalrecords/$limit);
                echo "<ul class='pagination admin-pagination'>";
                if($page>1){
                echo '<li><a href="users.php?page='.($page-1).'">Prev</a></li>';}
                for($i=1;$i<=$totalpage;$i++)
                {
                    if($page==$i){
                        $active="active";
                    }else{
                        $active="";
                    }
                    echo '<li class="'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                   
                }
                if($page < $totalpage){
                echo '<li><a href="users.php?page='.($page+1).'">Next</a></li>';}
                echo"</ul>";
              }  
              ?>
                     <!-- <li class="active"><a>1</a></li> -->
            </div>
        </div>
    </div>
</div>