<div class="page">
	<div class="wrapper-navbar">
	<div class="header">
		<?php if (isset($_SESSION['auth'])): ?>
		<a class="user-input" href="/../vue/home-page/logout.php">Se Déconnecter</a>
		<a class="user-input" href="/../vue/account-page/account.php">Compte</a>
		<a class="user-input" href="/../vue/home-page/home.php">Accueil</a>
		<?php endif;?>
		<a class="user-input" href="/../vue/gallery-page/gallery.php">Galerie</a>
		<?php if (!isset($_SESSION['auth'])): ?>
		<a class="user-input" href="/../vue/register-page/register.php">S'Inscrire</a>
		<a class="user-input" href="/../index.php">Se Connecter</a>
		<?php endif;?>
	</div>
	<?php if (isset($_SESSION['success'])):?>
	<div class="success">
		<?= $_SESSION['success'] ?>
	</div>
	<?php unset($_SESSION['success']); ?>
	<?php endif; ?>
	<?php
	if (isset($_SESSION['danger'])):?>
	<div class="danger">
		<?= $_SESSION['danger']?>
	</div>
	<?php unset($_SESSION['danger']); ?>
	<?php endif; ?>
	</div>
