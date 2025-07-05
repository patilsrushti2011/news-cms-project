
<?php
$page = basename($_SERVER['PHP_SELF']);
include "config.php";

switch ($page) {
    case "single.php":
        if (isset($_GET['id'])) {
            $sql = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
            $result = mysqli_query($conn, $sql) or die("Title Query Failed");
            $row = mysqli_fetch_assoc($result);
            $page_title = $row['title'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "category.php":
        if (isset($_GET['cid'])) {
            $sql = "SELECT * FROM category WHERE category_id = {$_GET['cid']}";
            $result = mysqli_query($conn, $sql) or die("Title Query Failed");
            $row = mysqli_fetch_assoc($result);
            $page_title = $row['category_name'] . " News";
        } else {
            $page_title = "No Category Found";
        }
        break;
    case "search.php":
        $page_title = isset($_GET['search']) ? $_GET['search'] : "No Search Result Found";
        break;
    case "author.php":
        if (isset($_GET['aid'])) {
            $sql = "SELECT * FROM user WHERE user_id = {$_GET['aid']}";
            $result = mysqli_query($conn, $sql) or die("Title Query Failed");
            $row = mysqli_fetch_assoc($result);
            $page_title = "News By " . $row['first_name'] . " " . $row['last_name'];
        } else {
            $page_title = "No Author Found";
        }
        break;
    default:
        $page_title = "News Site";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
   
    <link rel="stylesheet" href="css/font-awesome.css">
    
    <link rel="stylesheet" href="css/style.css">

    <style>
       
    </style>
</head>
<body>

<!-- HEADER SECTION -->
<div id="header">
    <div class="container ">
        <div class="row" >
           
            <div class="col-sm-7 col-xs-12">
                <a href="index.php" id="logo">
                    <img src="images/news.jpg" alt="News Logo" >
                </a>
            </div>

            <!-- Search Box -->
            <div class="col-sm-5 col-xs-11">
                <form class="search-post" action="search.php" method="GET">
                    <div class="input-group" >
                        <input type="text" name="search" class="form-control" placeholder="Search ...." required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn search-btn"><i class="fa fa-search" style="color:white;font-size:2rem"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="category-bar-wrapper">
    <div class="container">
        <!-- Hamburger toggle on mobile -->
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#category-menu">
    <i class="fa fa-bars fa-lg"  style="color: white;"></i>
</button>


       
<div class="category-bar-wrapper">
  <div class="container">
<!-- Scrollable Category Menu -->
      <div class="collapse navbar-collapse category-bar" id="category-menu" >
        <ul>
          <li><a href="index.php">Home</a></li>
          <?php
          $cat_id = isset($_GET['cid']) ? $_GET['cid'] : '';
          $sql = "SELECT * FROM category WHERE post > 0";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $active = ($row['category_id'] == $cat_id) ? "active" : "";
                  echo "<li class='{$active}'><a href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
              }
          }
          ?>
        </ul>
      </div>

    </div>
  </div>
</div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>