<?php
include "admin/config.php"; // adjust path if needed

$sql      = "SELECT about, email, phone FROM site_settings ORDER BY id DESC LIMIT 1";
$result   = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);


$cat_sql    = "SELECT category_id, category_name FROM category ORDER BY post DESC LIMIT 6";
$cat_result = mysqli_query($conn, $cat_sql);
?>

<footer class="footer  main-footer">
  <div class="container">

    <!-- About on mobile only  -->
    <div class="row visible-xs-block">
      <div class="col-xs-12" style="margin-bottom:30px;">
        <h4>About NewsPortal</h4>
        <p><?php echo htmlspecialchars($settings['about']); ?></p>
        <hr style="border-color:#555;">
      </div>
    </div>

    <div class="row" id="footer-section">

      <!-- About hidden on mobile -->
      <div class="col-xs-12 col-sm-4 hidden-xs">
        <h4>About NewsPortal</h4>
        <p><?php echo htmlspecialchars($settings['about']); ?></p>
      </div>

      <!-- Categories -->
      <div class="col-xs-12 col-sm-4" style="margin-bottom:20px; text-align:center;">
        <h4>Top Categories</h4>
        <ul class="list-unstyled" >
          <?php if (mysqli_num_rows($cat_result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($cat_result)): ?>
              <li>
                <a href="category.php?cid=<?php echo $row['category_id']; ?>">
                  <?php echo htmlspecialchars($row['category_name']); ?>
                </a>
              </li>
            <?php endwhile; ?>
          <?php else: ?>
            <li>No categories found.</li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-xs-12 col-sm-4" style="margin-bottom:20px;">
        <h4>Contact Us</h4>
        <p style=" margin:10px 0 5px;">
          Email: <a href="mailto:<?php echo htmlspecialchars($settings['email']); ?>"
                    style="color:#eee;"><?php echo htmlspecialchars($settings['email']); ?></a>
        </p>
        <p style=" margin-bottom:15px; color:#eee;">
        Phone:<?php echo htmlspecialchars($settings['phone']); ?>
        </p>
        <div id="social-icons">
          <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
          <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
          <a href="#"><i class="fa fa-instagram fa-lg"></i></a>
        </div>
      </div>

    </div> 

    <hr style="border-color:#777; margin-top:30px;">

    <div class="text-center" style="font-size:14px; margin-top:20px; font-weight:bold">
      &copy; <?php echo date("Y"); ?> NewsPortal. All rights reserved.
    </div>

  </div> 
</footer>
