<?php
include dirname(dirname(__FILE__)) .'/classes/database.class.php';

class Client {

	public function addClient($uid, $companyName, $appName, $email) {
		$database = new Database();
		$database->query('INSERT INTO clients (uid, companyName, appName, email) VALUES (:uid, :companyName, :appName, :email)');
		$database->bind(':uid', $uid);
		$database->bind(':companyName', $companyName);
		$database->bind(':appName', $appName);
		$database->bind(':email', $email);
		$database->execute();
	}
}
?>