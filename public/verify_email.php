<?php
$token = $_GET['token'];
include dirname(dirname(__FILE__)) . '/classes/user.class.php';
$user = new User();
if ($user->verifyEmail($token)) {
	header("location:login.php?status=".urlencode("emailVerified"));
	$user->deleteToken($token);
} else {
	header("location:login.php?status=".urlencode("invakidToken"));
}
?>