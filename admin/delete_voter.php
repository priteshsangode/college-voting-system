<?php
include('../includes/db.php');

$id  = $_GET['id'];

$query= "DELETE FROM voters WHERE id=$id";
$result = $conn->query($query);

if ($result) {
    echo "<script>
            alert('Voter Deleted Successfully!');
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
