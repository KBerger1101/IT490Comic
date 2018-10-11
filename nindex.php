<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>

<?php
if( $SERVER['REQUEST_METHOD'] == 'POST') 
{
	if (isset($_POST['login']))
	{
		require 'loginFiles/loginRequest.php';
	}
	elseif (isset($_POST['register']))
	{
		require 'loginFiles/registerRequest.php';
	}
}


</html>
