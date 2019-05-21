<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
if (!empty($_POST) && isset($_POST['commentID']) && $_POST['commentID'] != "")
{
	require_once dirname(__FILE__) . '/../../inc/db.php';
	$req = $pdo->prepare('DELETE FROM comments where comment_id = :commentid');
	$req->execute(['commentid' => $_POST['commentID']]);
}
?>
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
