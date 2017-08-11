<?php
include dirname(dirname(__FILE__)) .'/classes/database.class.php';

class User {

	public function logIn($username, $password) {
		$errors = array();
		$database = new Database();
		$database->query('SELECT password, verified, blocked FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($database->rowCount() == 1) {
			if (password_verify($password, $row['password']) and $row['verified'] == 1 and $row['blocked'] == 0){
				return 'success';
			} elseif ($row['verified'] == 0) {
				return 'unVerified';
			} elseif ($row['blocked'] == 1) {
				return 'blockedUser';
			} else {
				return 'invalidUser';
			}
		} else {
			return 'noUserFound';
		}
		unset($database);
	}

	public function checkAdmin($username) {
		$database = new Database();
		$database->query('SELECT isAdmin FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($row['isAdmin'] == 1) {
			return true;
		}
		return false;
	}

	public function checkBlocked($username) {
		$database = new Database();
		$database->query('SELECT blocked FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($row['blocked'] == 1) {
			return true;
		}
		return false;
	}

	public function checkVerifiedAccount($username) {
		$database = new Database();
		$database->query('SELECT verified FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($row['verified'] == 1) {
			return true;
		}
		return false;
	}

	public function checkUsernameExists($username) {
		$database = new Database();
		$database->query('SELECT username FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($database->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function checkEmailExists($email) {
		$database = new Database();
		$database->query('SELECT email FROM users WHERE email = :email');
		$database->bind(':email', $email);
		$row = $database->single();
		if ($database->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function signUp($username, $email, $password, $token) {
		$database = new Database();
		$database->query('INSERT INTO users (username, email, password, token) VALUES (:username, :email, :password, :token)');
		$database->bind(':username', $username);
		$database->bind(':email', $email);
		$database->bind(':password', $password);
		$database->bind(':token', $token);
		$database->execute();
	}

	public function verifyEmail($token) {
		$database = new Database();
		$database->query('UPDATE users SET verified=1 WHERE token = :token');
		$database->bind(':token', $token);
		$database->execute();
		if ($database->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function editUser($username, $mob_no, $dob, $firstName, $lastName) {
		$database = new Database();
		$database->query('UPDATE users SET mob_no=:mob_no, dob=:dob, firstName=:firstName, lastName=:lastName WHERE username = :username');
		$database->bind(':mob_no', $mob_no);
		$database->bind(':dob', $dob);
		$database->bind(':firstName', $firstName);
		$database->bind(':lastName', $lastName);
		$database->bind(':username', $username);
		$database->execute();
	}

	public function deleteToken($token) {
		$database = new Database();
		$database->query('UPDATE users SET token=NULL WHERE token = :token and verified= :verified');
		$database->bind(':token', $token);
		$database->bind(':verified', 1);
		$database->execute();
	}

	public function getAllUsersByName($username) {
		$database = new Database();
		$database->query('SELECT username, email, mob_no, dob, firstName, lastName FROM users WHERE username != :username ORDER BY username');
		$database->bind(':username', $username);
		$rows = $database->resultset();
		return $rows;
	}

	public function getUserByName($username) {
		$database = new Database();
		$database->query('SELECT mob_no, dob, firstName, lastName FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		return $row;
	}

	public function changeRole($username, $role) {
		$database = new Database();
		if ($role) {
			$database->query('UPDATE users SET isAdmin=0 WHERE username = :username');
		} else {
			$database->query('UPDATE users SET isAdmin=1 WHERE username = :username');
		}
		$database->bind(':username', $username);
		$database->execute();
	}

	public function changeAccountStatus($username, $status) {
		$database = new Database();
		if ($status) {
			$database->query('UPDATE users SET blocked=0 WHERE username = :username');
		} else {
			$database->query('UPDATE users SET blocked=1 WHERE username = :username');
		}
		$database->bind(':username', $username);
		$database->execute();
	}

	public function getIDByUsername($username) {
		$database = new Database();
		$database->query('SELECT id FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		return $row['id'];
	}

	public function getUserInterests($user_id) {
		$database = new Database();
		$database->query('SELECT interest_id FROM user_interests WHERE user_id = :user_id');
		$database->bind(':user_id', $user_id);
		$rows = $database->resultset();
		$interests = array();
		foreach ($rows as $row) {
			$database->query('SELECT name FROM interests WHERE id = :interest_id');
			$database->bind(':interest_id', $row['interest_id']);
			$Interestrow = $database->single();
			array_push($interests, $Interestrow['name']);
		}
		return $interests;
	}

	public function getAllInterests() {
		$database = new Database();
		$database->query('SELECT name FROM interests');
		$rows = $database->resultset();
		$allInterests = array();
		foreach ($rows as $row) {
			array_push($allInterests, $row['name']);
		}
		return $allInterests;
	}

	public function getIDByInterest($interest_name) {
		$database = new Database();
		$database->query('SELECT id FROM interests WHERE name= :name');
		$database->bind(':name', $interest_name);
		$row = $database->single();
		return $row['id'];
	}

	public function checkUserInterestExists($user_id, $interest_id) {
		$database = new Database();
		$database->query('SELECT id FROM user_interests WHERE user_id= :user_id and interest_id= :interest_id');
		$database->bind(':user_id', $user_id);
		$database->bind(':interest_id', $interest_id);
		$row = $database->single();
		if ($database->rowCount() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function insertUserInterests($user_id, $interest_id) {
		$database = new Database();
		$database->query('INSERT INTO user_interests (user_id, interest_id) VALUES (:user_id, :interest_id)');
		$database->bind(':user_id', $user_id);
		$database->bind(':interest_id', $interest_id);
		$database->execute();
	}

	public function deleteUserInterests($user_id, $interest_id) {
		$database = new Database();
		$database->query('DELETE FROM user_interests WHERE user_id= :user_id AND interest_id= :interest_id');
		$database->bind(':user_id', $user_id);
		$database->bind(':interest_id', $interest_id);
		$database->execute();
	}

	public function getAllUsers() {
		$database = new Database();
		$database->query('SELECT username, firstName, lastName, email, mob_no FROM users');
		$rows = $database->resultset();
		return $rows;
	}

	public function checkValid($access_identifier, $signature) {
		$database = new Database();
		$database->query('SELECT access_secret FROM clients WHERE access_identifier = :access_identifier');
		$database->bind(':access_identifier', $access_identifier);
		$row = $database->single();
		if ($database->rowCount() == 1) {
			$access_secret = $row['access_secret'];
			$actualSignature = hash_hmac('sha256', $access_identifier, $access_secret);
			if ($signature == $actualSignature) {
				return true;
			}
		}
		return false;
	}
}
?>