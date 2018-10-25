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
</style>
</head>
<h1>matchup</h1>
<body>

<div>
<?php

$dcPrint= "";
for ($i =0 ; $i <5; $i ++){
$dcPrint.= $_SESSION['heroData']['DC'][$i]['charName'];
$dcPrint.= "<br><img src= ".$_SESSION['heroData']['DC'][$i]['imgURL'].">";
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
echo $dcPrint;
?>
</div>
<div>
<?php
$marPrint= "";
for ($i =0 ; $i <5; $i ++){
$marPrint.= $_SESSION['heroData']['Marvel'][$i]['charName'];
$marPrint.= "<br><img src= ".$_SESSION['heroData']['Marvel'][$i]['imgURL'].">";
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
echo $marPrint;
?>
</div>
<div id="textResponse">
if you see this you should see matchup, vote below
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<form action='vote.php' method="POST">
<input type="radio" name="vote" value="DC">Vote DC<br>
<input type="radio" name="vote" value="Marvel">Vote Marvel<br>
<button>Submit Vote</button>

</form>
</body>
</html>


