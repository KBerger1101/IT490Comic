<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
echo "Welcome ".$_SESSION['username'];
echo "<br>";
echo "Tokens available to bet: ". $_SESSION['tokens'].PHP_EOL;
?>
<html>
<h1>Options</h1>
<body>

<div id="textResponse">
if you see this you should see options
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<form action="/loginFiles/dailyPage.php">
<button type="submit" >View Daily Matchup</button>
</form>
<form action="/loginFiles/leaderboards.php">
<button type="submit" >View Leaderboards</button>
</form>
<form action="/loginFiles/prevMatchups.php">
<button type="submit" >View Previous Matchups</button>
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




</body>
</html>

