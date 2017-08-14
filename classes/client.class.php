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

	public function getAllClients() {
		$database = new Database();
		$database->query('SELECT uid, companyName, appName, email, approved FROM clients');
		$rows = $database->resultset();
		return $rows;
	}

	public function changeClientStatus($uid, $access_identifier, $access_secret) {
		$database = new Database();
		$database->query('UPDATE clients SET approved=1, access_identifier=:access_identifier, access_secret= :access_secret WHERE uid = :uid');
		$database->bind(':access_identifier', $access_identifier);
		$database->bind(':access_secret', $access_secret);
		$database->bind(':uid', $uid);
		$database->execute();
	}

	public function getEmailByUid($uid) {
		$database = new Database();
		$database->query('SELECT email FROM clients WHERE uid = :uid');
		$database->bind(':uid', $uid);
		$row = $database->single();
		return $row['email'];
	}

	public function getAppNameByUid($uid) {
		$database = new Database();
		$database->query('SELECT appName FROM clients WHERE uid = :uid');
		$database->bind(':uid', $uid);
		$row = $database->single();
		return $row['appName'];
	} 
}
?>