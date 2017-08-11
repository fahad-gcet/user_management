<?php
include dirname(dirname(dirname(dirname(__FILE__)))) . '/classes/user.class.php';
$request_method = $_SERVER["REQUEST_METHOD"];
$access_identifier = $_GET['identifier'];
$signature = $_GET['signature'];
$user = new User();

if ($user->checkValid($access_identifier, $signature)) {
	if ($request_method == 'GET') {
		$rows = $user->getAllUsers();
		foreach ($rows as $row) {
			$user_id = $user->getIDByUsername($row['username']);
			$userInterests = $user->getUserInterests($user_id);
			$row['Interests'] = $userInterests;
			$response[] = $row;
		}
		header('Content-Type: application/json', true, 200);
		echo json_encode($response);
	} else {
		header("HTTP/1.0 405 Method Not Allowed", true, 405);
	}
}
else {
	header("HTTP/1.0 401 Unauthorized", true, 401);
}
?>