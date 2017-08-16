<!DOCTYPE html>
<html>
<head>
	<title>Clients</title>
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if ($_SESSION['isAdmin'] == false) {
	header('location:index.php');
}
?>
<?php include 'shared/navbar.php'; ?>
<?php
include dirname(dirname(__FILE__)) . '/classes/client.class.php';
$client = new Client();
$rows = $client->getAllClients();
?>
<div class="jumbotron col-md-10 col-md-offset-1">
<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Clients</h3>
		</div>
		<table id="datatable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>S.No.</th>
					<th>Unique ID</th>
					<th>Company Name</th>
					<th>Application Name</th>
					<th>Email</th>
					<th>Approved</th>
					<th>Change Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$serialNumber = 1;
				foreach ($rows as $row) {
				?>
				<tr>
					<td><?php echo $serialNumber; ?></td>
					<td><?php echo $row['uid']; ?></td>
					<td><?php echo $row['companyName']; ?></td>
					<td><?php echo $row['appName']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<?php  if ($row['approved'] == 1) : ?>
						<td>Yes</td>
					<?php else : ?>
						<td>No</td>
						<td><a href="<?php echo CHANGE_CLIENT_STATUS_LINK . rawurlencode($row['uid']); ?>" class="btn btn-warning" role="button">Approve</td>
					<?php endif ?>
				</tr>
				<?php
				$serialNumber++;
				} ?>
			</tbody>
		</table>
	</div>
</div>
</div>
</body>
</html>