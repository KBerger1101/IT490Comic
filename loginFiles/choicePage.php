<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
?>
<html>
<h1>What would you like to do?</h1>
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
<body style="padding-top: 70px">
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
<div id="textResponse">
  if you see this you should see options
  <a href="logout.php"></a>
</div>
<?php
echo "Welcome ".$_SESSION['username'];
echo "<br>";
echo "Current score: ". $_SESSION['points'].PHP_EOL;
echo "<br>";
echo "Tokens available to bet: ". $_SESSION['tokens'].PHP_EOL;
?>

<form action="/loginFiles/dailyPage.php">
<button type="submit" >View Daily Matchup</button>
</form>
<form action="/loginFiles/leaderboards.php">
<button type="submit" >View Leaderboards</button>
</form>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="A5WKKT26Q7M64">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="BettingTokens">
<input type="hidden" name="item_number" value="bettingTokens">
<input type="hidden" name="amount" value="0.01">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="rm" value="1">
<input type="hidden" name="return" value="http://localhost/loginFiles/callback.php">
<input type="hidden" name="cancel_return" value="http://localhost/loginFiles/choicePage.php">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHosted">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<form action="/loginFiles/tutorial.php">
<button type="submit" >View Tutorial</button>
</form>


<a href="logout.php">
<button>Logout</button>
</a>
<script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="js/popper.min.js" type="text/javascript"></script>
</body>
</html>

