<?php 

include('./SqlHelper.php');

class User {

	function __construct() {
		new sql();
	}

	function select() {
		$stmt = sql::$db->query('SELECT * FROM user');
		if ($stmt->execute()) {
			while ($row = $stmt->fetch()) {
			print_r($row);
			}
		}
	}

	function insert($qcm) {
 		$stmt = sql::$db->prepare('INSERT INTO user(Username,password,email,birthday ) VALUES (:Username,:password,:email,:birthday)');
		$stmt->bindParam(':Username', $user->getUsername());
		$stmt->bindParam(':password', $user->getPassword());
		$stmt->bindParam(':email', $user->getEmail());
		$stmt->bindParam(':birthday', $user->getBirthday());
		$stmt->execute();

		return sql::$db->lastInsertId();
	}
}