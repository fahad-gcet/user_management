<?php
session_start();
$username = $_GET['username'];
if ($username != $_SESSION['username'] and $_SESSION['isAdmin']) {
	include 'classes/user.class.php';
	$user = new User();
	$status = $user->checkBlocked($username);
	$user->changeAccountStatus($username, $status);
	header('location:index.php');
} else {
	header('location:login.php');
}
?>