<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
require('getDaily.php');
?>

<html>
<h1>matchup</h1>
<body>
<?php
#print_r($sessionData);
echo $sessionData['DC'][0]['charName'];
echo "<img src =".$sessionData['DC'][0]['imgURL'].">";
echo $_SESSION['heroData'];
?>
<div id="textResponse">
if you see this you should see matchup, vote below
<a href="logout.php"><button>LOGOUT</button></a>
</div>
</body>
</html>


