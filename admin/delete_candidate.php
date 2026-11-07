<?php
include('../includes/db.php');

$post_id  = $_GET['post_id'];

$query= "DELETE FROM posts WHERE post_id=$post_id";
$result = $conn->query($query);

if ($result) {
    echo "<script>
            alert('Active Status Updated Successfully!');
            window.location.href = 'admin_dashboard.php';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Try again...');
            window.location.href = 'admin_dashboard.php';
          </script>";
}
?>
