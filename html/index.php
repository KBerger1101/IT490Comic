<?php
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST')
{
        if (isset($_POST['login']))
        {
                require 'loginFiles/loginRequest.php';
        }
        if (isset($_POST['register']))
        {
                require 'loginFiles/registerRequest.php';
        }
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href="#">This is EPIC!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
    <!--        <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>


<p></p><p></p><p></p><p></p><p></p>
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">Welcome!</h1>
          <p class="lead">Please sign-in to get started.</p>
          <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-signin" action = "index.php" method = "POST">
              <div class="form-label-group">
                <input type="text" name="uname" id="inputUser" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUser">Username</label>
              </div>

              <div class="form-label-group">
                <input type="password" name = "pword" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>
              <button name= 'login'  class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
              
	    </form>
	<form action = "index.php" method= "POST" class="form-signin">
              <div class="form-label-group">
              <p></p>
              <p></p>
                <input name="username" type="text" id="inputUserame" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUserame">Username</label>
              </div>

              <div class="form-label-group">
                <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required>
                <label for="inputEmail">Email address</label>
	      </div>
		<div class="form-label-group">
                <input  name = "firstName" type="text" id="inputfName" class="form-control" placeholder="Username" required autofocus>
                <label for="inputfName">First Name</label>
	      </div>
		<div class="form-label-group">
                <input name= "lastName" type="text" id="inputlName" class="form-control" placeholder="Username" required autofocus>
                <label for="inputlName">Last Name</label>
              </div>
              <hr>

              <div class="form-label-group">
                <input name= "password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputConfirmPassword" class="form-control" placeholder="Password" required>
                <label for="inputConfirmPassword">Confirm password</label>
              </div>

              <button name="register" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
	</form>
          </div>
        </div>
      </div>
    </div>
  </div>




          <p class="mr-sm-2"> <bold><a href="register.html">Register Now</a> </bold></p>
          <ul class="list-unstyled">
            <li></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
