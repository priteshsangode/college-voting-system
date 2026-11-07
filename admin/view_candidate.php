<?php
include('../includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Candidates</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<h3 class="text-center text-decoration-underline">
    Registered Candidates
</h3>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Candidate Name</th>
            <th>Candidate Image</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $sno = 1;
        $query = "SELECT * FROM posts";
        $result = $conn->query($query);   

        if ($result && $result->num_rows > 0) {
            while ($post = $result->fetch_assoc()) {
                $isActive=$post['active'];
        ?>
                <tr>
                    <td style="vertical-align: middle;"><?php echo $sno++; ?></td>
                    <td style="vertical-align: middle;"><?php echo $post['candidate_name']; ?></td>
                    <td class="text-center">
                        <img src="../images/<?php echo $post['candidate_image']; ?>"
                             width="80">
                    </td>
                    <td style="vertical-align: middle;">
                        <a href="delete_candidate.php?post_id=<?php echo $post['post_id']; ?>"
                          class="btn btn-danger btn-sm"
                         onclick="return confirm('Are you sure you want to delete this candidate? This action cannot be undone!')">
                         🗑️ Delete
                       </a>

                        <a href="block_unblock.php?post_id=<?php echo $post['post_id']; ?>&active=<?php echo $post['active']; ?>"
                        class="btn btn-secondary btn-sm"
                        onclick="return confirm('Are you sure you want to change status?')">
                        <?php echo $isActive ? '🚫 Block' : '✅ Unblock'; ?>
                        </a>

                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No Records Found</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
