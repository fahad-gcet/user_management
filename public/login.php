<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start(); 
?>

<?php include 'shared/navbar.php'; ?>

<?php
if (isset($_SESSION['username'])) {
	header("location:index.php");
}
?>

<?php
if (isset($_POST['logIn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	include dirname(dirname(__FILE__)) . '/classes/user.class.php';
	$user = new User();
	$userStatus = $user->logIn($username, $password);
	if ($userStatus == 'success') {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['isAdmin'] = $user->checkAdmin($username);
		header("location:index.php?status=".urlencode("success"));
	} elseif ($userStatus == 'unVerified') {
		header("location:login.php?status=".urlencode("unVerified"));
	} elseif ($userStatus == 'blockedUser') {
		header("location:login.php?status=".urlencode("blockedUser"));
	} elseif ($userStatus == 'invalidUser') {
		header("location:login.php?status=".urlencode("invalidUser"));
	} elseif ($userStatus == 'noUserFound') {
		header("location:login.php?status=".urlencode("noUserFound"));
	}
}
?>

<?php
if (isset($_GET['status'])) {
	$status = $_GET['status'];
}
?>

<?php  if ($status == 'logout') : ?>
	<div class="alert alert-success col-md-8 col-md-offset-2" role="alert">Logged Out Successfully</div>
<?php endif ?>

<?php  if ($status == 'unVerified') : ?>
	<div class="alert alert-danger col-md-8 col-md-offset-2" role="alert">Please verify your account first</div>
<?php endif ?>

<?php  if ($status == 'blockedUser') : ?>
	<div class="alert alert-danger col-md-8 col-md-offset-2" role="alert">Your account has been blocked. Please contact admin.</div>
<?php endif ?>

<?php  if ($status == 'invalidUser') : ?>
	<div class="alert alert-danger col-md-8 col-md-offset-2" role="alert">Invalid username and password combination</div>
<?php endif ?>

<?php  if ($status == 'noUserFound') : ?>
	<div class="alert alert-danger col-md-8 col-md-offset-2" role="alert">Invalid username</div>
<?php endif ?>

<br>
<div class="wrapper">
	<form method="post" action="" class="form-signin">
		<h2 class="form-signin-heading">Log In</h2>
		<input type="text" class="form-control" name="username" required="true" placeholder="Username" autofocus="true" />
		<input type="password" class="form-control" name="password" required="true" placeholder="Password"/> 
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="logIn">Login</button> 
		<br>
		<p>Not a Member? <a href="signup.php">Sign Up</a></p> 
	</form>
</div>
</body>
</html>