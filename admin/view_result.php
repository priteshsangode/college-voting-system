<?php
include('../includes/db.php');

// count total votes
$query = "SELECT SUM(total_votes) AS total_voter FROM posts";
$result = $conn->query($query);
$post = $result->fetch_assoc();
$total_voters = $post['total_voter'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote Result</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">

<div class="container-fluid mt-4">
    <div class="row">

        <!-- LEFT SIDE CONTENT -->
        <div class="col-md-8">

            <!-- TOTAL VOTES CARD -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title text-primary">
                        🗳 Total Votes Cast: <?php echo $total_voters; ?>
                    </h4>
                </div>
            </div>

            <!-- WINNER CARD -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    Highest Vote
                </div>
                <div class="card-body">
                    <?php
                    $query = "SELECT candidate_name, total_votes 
                              FROM posts 
                              WHERE total_votes = (SELECT MAX(total_votes) FROM posts)";
                    $result = $conn->query($query);

                    while ($post = $result->fetch_assoc()) {
                    ?>
                        <h5>
                            🏆 <?php echo $post['candidate_name']; ?>
                            <span class="badge bg-success">
                                <?php echo $post['total_votes']; ?> votes
                            </span>
                        </h5>
                    <?php } ?>
                </div>
            </div>

            <!-- RESULT TABLE -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    All Candidates Result
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0 text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>S.No</th>
                                <th>Candidate Name</th>
                                <th>Total Votes</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sno = 1;
                        $query = "SELECT candidate_name, total_votes FROM posts";
                        $result = $conn->query($query);

                        while ($post = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $post['candidate_name']; ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?php echo $post['total_votes']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
