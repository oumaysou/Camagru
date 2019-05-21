<?php
// session_start();
// session_destroy();
function create_database() {
	include './database.php';
	try {
		$dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE DATABASE `camagru`";
		$dbh->exec($sql);
		$dbh->exec("use `camagru`");
	}
	catch (PDOException $e)
	{
		echo "<script type=text/javascript>alert('Problem creating Database Camagru);</script>";
	}
	try {
		//----> CREATE_TABLE USER <----
		$dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("use `camagru`");
			$sql = "CREATE TABLE IF NOT EXISTS User (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(60) NOT NULL,
				username VARCHAR(30) NOT NULL,
				password VARCHAR(255) NOT NULL,
				email VARCHAR(255) NOT NULL,
				confirmation_token varchar(60) NULL,
				confirmation_at DateTime NULL,
				reset_token VARCHAR(60) NULL,
				reset_at DateTime NULL,
				mail_comments INT NOT NULL
			)";
			$dbh->exec($sql);
		//----> CREATE_TABLE PHOTOS<----
		$dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("use `camagru`");
			$sql = "CREATE TABLE IF NOT EXISTS photos (
				user_id INT NOT NULL,
				photo_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				date_photo DateTime DEFAULT CURRENT_TIMESTAMP,
				photo_type VARCHAR(4) NOT NULL,
				filter INT NOT NULL,
				photo_path VARCHAR(255) NOT NULL
			)";
			$dbh->exec($sql);
		//----> CREATE_TABLE COMMENTS<----
		$dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("use `camagru`");
			$sql = "CREATE TABLE IF NOT EXISTS comments (
				comment_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				usercomment_id INT NOT NULL,
				usercomment_username VARCHAR(255) NOT NULL,
				photo_id INT NOT NULL,
				date_comment DateTime DEFAULT CURRENT_TIMESTAMP,
				comment LONGTEXT NOT NULL
			)";
			$dbh->exec($sql);
		//----> CREATE_TABLE LIKE<----
		$dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("use `camagru`");
			$sql = "CREATE TABLE IF NOT EXISTS likephoto (
				userlike_id INT NOT NULL,
				date_like DateTime DEFAULT CURRENT_TIMESTAMP,
				photo_id INT NOT NULL
			)";
			$dbh->exec($sql);
			header('Location: ../index.php');
	}
	catch (PDOException $e)
	{
		echo "<script type= 'text/javascript'>alert('Problem creating Tables');</script>";
	}
}

function delete_database() {
	include './database.php';
	include '../inc/functions.php';
	try {
		check_if_session_already_started();
		$dbh = new PDO($DB_DSN_LIGHT, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DROP DATABASE camagru";
		$dbh->exec($sql);
		echo "<script type= 'text/javascript'>alert('Database Deleted Successfully');</script>";
	}
	catch (PDOException $e)
	{

	}
}
//----> CREATE DATABASE <----
if (isset($_POST['create'])) {
	create_database();
}

//----> RE-CREATE DATABASE <----
if (isset($_POST['re-create'])) {
	delete_database();
	create_database();
}

//----> DELETE DATABASE <----
if (isset($_POST['delete'])) {
	delete_database();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./setup.css">
</head>
<body>
	<form method="post">
		<input type="submit" name="create" value="Create" />
		<input type="submit" name="re-create" value="Re-Create" />
		<input type="submit" name="delete" value="Delete" />
	</form>
</body>
</html>
