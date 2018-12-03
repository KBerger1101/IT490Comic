<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
if ($_SESSION['heroData'] == null)
{
	require('getDaily.php');
	#$heroData= $_SESSION['heroData'];
}
?>

<html>
<head>
<style>
.img {
width:300px;
height: auto;
}
</style>
</head>
<body>
<div style="width:800px;">
<?php
if($_SESSION['hasVoted'])
{
        echo "<p>You have voted today!</p>";
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
		<li class="nav-item active"> <a class="nav-link" href="dailyPage.php">Leaderboards <span class="sr-only">(current)</span></a> </li>
		<li class="nav-item active"> <a class="nav-link" href="tutorial.php">Tutorial <span class="sr-only">(current)</span></a> </li>
	  <li class="nav-item active"> <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a> </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
    
<div id="textResponse">
  if you see this you should see matchup, vote below
  <a href="choicePage.php"><button>Home Page</button></a>
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<form action='vote.php' method="POST">
<input type="radio" name="vote" value="DC">Vote DC<br>
<input type="radio" name="vote" value="Marvel">Vote Marvel<br>
<button>Submit Vote</button>
<span style="width: auto; float: left;">
<?php


$dcPrint= "";
for ($i =0 ; $i <5; $i ++){
	$dcPrint.= "<h3>".$_SESSION['heroData']['DC'][$i]['charName']."</h3>";
$dcPrint.= "<br><img class='img' src= ".$_SESSION['heroData']['DC'][$i]['imgURL'].">";
$dcPrint.="<br>";

#echo $_SESSION['heroData']['DC'][0]['charName'];
#echo "<img src =".$_SESSION['heroData']['DC'][0]['imgURL'].">";
#echo '<br>';
foreach ($_SESSION['heroData']['DC'][$i]["powers"] as $power)
{
	$dcPrint.=$power['powerDesc'];
	$dcPrint.="<br>";
	#echo $power['powerDesc'];
	#echo '<br>';
}
}
echo "<h1> Team DC</h1>";
echo $dcPrint;
?>
</span><span style="width:300px; float:right">
<?php
$marPrint= "";
for ($i =0 ; $i <5; $i ++){
$marPrint.="<h3>". $_SESSION['heroData']['Marvel'][$i]['charName']."</h3>";
$marPrint.= "<br><img class='img' src= ".$_SESSION['heroData']['Marvel'][$i]['imgURL'].">";
$marPrint.= "<br>";
foreach ($_SESSION['heroData']['Marvel'][$i]["powers"] as $power)
{
        $marPrint.= $power['powerDesc'];
        $marPrint.="<br>";
        #echo $power['powerDesc'];
        #echo '<br>';
}
}
#echo $_SESSION['heroData']['Marvel'][0]['charName'];
#echo "<img src =".$_SESSION['heroData']['Marvel'][0]['imgURL'].">";
#echo '<br>';
echo "<h1>Team Marvel</h1>";
echo $marPrint;
?>
</span>

</form>
</div>
<!--<div id="textResponse">
if you see this you should see matchup, vote below
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<form action='vote.php' method="POST">
<input type="radio" name="vote" value="DC">Vote DC<br>
<input type="radio" name="vote" value="Marvel">Vote Marvel<br>
<button>Submit Vote</button>
</form>-->
</body>
<div style="float:left;">
<p> Thank you to ComicVine.com for supplying the information for the fight!</p></div>
</html>

