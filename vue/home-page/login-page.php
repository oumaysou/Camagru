<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
check_already_login();
if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password']))
{
	require_once dirname(__FILE__) . '/../../inc/db.php';
	require_once dirname(__FILE__) . '/../../inc/functions.php';
	$req = $pdo->prepare('SELECT * from User WHERE username = :username AND confirmation_at IS NOT NULL');
	$req->execute([
		'username' => $_POST['username']
	]);
	$user = $req->fetch();
	if ($user && password_verify($_POST['password'], $user->password))
	{
		$_SESSION['auth'] = $user;
		$_SESSION['success'] = "Vous êtes maintenant connecté";
		header('Location: /../vue/home-page/home.php');
		exit();
	}
	else
	$_SESSION['danger'] = "Identifiant/Email ou mot de passe inccorects";
}
?>
<?php require dirname(__FILE__) . '/../header/header.php'; ?>
<?php require dirname(__FILE__) . '/../navbar/navbar.php'; ?>
<div class="all-page-login">
	<div class="title-msg">
		<center>Connecte-Toi</center>
		<center><img class="logo-img" src="../../images/arrow2.png" width="80px"/></center>
	</div>
	<div class="background-login">
		<form class="form-login" action="" method="post">
			<div class="wrapper-form">
			<input class="input-login" type="text" name="username" title="identifiant" placeholder="Identifiant"/><br/>
			<input class="input-login" type="password" name="password" title="password" placeholder="Mot de Passe"/><br/>
			<input class="login-submit" type="submit" value="Se Connecter"><br/>
		</div>
		</form>
	</div>
	<a class="forget-password" href="/../vue/forgetPassword-page/forget.php">Mot de passe oublié</a>
</div>
<?php require dirname(__FILE__) . '/../footer/footer.php'; ?>
