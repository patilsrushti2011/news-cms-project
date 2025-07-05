<?php include "header.php";
if(isset($_POST['save']))
{
    include 'config.php';
    $category_name=mysqli_real_escape_string($conn,$_POST['cat']);


        $sql1="insert into category(category_name) values('{$category_name}')";   
        $result1=mysqli_query($conn,$sql1);//to execute query
        if($result1)
        {
            header("Location: http://localhost/news-cms/admin/category.php");
        }
        mysqli_close($conn);
    }



?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" class="general-form" >
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
               
            </div>
        </div>
    </div>
</div>
