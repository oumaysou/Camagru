<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
check_already_login();
if (!empty($_POST) && !empty($_POST['email']))
{
	require_once dirname(__FILE__) . '/../../inc/db.php';
	require_once dirname(__FILE__) . '/../../inc/functions.php';
	$req = $pdo->prepare('SELECT * from User WHERE email = ? AND confirmation_at IS NOT NULL');
	$req->execute([$_POST['email']]);
	$user = $req->fetch();
	if ($user)
	{
		$reset_token = str_random(60);
		$req = $pdo->prepare('UPDATE User SET reset_token = ?, reset_at = NOW() WHERE id = ?');
		$req->execute([$reset_token, $user->id]);
		$_SESSION['success'] = "Pour changer votre mot de passe, un mail vous a été envoyé";
		$user_id = $user->id;
		$entetes =
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'From: no-reply@camagru.fr' . "\r\n" .
		'Reply-To: no-reply@camagru.fr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$objet = "Réinitialisation de votre mot de passe";
		$content = "
		<h2><center>Réinitialisation du mot de passe</center></h2><br/><br/>
		Afin de réinitialiser ton mot de passe, il te suffit de cliquer sur ce lien:\n\nhttp://localhost:8080/camagru/vue/forgetPassword-page/reset.php?id=$user_id&token=$reset_token
		<br/><br/>
		<center>- L'équipe Camagru</center>";
		if (mail($_POST['email'], $objet, $content, $entetes))
		{
			$_SESSION['success'] = "Un email de confirmation a été envoyé pour valider le compte";
		}
		else {
			echo '<script>alert(" Email PAS envoyé")</script>';
		}
	}
	else {
		$_SESSION['danger'] = "Aucun compte ne correspond à cette adresse mail";
	}
}
?>

<?php
require_once dirname(__FILE__) .  '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
?>

<div class="title-msg">
	<center>Tu as oublié ton mot de passe?</center>
	<center><img src="../../images/arrow2.png" width="80px"/></center>
</div>
<div class="photo-frame">
	<div class="hashtag-msg-forget">
		#ItsOkay
	</div>
	<div class="photo"></div>
	<div class="message">
		Pas de panique! Renseignes l'email que tu utilises pour te connecter afin de recevoir un lien te permettant de réinitialiser ton mot de passe ;-)

	</div>
	<form class="form" action="" method="post">
		<input class="forget-input" type="email" name="email" placeholder="Email"/><br/>
		<input class="forget-submit" type="submit" value="Valider"><br/>
	</form>
</div>
<?php require_once dirname(__FILE__) . '/../footer/footer.php'; ?>
