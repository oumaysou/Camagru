<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';
if (!empty($_POST) && isset($_POST['photoid']) && isset($_POST['like']))
{
	$user_id = $_SESSION['auth']->id;
	if ($_POST['like'] == 1)
	{
		$req = $pdo->prepare("INSERT INTO likephoto SET userlike_id = :userwholiked, date_like = NOW() ,	photo_id = :photoid");
		$req->execute([
			'userwholiked' => $user_id,
			'photoid' => $_POST['photoid']
		]);
	}
	else if ($_POST['like'] == 0)
	{
		$req = $pdo->prepare('DELETE FROM likephoto where photo_id = :photoid AND userlike_id = :userwholiked');
		$req->execute([
			'photoid' => $_POST['photoid'],
			'userwholiked' => $user_id
		]);
	}
}
?>
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
