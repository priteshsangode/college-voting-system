<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "voting");
if (!$conn) {
    die("Connection failed");
}

if (isset($_POST['vote'])) {

    $voter_id = $_SESSION['id'];
    $candidate_id = $_POST['candidate_id'];

    // 🔐 Check voter status & active
    $check = mysqli_query($conn, "SELECT status, active FROM voters WHERE id='$voter_id'");
    $voter = mysqli_fetch_assoc($check);

    // 🚫 If voter is blocked

    if ($voter['active'] == 0) {
        echo "<script>
                alert('Your account has been blocked by Admin. You cannot vote.');
                window.location='student_dashboard.php';
              </script>";
        exit();
    }

    // 🚫 If already voted
    if ($voter['status'] == 'YES') {
        echo "<script>
                alert('You already voted');
                window.location='student_dashboard.php';
              </script>";
        exit();
    }

    // ✅ Increase vote count
    mysqli_query($conn, "UPDATE posts SET total_votes = total_votes + 1 WHERE post_id='$candidate_id'");

    // ✅ Update voter status
    mysqli_query($conn, "UPDATE voters SET status='YES' WHERE id='$voter_id'");

    echo "<script>
            alert('Vote Cast Successfully');
            window.location='student_dashboard.php';
          </script>";
}
?>
