<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['register'])) {

    $conn = mysqli_connect("localhost", "root", "", "voting");
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $role     = $_POST['role'];
    $name     = $_POST['name'];
    $mobile   = $_POST['mobile'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ================= VOTER =================
    if ($role === "voter") {

        $student_id = $_POST['student_id'];

        // check duplicate student id
        $check = "SELECT id FROM voters WHERE student_id='$student_id'";
        $res = mysqli_query($conn, $check);

        if (mysqli_num_rows($res) > 0) {
            echo "<script>alert('Student ID already registered!');history.back();</script>";
            exit();
        }

        $query = "INSERT INTO voters 
                  (student_id, name, mobile, password, status, active)
                  VALUES 
                  ('$student_id', '$name', '$mobile', '$password', 'NO', 1)";
    }

    // ================= NOMINATION =================
    else {

        $post_name = $_POST['post_name'];
        $candidate_image = "";

        if (!empty($_FILES['candidate_image']['name'])) {
            $target_dir = "images/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $candidate_image = time() . "_" . $_FILES['candidate_image']['name'];
            move_uploaded_file($_FILES['candidate_image']['tmp_name'],
                               $target_dir . $candidate_image);
        }

        $query = "INSERT INTO posts
                  (post_name, candidate_name, candidate_image, password, mobile_no, total_image, active)
                  VALUES
                  ('$post_name', '$name', '$candidate_image', '$password', '$mobile', 1, 1)";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration Successful!');window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
<h2>Register</h2>

<form method="POST" enctype="multipart/form-data" onsubmit="return validateform();">

<label>Register as:</label>
<select name="role" id="role" onchange="toggleFields()" required>
    <option value="voter">🗳️ Voter</option>
    <option value="nomination">📋 Nomination</option>
</select>

<!-- VOTER -->
<div id="voterFields">
    <input type="text" name="student_id" id="student_id"
           placeholder="Student ID (STU101)"
           oninput="this.value=this.value.toUpperCase()">
    <span id="studentIdError" class="form-text"></span>
</div>

<!-- COMMON -->
<input type="text" name="name" id="name" placeholder="Full Name" required>
<span id="nameError" class="form-text"></span>

<input type="text" name="mobile" id="mobile" placeholder="Mobile Number" required>
<span id="mobileError" class="form-text"></span>

<input type="password" name="password" id="password" placeholder="Password" required>
<span id="passwordError" class="form-text"></span>

<!-- NOMINATION -->
<div id="nominationFields" style="display:none;">
    <input type="text" name="post_name" placeholder="Post Name">
    <input type="file" name="candidate_image">
</div>

<button type="submit" name="register">Register</button>
</form>
    <p style="text-align:center;margin-top:15px;">
        Already registered? <a href="login.php">Login here</a>
    </p>

</div>

<script>
function toggleFields() {

    let role = document.getElementById("role").value;
    let student = document.getElementById("student_id");

    if (role === "voter") {
        document.getElementById("voterFields").style.display = "block";
        document.getElementById("nominationFields").style.display = "none";
        student.required = true;
        student.disabled = false;
    } else {
        document.getElementById("voterFields").style.display = "none";
        document.getElementById("nominationFields").style.display = "block";
        student.required = false;
        student.disabled = true;
        student.value = "";
        document.getElementById("studentIdError").innerText = "";
    }
}
</script>

<script>
function validateform() {

    let valid = true;
    let role = document.getElementById("role").value;

    // STUDENT ID → only voter
    if (role === "voter") {
        let sid = document.getElementById("student_id").value.trim();
        let regex = /^[A-Z]+[0-9]+$/;

        if (!regex.test(sid)) {
            document.getElementById("studentIdError").innerText =
                "Format: STU101 (CAPITAL letters + numbers)";
            valid = false;
        } else {
            document.getElementById("studentIdError").innerText = "";
        }
    }

    // NAME
    let name = document.getElementById("name").value.trim();
    if (!/^[a-zA-Z\s]+$/.test(name)) {
        document.getElementById("nameError").innerText = "Invalid name";
        valid = false;
    } else document.getElementById("nameError").innerText = "";

    // MOBILE
    let mobile = document.getElementById("mobile").value.trim();
    if (!/^[6-9][0-9]{9}$/.test(mobile)) {
        document.getElementById("mobileError").innerText = "Invalid mobile";
        valid = false;
    } else document.getElementById("mobileError").innerText = "";

    // PASSWORD
    let pass = document.getElementById("password").value;
    if (pass.length < 6) {
        document.getElementById("passwordError").innerText = "Min 6 characters";
        valid = false;
    } else document.getElementById("passwordError").innerText = "";

    return valid;
}
</script>

</body>
</html>
