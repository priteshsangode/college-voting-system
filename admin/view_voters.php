<?php
include('../includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Voters</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<h3 class="text-center text-decoration-underline p-3">
    Registered Voters
</h3>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>S.No</th>
            <th>Student Name</th>
            <th>Student ID</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $sno = 1;
        $query = "SELECT * FROM voters";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($voter = $result->fetch_assoc()) {
                $isActive =$voter['active'];
        ?>
                <tr class="align-middle">
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $voter['name']; ?></td>
                    <td><?php echo $voter['student_id']; ?></td>
                    <td>
                        <a href="delete_voter.php?id=<?php echo $voter['id']; ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Are you sure you want to delete this voter?')">
                         🗑️ Delete
                        </a>

                        <!-- <a href="#" class="btn btn-primary btn-sm">Edit</a> -->
                        
                        <a href="block_unblock_voter.php?id=<?php echo $voter['id']; ?>&active=<?php echo $voter['active']; ?>"
       class="btn btn-success btn-sm"
       onclick="return confirm('Are you sure you want to change voter status?')">
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
