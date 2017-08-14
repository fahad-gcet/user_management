<!DOCTYPE html>
<html>
<head>
	<title>Client Application Form</title>
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php include 'shared/navbar.php'; ?>
<?php
if (isset($_GET['msg'])) {
	if ($_GET['msg'] == 1) { ?>
		<div class="alert alert-success col-md-8 col-md-offset-2" role="alert">Application form submitted successfully. API Credentials will be mailed to you once your application get approval from the admin</div>
		<br>
	<?php }
}
?>
<?php
if (isset($_POST['apply'])) {
	$companyName = $_POST['companyName'];
	$uid = $_POST['uid'];
	$email = $_POST['email'];
	$appName = $_POST['appName'];

	include dirname(dirname(__FILE__)) . '/classes/client.class.php';
	$client = new Client();
	$client->addClient($uid, $companyName, $appName, $email);
	header('location:clientApplication.php?msg=1');
}
?>
<div class="wrapper">
	<form method="post" action="" class="form-signin">
		<h2 class="form-signin-heading">API Access Application Form</h2>
		<input type="text" class="form-control" name="companyName" required="true" placeholder="Company Name" autofocus=""/>
		<input type="text" class="form-control" name="uid" required="true" placeholder="Unique Identification Number"/>
		<input type="email" class="form-control" name="email" required="true" placeholder="Email Address"/>
		<input type="text" class="form-control" name="appName" required="true" placeholder="Website / Application Name"/>
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="apply">Apply</button>
	</form>
</div>
</body>
</html>