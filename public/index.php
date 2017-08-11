<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php session_start(); ?>
<?php include 'shared/navbar.php'; ?>

<?php
if (!isset($_SESSION['username'])) {
	header("location:login.php");
}
?>

<?php
if (isset($_GET['logout'])) {
	session_destroy();
	header("location:login.php?status=".urlencode("logout"));
}
?>

<?php
$status = $_GET['status'];
?>

<?php  if ($status == 'success') : ?>
	<div class="alert alert-success col-md-8 col-md-offset-2" role="alert">Logged In Successfully</div>
<?php endif ?>

<br>
<div class="jumbotron col-md-10 col-md-offset-1">
	<!-- <div class="container"> -->
		<?php  if (!$_SESSION['isAdmin']) : ?>
			<h1>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></h1>
			<p>This is your personal dashboard</p>
		<?php endif ?>
		<?php  if ($_SESSION['isAdmin']) : ?>
			<h1>Welcome, <strong><?php echo $_SESSION['username']; ?> (Admin)</strong></h1>
			<p>This is your personal dashboard</p> <br>
			<?php
			include dirname(dirname(__FILE__)) . '/classes/user.class.php';
			$user = new User();
			$rows = $user->getAllUsersByName($_SESSION['username']);
			?>
			<div class="row">
				<!-- <div class=""> -->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Users</h3>
						</div>
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Username</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>Mobile Number</th>
									<th>Date of Birth</th>
									<th>Role</th>
									<th>Change Role</th>
									<th>Verified Account</th>
									<th>Status</th>
									<th>Change Status</th>
									<th>Edit</th>
									<th>Interests</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$serialNumber = 1;
								foreach ($rows as $row) {
								?>
									<tr>
										<td><?php echo $serialNumber; ?></td>
										<td><?php echo $row['username']; ?></td>
										<td><?php echo $row['firstName']; ?></td>
										<td><?php echo $row['lastName']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td><?php echo $row['mob_no']; ?></td>
										<td><?php echo date("d-m-Y", strtotime($row['dob'])); ?></td>
										<?php  if ($user->checkAdmin($row['username'])) : ?>
											<td>Admin</td>
											<td><a href="<?php echo CHANGE_ROLE_LINK . rawurlencode($row['username']); ?>" class="btn btn-warning" role="button">Make Member</td>
										<?php else : ?>
											<td>Member</td>
											<td><a href="<?php echo CHANGE_ROLE_LINK . rawurlencode($row['username']); ?>" class="btn btn-danger" role="button">Make Admin</td>
										<?php endif ?>
										<?php  if ($user->checkVerifiedAccount($row['username'])) : ?>
											<td>Verified</td>
										<?php else : ?>
											<td>Unverified</td>
										<?php endif ?>
										<?php  if ($user->checkBlocked($row['username'])) : ?>
											<td>Blocked</td>
											<td><a href="<?php echo CHANGE_STATUS_LINK . rawurlencode($row['username']); ?>" class="btn btn-warning" role="button">Unblock</td>
										<?php else : ?>
											<td>Unblocked</td>
											<td><a href="<?php echo CHANGE_STATUS_LINK . rawurlencode($row['username']); ?>" class="btn btn-danger" role="button">Block</td>
										<?php endif ?>
										<td><a href="<?php echo USER_EDIT_LINK . rawurlencode($row['username']); ?>" class="btn btn-primary" role="button">Edit</td>
										<?php
										$user_id = $user->getIDByUsername($row['username']);
										$interests = $user->getUserInterests($user_id);
										?>
										<td>
											<?php foreach ($interests as $interest) { ?>
											<?php echo $interest . " | "; ?>
											<?php } ?>
										</td>
									</tr>
								<?php
								$serialNumber++;
								}
								?>
							</tbody>
						</table>
					<!-- </div> -->
				<!-- </div> -->
			</div>
		<?php endif ?>
	</div>
</div>
</body>
</html>

