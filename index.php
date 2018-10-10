<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>

    <div id = "output">
	    status<p>
    </div>
    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputName" class="sr-only">Username</label>
        <input type="username" id="inputName" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="submitLogin()">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
<script>
function submitLogin()
{

	var uname = document.getElementById("inputName").value;
	var pword = document.getElementById("inputPassword").value;	      
	//var response =
	sendLoginRequest(uname,pword);
	//var text = JSON.parse(response);
	//document.getElementById("output").innerHTML = "response: "+ text + "<p>";
	return 0;
}
function HandleLoginResponse(response)
{
	var text = response;
	//document.getElementById("output").innerHTML = "response: "+text+"<p>";
	if(text != false ){
		window.location="/loginFiles/successPage.html";
	}
	else{
	document.getElementById("output").innerHTML = "response: incorrect login <p>";
	}
}
function sendLoginRequest(username,password)
{
	var request = new XMLHttpRequest();
	request.open("POST","/loginFiles/loginRBMQ.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange= function ()
	{
		
		if ((this.readyState == 4)&&(this.status == 200))
		{
			HandleLoginResponse(this.responseText);
		}		
	}
	request.send("type=login&uname="+username+"&pword="+password);
}

</script>
  </body>
</html>
