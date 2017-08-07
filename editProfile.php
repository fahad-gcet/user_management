<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<link rel="stylesheet" href="shared/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
?>

<?php include('shared/navbar.php') ?>

<?php
if (!isset($_SESSION['username'])) {
	header("location:login.php");
}
?>

<?php
$username = $_SESSION['username'];
if ($_SESSION['isAdmin']) {
	$username = $_GET['username'];
	if ($username == "") {
		$username = $_SESSION['username'];
	}
}
?>

<?php
include 'classes/user.class.php';
$user = new User();
?>

<?php 
if (isset($_POST['editProfile'])) {
	$user->editUser($username, $_POST['mob_no'], $_POST['dob']);
	header("location:index.php");
}
?>

<?php
$row = $user->getUserByName($username);
?>



<div class="wrapper">
	<form method="post" action="" class="form-signin">
		<h2 class="form-signin-heading">Edit Profile</h2>
		<input type="number" class="form-control" id="mob_no" name="mob_no"  placeholder="Mobile Number" required="true" autofocus="true" value=<?php echo $row['mob_no']; ?> />
		<input type="date" class="form-control" name="dob"  placeholder="Date Of Birth" required="true" value=<?php echo $row['dob']; ?>  />
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="editProfile">Edit Profile</button>  
	</form>
	</div>
</body>
</html>