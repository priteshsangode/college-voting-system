<?php
include('../includes/db.php');

$post_id  = $_GET['post_id'];
$isActive = $_GET['active'];

// Toggle status
if ($isActive == 1) {
    $query = "UPDATE posts SET active = 0 WHERE post_id = $post_id";
} else {
    $query = "UPDATE posts SET active = 1 WHERE post_id = $post_id";
}

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
