<?php include "header.php";
if($_SESSION['user_role']==0)
{
   header("Location: http://localhost/news-cms/admin/post.php");
}
$cat_id= $_GET['cid'];

if(isset($_POST['sumbit'])){
  include "config.php";
  $categoryid=mysqli_real_escape_string($conn,$_GET['cid']);
  $category_name= mysqli_real_escape_string($conn,$_POST['cat_name']);
  $sql1="update category set category_name='{$category_name}' where category_id='{$categoryid}'";
  $result=mysqli_query($conn,$sql1) or die("Query failed");
  header("Location: http://localhost/news-cms/admin/category.php");
  mysqli_close($conn);
 
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">  
                <?php
                include "config.php";
                $sql = "select * from category where category_id='{$cat_id}'";
                $result = mysqli_query($conn, $sql) or die("Query failed");
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" class="general-form" >
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="{$cat_id}" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']; ?> "  placeholder="" required>
                      </div>
                      <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                  </form>
                 <?php
                    }
                }
                    ?>
                </div>
              </div>
            </div>
          </div>

