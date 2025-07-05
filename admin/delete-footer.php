<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $check_sql = "SELECT * FROM site_settings WHERE id = {$id}";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $sql = "DELETE FROM site_settings WHERE id = {$id}";
        mysqli_query($conn, $sql) or die("Delete query failed");

        header("Location: http://localhost/news-cms/admin/footer.php"); 
        exit;
    } else {
        echo "<p>Footer entry not found.</p>";
    }
} else {
    echo "<p>Invalid Request</p>";
}
?>
