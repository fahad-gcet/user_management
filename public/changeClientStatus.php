<?php
session_start();
if ($_SESSION['isAdmin']) {
	include dirname(dirname(__FILE__)) . '/classes/client.class.php';
	$uid = $_GET['uid'];
	$client = new Client();
	$email = $client->getEmailByUid($uid);
	$appName = $client->getAppNameByUid($uid);
	$access_identifier = $appName;
	$access_secret = md5(uniqid(rand(), TRUE));
	$client->changeClientStatus($uid, $access_identifier, $access_secret);

	include dirname(dirname(__FILE__)) . '/classes/mailer.class.php';
	$mail = new Mail();
	$mail->sendClientCredentials($email, $access_identifier, $access_secret);

	header('location:clients.php');
} else {
	header('location:login.php');
}
?>