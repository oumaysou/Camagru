<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
check_already_login();
if (!empty($_POST))
{
	$errors = array();
	require dirname(__FILE__) . '/../../inc/db.php';
	$errors = check_name($_POST['name'], $errors);
	$errors = check_username($_POST['username'], $errors);
	$errors = check_email($_POST['email'], $_POST['email-confirm'], $errors);
	$errors = check_password($_POST['password'], $_POST['password-confirm'], $errors);
	if (empty($errors)) {
		$req = $pdo->prepare("INSERT INTO User SET name = :name, username = :username, password = :password, email = :email, confirmation_token = :token, mail_comments = :mail_comments");
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$token = str_random(60);
		$req->execute([
			'name' => htmlspecialchars($_POST['name']),
			'username' => htmlspecialchars($_POST['username']),
			'password'=> $password,
			'email' => htmlspecialchars($_POST['email']),
			'token' => $token,
			'mail_comments' => 1
		]);
		$new_username = htmlspecialchars($_POST['username']);
		$user_id = $pdo->lastInsertId();
		$entetes =
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'From: no-reply@camagru.fr' . "\r\n" .
		'Reply-To: no-reply@camagru.fr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$objet = "Confirmation d'Inscription";
		$content = "
		<h2><center>Merci pour ton inscription!</center></h2><br/><br/>

		<center> Ton identifiant : <b> $new_username </b> </center><br/><br/>

		<p>Afin de finaliser ton inscription, il te suffit de cliquer sur ce lien:\n\nhttp://localhost:8080/vue/register-page/confirm.php?id=$user_id&token=$token </p>
		<br/><br/>
		<center>- L'équipe Camagru</center>
		";
		if (mail($_POST['email'], $objet, $content, $entetes))
		{
			$_SESSION['success'] = "Un email de confirmation a été envoyé pour valider le compte";
			header('Location: ../home-page/login-page.php');
			exit();
		}
		else {
			echo '<script>alert(" Email PAS envoyé")</script>';
		}
	}
}
?>
<?php
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
?>
<div class="title-msg">
	<center>Rejoins-Nous et Inscris-Toi!</center>
	<center><img src="../../images/arrow2.png" width="80px"/></center>
</div>

<div class="register-page-background">
	<div class="register-wrapper">
		<?php	if (!empty($errors)): ?>
			<div class="danger">
				<p>Le formulaire n'est pas rempli correctement</p>
				<?php foreach($errors as $error):?>
					<li><?=$error;?></li>
				<?php endforeach;?>
			</div>
		<?php 	endif; ?>
		<div class="hashtag-msg">
			#JoinCamagru
		</div>
		<form method="post">
			<input class="input-register" type="text" name="name" placeholder="Nom Complet" autocomplete="off"/><br/>
			<input class="input-register" type="text" name="username" placeholder="Identifiant" autocomplete="off"/><br/>
			<input class="input-register" type="password" name="password" placeholder="Mot de Passe" autocomplete="off"/><br/>
			<input class="input-register" type="password" name="password-confirm" placeholder="Confirmation du mot de passe" autocomplete="off"/><br/>
			<input class="input-register" type="email" name="email" placeholder="Email" autocomplete="off"/><br/>
			<input class="input-register" type="email" name="email-confirm" placeholder="Confirmation de l'email" autocomplete="off"/><br/>
			<input class="register-submit" type="submit" name="submit" value="S'Inscrire!">
		</form>
	</div>
</div>
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
