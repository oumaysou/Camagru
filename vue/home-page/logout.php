<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
unset($_SESSION['auth']);
$_SESSION['success'] = "Vous êtes maintenant déconnecté";
header('Location: ./login-page.php');
?>
