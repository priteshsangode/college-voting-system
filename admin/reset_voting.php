<?php
include('../includes/db.php');

//Delete all the candiates
$query= "DELETE FROM posts";
$result = $conn->query($query);

$query= "UPDATE voters SET status='NO'";
$result = $conn->query($query);

if ($result) {
    echo "<script>
            alert('Voting Reset Successfully!');
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
