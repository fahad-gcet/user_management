<?php
$token = $_GET['token'];
include 'classes/user.class.php';
$user = new User();
if ($user->verifyEmail($token)) {
	header("location:login.php?status=".urlencode("emailVerified"));
	$user->deleteToken($token);
} else {
	header("location:login.php?status=".urlencode("invakidToken"));
}
?>