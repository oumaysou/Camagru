<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
if (!empty($_POST) && isset($_POST['photo_path']) && isset($_POST['photo_id']) && isset($_POST['userid']))
{
	require_once dirname(__FILE__) . '/../../inc/db.php';
	//DELETE LIKE
	$request = $pdo->prepare('SELECT photo_id FROM likephoto');
	$request->execute();
	$getPhotosLiked = $request->fetchAll(PDO::FETCH_COLUMN, 0);
	foreach ($getPhotosLiked as $elem)
	{
		if ($elem == $_POST['photo_id'])
		{
			$req1 = $pdo->prepare('DELETE FROM likephoto WHERE photo_id = :photoid');
			$req1->execute(['photoid' => $_POST['photo_id']]);
		}
	}
	$request1 = $pdo->prepare('SELECT photo_id FROM comments WHERE photo_id = :photoID');
	$request1->execute(['photoID' => $_POST['photo_id']]);
	$getComments = $request1->fetchAll(PDO::FETCH_COLUMN, 0);
	//DELETE COMMENTS
	foreach ($getComments as $comments)
	{
		if ($comments == $_POST['photo_id'])
		{
			$req1 = $pdo->prepare('DELETE FROM comments WHERE photo_id = :photoid');
			$req1->execute(['photoid' => $_POST['photo_id']]);
		}
	}
	//DELETE FROM DIRECTORY
	unlink($_POST['photo_path']);
	//DELETE PHOTO FROM DB
	$req1 = $pdo->prepare('DELETE FROM photos WHERE photo_id = :photoid');
	$req1->execute(['photoid' => $_POST['photo_id']]);
}
?>
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
