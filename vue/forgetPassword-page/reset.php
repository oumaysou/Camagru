<?php
if (isset($_GET['id']) && isset($_GET['token'])):
	require_once dirname(__FILE__) . '/../../inc/db.php';
	require_once dirname(__FILE__) . '/../../inc/functions.php';
	$req = $pdo->prepare('SELECT * FROM User WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
	$req->execute([$_GET['id'], $_GET['token']]);
	$user = $req->fetch();
	if ($user && !empty($_POST)) {
		$errors = array();
		$errors = check_password($_POST['password'], $_POST['confirm-password'], $errors);
		if (!empty($_POST['password']) && $_POST['password'] == $_POST['confirm-password'] && !isset($errors['password']))
		{
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$req = $pdo->prepare('UPDATE User SET password = ?, reset_at = NULL, reset_token = NULL');
			$req->execute([$password]);
			session_start();
			$_SESSION['success'] = "Votre mot de passe a bien été mis à jour";
			$_SESSION['auth'] = $user;
			header('Location: /../vue/home-page/home.php');
			exit();
		}
		else if (isset($errors['password']))
		{
			$_SESSION['danger'] = $errors['password'];
		}
	}
	else if (!$user)
	{
		session_start();
		$_SESSION['danger'] = "Désolé, ce lien n'est pas valide";
		header('Location: /../vue/home-page/home.php');
		exit();
	}
	?>

	<?php require dirname(__FILE__) . '/../header/header.php'; ?>
	<?php require dirname(__FILE__) . '/../navbar/navbar.php'; ?>
	<div class="wrapper-reset">
		<div class="title">
			<center><img id="img-login" src="../../images/logo.png" width="90px;"/></center>
			<center><img id="img-login" src="../../images/new-password.jpg" width="260px;"/></center>
		</div>
		<form action="" method="post">
			<div class="wrapper-form-reset">
				<div class="form-group">
					<input class="input-change" type="password" name="password" placeholder="Changer de mot de passe"/>
				</div>
				<div class="form-group">
					<input class="input-change" type="password" name="confirm-password" placeholder="Confirmation du nouveau mot de passe"/>
				</div>
				<center><input class="validate-change-submit" type="submit" value="Changer mon mot de passe"></center><br/>
			</div>
		</form>
	</div>
<?php else:?>
	<!-- <?php header('Location: /../vue/home-page/login-page.php'); ?> -->
<?php endif;?>
<?php require_once dirname(__FILE__) . '/../footer/footer.php'; ?>
