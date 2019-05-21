<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';
$user_id = $_SESSION['auth']->id;

function update_user($user_id) {
	require dirname(__FILE__) . '/../../inc/db.php';
	$request = $pdo->prepare('SELECT * FROM User WHERE id = :id');
	$request->execute(['id' => $user_id]);
	$user = $request->fetch();
	$_SESSION['auth'] = $user;
}
$name = 0;
$username = 0;
$email = 0;
$password = 0;
$mail_comments = 0;
$errors = array();
if (!empty($_POST))
{
	if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['confirm-name']) && $_POST['confirm-name'] != "")
	{
		if ($_POST['name'] != $_POST['confirm-name'])
			$errors['username'] = "Les noms ne correspondent pas";
		else
			$errors = check_name($_POST['name'], $errors);
		if (!isset($errors['name']))
		$name = 1;
	}
	if (isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['confirm-username']) && $_POST['confirm-username'] != "")
	{
		if ($_POST['username'] != $_POST['confirm-username'])
			$errors['username'] = "Les identifiants ne correspondent pas";
		else
			$errors = check_username($_POST['username'], $errors);
		if (!isset($errors['username']))
			$username = 1;
	}
	if (isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['confirm-email']) && $_POST['confirm-email'] != "")
	{
		$errors = check_email($_POST['email'], $_POST['confirm-email'], $errors);
		if (!isset($errors['email']))
			$email = 1;
	}
	if (isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['confirm-password']) && $_POST['confirm-password'] != "")
	{
		$errors = check_password($_POST['password'], $_POST['confirm-password'], $errors);
		if (!isset($errors['password']))
			$password = 1;
	}
	if (isset($_POST['mail-comments']) && $_POST['mail-comments'] != "")
	{
		$answer = ($_POST['mail-comments'] == 1) ? 1 : 0;
		$req = $pdo->prepare('SELECT mail_comments FROM User WHERE id = :id');
		$req->execute(['id' => $user_id]);
		$user = $req->fetch();
		if ($user->mail_comments == $_POST['mail-comments'])
		{
			$str = ($answer == 1) ? "Vous avez déjà choisi l'option recevoir un mail lorsqu'un utilisteur commente une de vos photos" : "Vous avez déjà choisi l'option de ne pas recevoir de mail lorsqu'un utilisateur commente une de vos photos";
			$errors['mail-comments'] = $str;
		}
		else
			$mail_comments = 1;
	}
	if (empty($errors) && ($name || $username || $email || $password || $mail_comments))
	{
		if ($name)
		{
			$req = $pdo->prepare('UPDATE User SET name = :name WHERE id = :id');
			$req->execute([
				'name' => htmlspecialchars($_POST['name']),
				'id' => $user_id
			]);
		}
		if ($username) {
			$req1 = $pdo->prepare('UPDATE User SET username = :username WHERE id = :id');
			$req1->execute([
				'username' => htmlspecialchars($_POST['username']),
				'id' => $user_id
			]);
		}
		if ($email) {
			$req2 = $pdo->prepare('UPDATE User SET email = :email WHERE id = :id');
			$req2->execute([
				'email' => $_POST['email'],
				'id' => $user_id
			]);
		}
		if ($password) {
			$new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$req3 = $pdo->prepare('UPDATE User SET password = :password WHERE id = :id');
			$req3->execute([
				'password' => $new_password,
				'id' => $user_id
			]);
		}
		if ($mail_comments)
		{
			echo "UPD-comments";
			$req4 = $pdo->prepare('UPDATE User SET mail_comments = :mail_comments WHERE id = :id');
			$req4->execute([
				'mail_comments' => $_POST['mail-comments'],
				'id' => $user_id
			]);
		}
		update_user($user_id);
		$_SESSION['success'] = "Vos informations ont bien été mises à jour";
		header('Location: account.php');
		exit();
	}
}
?>
<div class="title">
	<center><img id="img-login" src="../../images/logo.png" width="90px;"/></center>
	<center><img id="img-login" src="../../images/account.jpg" width="160px;"/></center>
</div>
<div class="wrapper">
	<div class="user">
	<div class="user-info">
		<span class="hashtag-msg">#AboutMe</span>
		<span class="info">
		<h1>Nom</h1>
		<?= $_SESSION['auth']->name; ?><br/>
		<h1>Username</h1>
		<?= $_SESSION['auth']->username; ?><br/>
		<h1>Email</h1>
		<?= $_SESSION['auth']->email; ?><br/>
	</span>
	</div>
</div>
	<div class="wrapper-modifier">
		<?php if (!empty($errors)): ?>
			<div class="danger">
				<?php foreach($errors as $error):?>
					<li><?=$error;?></li>
				<?php endforeach;?>
			</div>
		<?php 	endif; ?>
	<form class="change-user-info" action="" method="post">
		<h1>Modifier mon compte</h1>
		<span class="text">Nom</span>
		<div class="form-group">
			<input class="input-change" type="text" name="name" placeholder="Nouveau nom"/>
		</div>
		<div class="form-group">
			<input class="input-change" type="text" name="confirm-name" placeholder="Confirmation du nouveau nom"/>
		</div>
		<span class="text">Identifiant</span>
		<div class="form-group">
			<input class="input-change" type="text" name="username" placeholder="Nouveau identifiant"/>
		</div>
		<div class="form-group">
			<input class="input-change" type="text" name="confirm-username" placeholder="Confirmation du nouveau identifiant"/>
		</div>
		<span class="text">Email</span>
		<div class="form-group">
			<input class="input-change" type="email" name="email" placeholder="Changer mon email"/>
		</div>
		<div class="form-group">
			<input class="input-change" type="email" name="confirm-email" placeholder="Confirmation du nouveau email"/>
		</div>
		<span class="text">Mot de passe</span>
		<div class="form-group">
			<input class="input-change" type="password" name="password" placeholder="Changer de mot de passe"/>
		</div>
		<div class="form-group">
			<input class="input-change" type="password" name="confirm-password" placeholder="Confirmation du nouveau mot de passe"/>
		</div>
		<span class="text">Option Commentaires</span>
		<div class="option-mail-comment">
			<div class="form-group">
				<label><input id="1" type="radio" name="mail-comments" value="1"> Oui, je souhaite recevoir un mail lorsqu'un utilisateur a commenté une de mes photos</label>
			</div>
		</br>
		<div class="form-group">
			<label><input id="2" type="radio" name="mail-comments" value="0"> Non, je ne souhaite pas recevoir de mail lorsqu'un utilisateur a commenté une de mes photos</label>
		</div>
	</div>
	<a href="./delete-account.php">
   <input class="delete-account-submit" type="button" value="Supprimer compte"/>
</a>
	<input class="validate-change-submit" type="submit" value="Sauvergarder les modifications"><br/>
</form>
</div>
</div>
<?php require dirname(__FILE__) . '/../footer/footer.php'?>
