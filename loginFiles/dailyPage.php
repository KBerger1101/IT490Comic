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
<h1>matchup</h1>
<body>
<?php
echo $_SESSION['heroData']['DC'][0]['charName'];
echo "<img src =".$_SESSION['heroData']['DC'][0]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['DC'][0]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}

echo $_SESSION['heroData']['DC'][1]['charName'];
echo "<img src =".$_SESSION['heroData']['DC'][1]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['DC'][1]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}

echo $_SESSION['heroData']['DC'][2]['charName'];
echo "<img src =".$_SESSION['heroData']['DC'][2]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['DC'][2]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}
echo $_SESSION['heroData']['DC'][3]['charName'];
echo "<img src =".$_SESSION['heroData']['DC'][3]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['DC'][3]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}
echo $_SESSION['heroData']['DC'][4]['charName'];
echo "<img src =".$_SESSION['heroData']['DC'][4]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['DC'][4]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}
echo $_SESSION['heroData']['Marvel'][0]['charName'];
echo "<img src =".$_SESSION['heroData']['Marvel'][0]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['Marvel'][0]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}

echo $_SESSION['heroData']['Marvel'][1]['charName'];
echo "<img src =".$_SESSION['heroData']['Marvel'][1]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['Marvel'][1]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}

echo $_SESSION['heroData']['Marvel'][2]['charName'];
echo "<img src =".$_SESSION['heroData']['Marvel'][2]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['Marvel'][2]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}
echo $_SESSION['heroData']['Marvel'][3]['charName'];
echo "<img src =".$_SESSION['heroData']['Marvel'][3]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['Marvel'][3]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';

}
echo $_SESSION['heroData']['Marvel'][4]['charName'];
echo "<img src =".$_SESSION['heroData']['Marvel'][4]['imgURL'].">";
echo '<br>';

foreach ($_SESSION['heroData']['Marvel'][4]["powers"] as $power)
{
	echo $power['powerDesc'];
	echo '<br>';
}

?>
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


