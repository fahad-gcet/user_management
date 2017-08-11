<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<link rel="stylesheet" href="assets/style.css">
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
include dirname(dirname(__FILE__)) . '/classes/user.class.php';
$user = new User();
?>

<?php 
if (isset($_POST['editProfile'])) {
	$user->editUser($username, $_POST['mob_no'], $_POST['dob'], $_POST['firstName'], $_POST['lastName']);
	$user_id = $user->getIDByUsername($username);
	$allInterests = $user->getAllInterests();
	if (!empty($_POST['check_list'])) {
		foreach($_POST['check_list'] as $selected) {
			$interest_id = $user->getIDByInterest($selected);
			if (!$user->checkUserInterestExists($user_id, $interest_id)) {
				$user->insertUserInterests($user_id, $interest_id);
			}
		}
	}
	$notCheckedList = array_diff($allInterests, $_POST['check_list']);
	if (!empty($notCheckedList)) {
		foreach($notCheckedList as $notSelected) {
			$interest_id = $user->getIDByInterest($notSelected);
			if ($user->checkUserInterestExists($user_id, $interest_id)) {
				$user->deleteUserInterests($user_id, $interest_id);
			}
		}
	}
	header("location:index.php");
}
?>

<?php
$row = $user->getUserByName($username);
$user_id = $user->getIDByUsername($username);
$interests = $user->getUserInterests($user_id);
$allInterests = $user->getAllInterests();
?>



<div class="wrapper">
	<form method="post" action="" class="form-signin">
		<h2 class="form-signin-heading">Edit Profile</h2>
		<input type="text" class="form-control" id="firstName" name="firstName"  placeholder="First Name" required="true" autofocus="true" value=<?php echo $row['firstName']; ?> />
		<input type="text" class="form-control" id="lastName" name="lastName"  placeholder="Last Name" required="true" value=<?php echo $row['lastName']; ?> />
		<input type="number" class="form-control" id="mob_no" name="mob_no"  placeholder="Mobile Number" required="true" value=<?php echo $row['mob_no']; ?> />
		<input type="date" class="form-control" name="dob"  placeholder="Date Of Birth" required="true" value=<?php echo $row['dob']; ?>  />
		<br>
		<label>Interests</label>
		<?php
		foreach ($allInterests as $interest) {
			?>
			<div class="checkbox">
			<?php 
			if (in_array($interest, $interests)) { ?>
				<label><input type="checkbox" name="check_list[]" value=<?php echo $interest; ?> checked><?php echo $interest; ?></label>
			<?php } else { ?>
				<label><input type="checkbox" name="check_list[]" value=<?php echo $interest; ?>><?php echo $interest; ?></label>
				<?php } ?>
				</div>
				<?php

		}
		?>
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="editProfile">Edit Profile</button>  
	</form>
	</div>
</body>
</html>