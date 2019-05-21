<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';
if (!empty($_POST) && isset($_POST['password']) && isset($_POST['confirm-password']))
{
	$errors = array();
	if ($_POST['password'] == "" || $_POST['confirm-password'] == "")
	$errors['empty'] = "Le champ mot de passe est vide";
	else if ($_POST['password'] != $_POST['confirm-password'])
	$errors['dontmatch'] = "Les mots de passe ne correspondent pas";
	else {
		$req = $pdo->prepare('SELECT * from User WHERE username = :username AND confirmation_at IS NOT NULL');
		$req->execute([
			'username' => $_SESSION['auth']->username
		]);
		$user = $req->fetch();
		if ($user && password_verify($_POST['password'], $user->password))
		{
			//DELETE PHOTOS FROM DIRECTORY
			$dirPath = "../photos/" . $_SESSION['auth']->username;
			delete_all_photos_and_directory($dirPath);
			//DELETE PHOTOS FROM DB
			$req = $pdo->prepare('DELETE FROM photos where user_id = :userid');
			$req->execute(['userid' => $_SESSION['auth']->id
		]);
		//DELETE ALL LIKE
		$request_like = $pdo->prepare('SELECT userlike_id FROM likephoto WHERE userlike_id = :userid');
		$request_like->execute(['userid' => $_SESSION['auth']->id]);
		$getLike = $request_like->fetchAll(PDO::FETCH_COLUMN, 0);
		if ($getLike)
		{
			$req = $pdo->prepare('DELETE FROM likephoto WHERE userlike_id = :userid');
			$req->execute(['userid' => $_SESSION['auth']->id]);
		}
		//DELETE ALL COMMENTS
		$request_comment = $pdo->prepare('SELECT usercomment_id FROM comments WHERE usercomment_id = :userid');
		$request_comment->execute(['userid' => $_SESSION['auth']->id]);
		$getComment = $request_comment->fetchAll(PDO::FETCH_COLUMN, 0);
		if ($getComment)
		{
			$req = $pdo->prepare('DELETE FROM comments WHERE usercomment_id = :userid');
			$req->execute(['userid' => $_SESSION['auth']->id]);
		}
		//DELETE ACCOUNT FROM DB
		$req = $pdo->prepare('DELETE from User WHERE username = :username');
		$req->execute([
			'username' => $_SESSION['auth']->username
		]);
		session_start();
		unset($_SESSION['auth']);
		session_destroy();
		$_SESSION['success'] = "Votre compte a bien été supprimé";
		header('Location: /../vue/home-page/login-page.php');
		exit();
		}
		else {
			$errors['no-match'] = "Mot de passe incorrect";
		}
	}
}
?>
<div class="title">
	<center><img id="img-login" src="../../images/logo.png" width="90px;"/></center>
	<center><img id="img-login" src="../../images/collage-1.jpg" width="160px;"/></center>
</div>
<form class="delete-account" action="" method="post">
	<?php if (!empty($errors)): ?>
		<div class="danger">
			<?php foreach($errors as $error):?>
				<li><?=$error;?></li>
			<?php endforeach;?>
		</div>
	<?php 	endif; ?>
	<div class="msg-delete-account">
		Afin de supprimer définitivement votre compte, veuillez entrer votre mot de passe.
	</div>
	<input class="input-password" type="password" name="password" placeholder="Entrer le mot de passe"/>
	<input class="input-password" type="password" name="confirm-password" placeholder="Entrer à nouveau le mot de passe"/>
	<input class="submit-delete-account" type="submit" value="Supprimer mon compte"><br/>

</form>
<?php require dirname(__FILE__) . '/../footer/footer.php'?>
