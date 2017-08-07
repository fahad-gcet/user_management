<?php
include 'classes/database.class.php';

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
			return True;
		}
		return False;
	}

	public function checkBlocked($username) {
		$database = new Database();
		$database->query('SELECT blocked FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($row['blocked'] == 1) {
			return True;
		}
		return False;
	}

	public function checkVerifiedAccount($username) {
		$database = new Database();
		$database->query('SELECT verified FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($row['verified'] == 1) {
			return True;
		}
		return False;
	}

	public function checkUsernameExists($username) {
		$database = new Database();
		$database->query('SELECT username FROM users WHERE username = :username');
		$database->bind(':username', $username);
		$row = $database->single();
		if ($database->rowCount() > 0) {
			return True;
		}
		return False;
	}

	public function checkEmailExists($email) {
		$database = new Database();
		$database->query('SELECT email FROM users WHERE email = :email');
		$database->bind(':email', $email);
		$row = $database->single();
		if ($database->rowCount() > 0) {
			return True;
		}
		return False;
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
			return True;
		}
		return False;
	}

	public function editUser($username, $mob_no, $dob) {
		$database = new Database();
		$database->query('UPDATE users SET mob_no=:mob_no, dob=:dob WHERE username = :username');
		$database->bind(':mob_no', $mob_no);
		$database->bind(':dob', $dob);
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
		$database->query('SELECT username, email, mob_no, dob FROM users WHERE username != :username ORDER BY username');
		$database->bind(':username', $username);
		$rows = $database->resultset();
		return $rows;
	}

	public function getUserByName($username) {
		$database = new Database();
		$database->query('SELECT mob_no, dob FROM users WHERE username = :username');
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
}
?>