<?php
include('../includes/db.php');
$total_reg_voters= 0;
$total_reg_candidates=0;
$total_reg_voters= 0;
$total_act_candidates=0;

//get total registered voter
$query = "SELECT COUNT(*) AS total_reg_voters FROM voters";
$result = $conn->query($query); 
$voter = $result->fetch_assoc();
$total_reg_voters=$voter['total_reg_voters'];

// Get Toatal active voter
$query = "SELECT COUNT(*) AS total_act_voters FROM voters WHERE active=1";
$result = $conn->query($query); 
$voter = $result->fetch_assoc();
$total_act_voters=$voter['total_act_voters'];

// Get total registed Candidate
$query = "SELECT COUNT(*) AS total_reg_candidates FROM posts";
$result = $conn->query($query); 
$post = $result->fetch_assoc();
$total_reg_candidates=$post['total_reg_candidates'];

// Get total active Candidate
$query = "SELECT COUNT(*) AS total_act_candidates FROM posts WHERE active=1";
$result = $conn->query($query); 
$post = $result->fetch_assoc();
$total_act_candidates=$post['total_act_candidates'];

// Get total votes cast today
$query = "SELECT COUNT(*) AS today_votes 
          FROM voters
          WHERE status='YES'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$today_votes = $row['today_votes'];



?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap-grid.min.css">

  <!-- Global Styles -->
  <link rel="stylesheet" href="../css/style.css">

  <!-- Admin Dashboard Styles (load last so it overrides others) -->
  <link rel="stylesheet" href="../css/admin_dash_style.css">

  <!-- jQuery and Bootstrap JS -->
  <script src="../includes/jquery.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>


    
</head>
<body>

<div class="page-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="menu-title">Menu</h2>

        <a href="#" class="menu-btn" id="dashboard">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>

        <a href="../register.php" class="menu-btn" id="add_candidates">
            <i class="fa-solid fa-user-plus"></i> Add Candidates
        </a>

        <a href="#" id="view_candidates" class="menu-btn">
            <i class="fa-solid fa-users"></i> View Candidates
        </a>

        <a href="#" id="view_voters" class="menu-btn">
            <i class="fa-solid fa-user"></i> View Voters
        </a>

        <a href="#" id="view_result" class="menu-btn">
            <i class="fa-solid fa-chart-bar"></i> View Result
        </a>

        <div class="bottom-buttons">
            <a href="reset_voting.php" class="reset-btn"
            onclick="return confirm('⚠️ Are you sure you want to reset voting?');">
                <i class="fa-solid fa-rotate"></i> Reset Voting
            </a>

            <a href="../logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="right-side">
        <h1>Admin Dashboard</h1>
        <p>Welcome Admin! Use the menu to manage the system.</p>


        <!-- Dashboard Cards -->
<div class="dashboard-cards">

    <div class="dash-card blue">
        <div class="card-text">
            <p>Total Voters</p>
            <h2><?php echo $total_reg_voters; ?></h2>
        </div>
        <div class="card-icon">
            <i class="fa-solid fa-chart-line"></i>
        </div>
    </div>

    <div class="dash-card green">
        <div class="card-text">
            <p>Active Voters</p>
            <h2><?php echo $total_act_voters; ?></h2>
        </div>
        <div class="card-icon">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="dash-card orange">
        <div class="card-text">
            <p>Total Candidates</p>
            <h2><?php echo $total_reg_candidates; ?></h2>
        </div>
        <div class="card-icon">
            <i class="fa-solid fa-id-badge"></i>
        </div>
    </div>

    <div class="dash-card purple">
        <div class="card-text">
            <p>Active Candidates</p>
            <h2><?php echo $total_act_candidates; ?></h2>
        </div>
        <div class="card-icon">
            <i class="fa-solid fa-chart-column"></i>
        </div>
    </div>

    <div class="dash-card coral">
       <div class="card-text">
          <p>Today Vote Cast</p>
          <h2><?php echo $today_votes; ?></h2>
        </div>
       <div class="card-icon">
         <i class="fa-solid fa-check-to-slot"></i>
        </div>
    </div>


</div>
 </div>

</div>

</body>
</html>


<script>
$(document).ready(function(){

    // $("#add_candidates").click(function(e){
    //     e.preventDefault();
    //     $("#right-side").load("../register.php");
    // });

    $("#view_candidates").click(function(e){
        e.preventDefault();
        $("#right-side").load("view_candidate.php");
    });

    $("#view_voters").click(function(e){
        e.preventDefault();
        $("#right-side").load("view_voters.php");
    });

    $("#view_result").click(function(e){
        e.preventDefault();
        $("#right-side").load("view_result.php");
    });

    // Dashboard click → reload page
    $("#dashboard").click(function(e){
        e.preventDefault();
        location.reload();
    });

});
</script>
