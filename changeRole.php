<?php
session_start();
$username = $_GET['username'];
if ($username != $_SESSION['username'] and $_SESSION['isAdmin']) {
	include 'classes/user.class.php';
	$user = new User();
	$role = $user->checkAdmin($username);
	$user->changeRole($username, $role);
	header('location:index.php');
} else {
	header('location:login.php');
}
?>