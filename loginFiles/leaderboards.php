<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
if ($_SESSION['lb'] ==null)
{
	require('getLead.php');
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EPIC Hero Challenges</title>

    <!-- Link to bootstrap file -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="SigninDIV.css" rel="stylesheet" type="text/css">
  </head>

  <body class="modal-header">

    <!-- Navigation Bar -->
 <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light"><a class="navbar-brand" href="#">EPIC Hero Challenges</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent1">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active"> <a class="nav-link" href="choicePage.php">Home <span class="sr-only">(current)</span></a> </li>
		<li class="nav-item active"> <a class="nav-link" href="dailyPage.php">Daily Matchup <span class="sr-only">(current)</span></a> </li>
		<li class="nav-item active"> <a class="nav-link" href="leaderboards.php">Leaderboards <span class="sr-only">(current)</span></a> </li>
		<li class="nav-item active"> <a class="nav-link" href="tutorial.php">Tutorial <span class="sr-only">(current)</span></a> </li>
	  <li class="nav-item active"> <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a> </li>
    </ul>
  </div>
</nav>

<html>
	
<h1>Leaderboard</h1>

<body>
<div id="textResponse">
View Leaderboard Below
<p></p>

<a href="choicePage.php"><button>Home Page</button></a>
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<?php
foreach ($_SESSION['lb']['leaderboard'] as $user)
{
	echo $user['userName'];
	echo " ";
	echo $user['points'];
	echo '<br>';
}
?>
</body>
