<?php
session_start();

// LOGIN CHECK
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "voting");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="container">

<!-- ================= VOTER DETAILS ================= -->
<div class="card voter-card">
    <h2>Voter Details</h2>

    <?php
    $id = $_SESSION['id'];
    $query = "SELECT * FROM voters WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $voter = mysqli_fetch_assoc($result);
    ?>

    <p style="line-height:1.8;"><strong>Name:</strong> <?= $voter['name']; ?></p>
    <p style="line-height:1.8;"><strong>Student ID:</strong> <?= $voter['student_id']; ?></p>
    <p style="line-height:1.8;"><strong>Voting Status:</strong>
        <span class="status">
            <?= ($voter['status'] == 'NO') ? 'Not Voted' : 'Voted'; ?>
        </span>
    </p>

    <a href="logout.php"><button class="logout-btn">Logout</button></a>
</div>

<!-- ================= VOTING SECTION ================= -->
<div class="card voting-card">
    <h2>Voting Section</h2>

    <?php if ($voter['status'] == 'YES') { ?>
        <p style="color:red;">You have already voted.</p>
    <?php } else { ?>

    <form action="vote.php" method="POST">

        <?php
        // Fetch all posts and Where active=1 are used for when admin block the candidate , those candidate cannot show in stu-page
        $query = "SELECT * FROM posts WHERE active=1 ORDER BY post_name";
        $result = mysqli_query($conn, $query);

        $currentPost = "";
        while ($posts = mysqli_fetch_assoc($result)) {
            // If new post_name, print heading
            if ($currentPost != $posts['post_name']) {
                $currentPost = $posts['post_name'];
                echo "<h3>" . htmlspecialchars($currentPost) . "</h3>";
                echo "<p class='subtitle'>Select only one candidate</p>";
            }
        ?>
            <div class="candidate">
                <input type="radio" name="candidate_id" value="<?= $posts['post_id']; ?>" required>
                <img src="images/<?= $posts['candidate_image']; ?>" alt="candidate">
                <h4><?= $posts['candidate_name']; ?></h4>
            </div>
        <?php } ?>

        <button type="submit" name="vote" class="vote-btn" onclick="return confirm('⚠️ Are you sure you want to cast your vote?\nOnce submitted, it cannot be changed.?');">Vote</button>

    </form>
    <?php } ?>

</div>

</div>
</body>
</html>
