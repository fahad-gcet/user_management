<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="shared/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
?>

<?php
$errors = array();
?>

<?php include 'shared/navbar.php'; ?>

<?php
if (isset($_SESSION['username'])) {
	header("location:index.php");
}
?>

<?php
if (isset($_POST['signUp'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	include 'classes/user.class.php';
	$user = new User();

	if (empty($username)) {
		array_push($errors, 'Username is required');
	}
	elseif ($user->checkUsernameExists($username)) {
		array_push($errors, 'Username already exists');
	}

	if (empty($email)) {
		array_push($errors, 'Email is required');
	}
	elseif ($user->checkEmailExists($email)) {
		array_push($errors, 'Email already exists');
	}

	if (empty($password)) { 
		array_push($errors, 'Password is required'); 
	}

	if ($password != $confirmPassword) {
		array_push($errors, 'The two passwords do not match');
	}

	if (count($errors) == 0) {
		$password = password_hash($password, PASSWORD_BCRYPT);
		$token = md5(uniqid(rand(), TRUE));
		
		$user->signUp($username, $email, $password, $token);
		
		include 'classes/mailer.class.php';
		$link = VERIFICATION_LINK . rawurlencode($token);
		$mail = new Mail();
		$mail->sendVerificationMail($email, $link);

		header('location:login.php');
	}
}
?>

<div class="wrapper">
	<form method="post" action="" class="form-signin">
		<h2 class="form-signin-heading">Sign Up</h2>
		<?php include('shared/errors.php'); ?>
		<input type="text" class="form-control" name="username" required="true" placeholder="Username" autofocus=""/>
		<input type="email" class="form-control" name="email" required="true" placeholder="Email"/>
		<input type="password" class="form-control" name="password" required="true"  placeholder="Password" />
		<input type="password" class="form-control" name="confirmPassword" required="true" placeholder="Confirm Password" />
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="signUp">Sign Up</button>  
		<br>
		<p>Already a Member? <a href="login.php">Log In</a></p>
	</form>
</div>
</body>
</html>