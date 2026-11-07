<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "voting");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {

    $role     = $_POST['role'];
    $username = trim($_POST['student_id']);
    $password = $_POST['password'];

    if ($role === "student") {
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM voters WHERE student_id='$username'";
    } else {
        // Admin login using email
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM admins WHERE email='$username'";
    }

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {

        $user = mysqli_fetch_assoc($result);

        // Password verification (HASHED PASSWORDS)
        if (password_verify($password, $user['password'])) {

            session_regenerate_id(true); // security

            $_SESSION['role'] = $role;
            $_SESSION['id']   = $user['id'];

            if ($role === "student") {
                $_SESSION['student_id'] = $user['student_id'];
                $_SESSION['name']       = $user['name'];

                header("Location: student_dashboard.php");
            } else {
                $_SESSION['email'] = $user['email'];

                header("Location: admin/admin_dashboard.php");
            }
            exit();

        } else {
            echo "<script>
                alert('Invalid password');
                window.location.href='login.php';
            </script>";
        }

    } else {
        echo "<script>
            alert('User not found');
            window.location.href='login.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
    <h2>College Voting System Login</h2>

    <form method="POST">
        <label>Login as:</label>
        <select name="role" required>
            <option value="student">🎓 Student Login</option>
            <option value="admin">🛡️ Admin Login</option>
        </select>

        <input type="text" name="student_id"
               placeholder="Student ID / Admin Email" required>

        <input type="password" name="password"
               placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p class="extra-link">
        Don’t have a student account?
        <a href="register.php">Register here</a>
    </p>
</div>

</body>
</html>
