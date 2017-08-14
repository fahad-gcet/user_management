<?php
$url = rawurldecode($_SERVER['REQUEST_URI']);
if (preg_match('/users$/', $url)) {
	include 'users.php';
}
?>