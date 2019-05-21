<?php

function delete_all_photos_and_directory($dirPath) {
	if (is_dir($dirPath)) {
		$objects = scandir($dirPath);
		foreach ($objects as $object) {
			if ($object != "." && $object !="..") {
				if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
					deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
				} else {
					unlink($dirPath . DIRECTORY_SEPARATOR . $object);
				}
			}
		}
		reset($objects);
		rmdir($dirPath);
	}
}

function check_if_session_already_started() {
	check_session();
	unset($_SESSION['auth']);
}

function debug($variable){
	echo '<pre>'.var_dump($variable).'</pre>';
}

function str_random($length){
	$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only() {
	if (!isset($_SESSION['auth'])) {
		$_SESSION['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
		header('Location: /../vue/home-page/login-page.php');
		exit();
	}
}

function check_session() {
	if (session_status() == PHP_SESSION_NONE && !isset($_SESSION['danger'])) {
		session_start();
	}
}

function check_already_login() {
	if (isset($_SESSION['auth']))
	{
		$_SESSION['danger'] = "Vous êtes déjà connecté";
		header('Location: /../vue/home-page/home.php');
		exit();
	}
}

function password_check_alphanum($str)
{
	$size = strlen($str);
	$i = 0;
	$num = 0;
	$alpha = 0;
	while ($i < $size)
	{
		if ($str[$i] >= '0' && $str[$i] <= '9')
		$num = 1;
		else if ($str[$i] >= 'A' && $str[$i] <= 'Z' || $str[$i] >= 'a' && $str[$i] <= 'z')
		$alpha = 1;
		$i++;
	}
	return $alpha == 1 && $num == 1 ? true : false;
}

function check_name($name, $errors) {
	if (empty($name) || !preg_match('/^[a-zA-Z ]+$/', $name) || strlen($name) < 2 || strlen($name) > 60)
	{
		$str = (!preg_match('/^[a-zA-Z ]+$/', $name)) ? "Votre nom n'est pas valide" : "Votre nom est trop court. Il doit au minimum contenir 2 caractères";
		$str = (strlen($name) > 60) ? "Le nom est trop long. Entrer un nom de 60 caractères maximum." : $str;
		$errors['name'] = $str;
	}
	return ($errors);
}

function check_username($username, $errors) {
	require dirname(__FILE__) . '/db.php';
	if (empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) < 6 || strlen($username) > 30) {
		$str = (strlen($username) < 6) ? "L'identifiant doit avoir au moins 6 caractères" : "L'identifiant n'est pas valide";
			$str = (strlen($username) > 30) ? "L'identifiant est trop long. Entrer un identifiant de 30 caractères maximum." : $str;
		$errors['username'] = $str;
	}
	else {
		$req = $pdo->prepare('SELECT id FROM User WHERE username = ?');
		$req->execute([$username]);
		$user = $req->fetch();
		if ($user)
		{
			$errors['username'] = 'Cet identifiant est déjà pris';
		}
	}
	return ($errors);
}

function check_password($password, $password_confirm, $errors) {
	require dirname(__FILE__) . '/db.php';
	if (empty($password) || $password != $password_confirm || strlen($password) < 4 || !password_check_alphanum($password) || strlen($password) > 255) {
		$str = (strlen($password) < 4) ? "Le mot de passe doit avoir au moins 4 caractères dont des chiffres et des lettres" : "Le mot de passe n'est pas valide";
		$str = (!password_check_alphanum($password)) ? "Le mot de passe doit contenir des lettres ainsi que des chiffres. L'ensemble devra au minimum faire 4 caractéres" : $str;
		$str = (strlen($password) > 255) ? "Le mot de passe doit avoir au maximum 255 caractères." : $str;
		$errors['password'] = $str;
	}
	return ($errors);
}

function check_email($email, $email_confirm, $errors)
{
	require dirname(__FILE__) . '/db.php';
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
		$errors['email'] = "L'e-mail n'est pas valide";
	else if ($email != $email_confirm)
		$errors['email'] = "Les emails ne correspondent pas";
	else if (strlen($email) > 255)
		$errors['email'] = "L'email est trop long. L'adresse mail doit avoir au maximum 255 caractères.";
	else {
		$req = $pdo->prepare('SELECT id FROM User WHERE email = ?');
		$req->execute([$email]);
		$user = $req->fetch();
		if ($user)
		{
			$errors['email'] = 'Cet e-mail est déjà pris';
		}
	}
	return ($errors);
}

function how_many_liked($photoID) {
	require dirname(__FILE__) . '/db.php';
	$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE photo_id = ?');
	$req->execute([$photoID]);
	$result = $req->fetchAll();
	return(count($result));
}

function how_many_commented($photoID) {
	require dirname(__FILE__) . '/db.php';
	$req = $pdo->prepare('SELECT photo_id FROM comments WHERE photo_id = ?');
	$req->execute([$photoID]);
	$result = $req->fetchAll();
	return(count($result));
}