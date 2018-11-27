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
<h1>matchup</h1>
<body>
<div style="width:800px;">

<div id="textResponse">
if you see this you should see matchup, vote below
<a href="choicePage.php"><button>Home Page</button></a>
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<form action='vote.php' method="POST">
<input type="radio" name="vote" value="DC">Vote DC<br>
<input type="radio" name="vote" value="Marvel">Vote Marvel<br>
<button>Submit Vote</button>

</form>


<div style="width:300px; float:left;" >
<?php
$mixPrint= "";
for ($i = 0; $i <5; $i ++){
	$mixPrint.="<h3>".$_SESSION['heroData']['Mix'][$i]['charName']."</h3>";
	$mixPrint.= "<br><img class='img' src= ".$_SESSION['heroData']['Mix'][$i]['imgURL'].">";
	$mixPrint.="<br>";
	foreach ($_SESSION['heroData']['Mix'][$i]["powers"] as $power)
	{
		$mixPrint.=$power['powerDesc'];
		$mixPrint.="<br>";
	}
}

echo "<h1>Team Mix</h1>";
echo $mixPrint;

$dcPrint= "";
for ($i =0 ; $i <5; $i ++){
	$dcPrint.= "<h3>".$_SESSION['heroData']['DC'][$i]['charName']."</h3>";
$dcPrint.= "<br><img class='img' src= ".$_SESSION['heroData']['DC'][$i]['imgURL'].">";
$dcPrint.="<br>";

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
</div>
<div style="width:300px; float:right">
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
</div>
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


