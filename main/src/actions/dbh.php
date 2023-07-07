<?php

date_default_timezone_set("Asia/Kolkata");
include './src/actions/define.php';

class db {

	protected $dbUser, $dbPass;

	public function __construct() {
		$this->dbUser = $GLOBALS['dbUser'];
		$this->dbPass = $GLOBALS['dbPass'];
	}

	public function pconnect() {
		
		if($_SERVER['SERVER_NAME']=='::1') {
			$server = "localhost";
		}
		else {
			$server = $_SERVER['SERVER_NAME'];
		}

		try {
			$pdo = new PDO("mysql:host=localhost;dbname=people", $this->dbUser, $this->dbPass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;
		}
		catch(PDOException $e) {
			return $e->getMessage();
		}

	}
	public function mconnect($db) {

		if($_SERVER['SERVER_NAME']=='::1') {
			$server = "localhost";
		}
		else {
			$server = $_SERVER['SERVER_NAME'];
		}

		try {
			$pdo = new PDO("mysql:host=localhost;dbname=$db", $this->dbUser, $this->dbPass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;
		}
		catch(\Exception $e) {
			return $e->getMessage();
		}

	}

	public function connect() {

		if($_SERVER['SERVER_NAME']=='::1') {
			$server = "localhost";
		}
		else {
			$server = $_SERVER['SERVER_NAME'];
		}

		try {
			$pdo = new PDO("mysql:host=localhost", $this->dbUser, $this->dbPass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;
		}
		catch(\Exception $e) {
			return $e->getMessage();
		}
	}

	public function pageconnect() {
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=pages", $this->dbUser, $this->dbPass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;
		}
		catch(\Exception $e) {
			return $e->getMessage();
		}
	}

	public function postsconnect() {
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=posts", $this->dbUser, $this->dbPass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;
		}
		catch(\Exception $e) {
			return $e->getMessage();
		} 
	}

}