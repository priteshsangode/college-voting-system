<?php
include('../includes/db.php');

$id  = $_GET['id'];
$isActive = $_GET['active'];

// Toggle status
if ($isActive == 1) {
    $query = "UPDATE voters SET active = 0 WHERE id = $id";
} else {
    $query = "UPDATE voters SET active = 1 WHERE id = $id";
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
