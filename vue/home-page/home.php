<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
?>

<div class="title">
	<center><img id="img-login" src="../../images/logo.png" width="90px;"/></center>
		<center><img id="img-login" src="../../images/camagru.jpg" width="280px;"/></center>
</div>
<form class="container" action="" method="POST" enctype="multipart/form-data">
	<div class="wrapper-filter-webcam">
		<div class="wrapper-filter">
			<label><input id="1" type="radio" name="filter" value="1" onClick="getFilter(1);"></label>
			<img class="filter-img" src="../../images/donut.png" title="donut.png" width="60px"/>
			<label><input id="2" type="radio" name="filter" value="2" onClick="getFilter(2);"></label>
			<img class="filter-img" src="../../images/pizza.png" title="pizza.png" width="80px"/>
			<label><input id="3" type="radio" name="filter" value="3" onClick="getFilter(3);"/></label>
			<img class="filter-img" src="../../images/pow.png" title="pow.png" width="60px"/>
		</div>
		<video id="video" class="webcam-live" autoplay></video>
		<canvas id="canvas" style="display:none;"></canvas>
		<label><input type="file" name="MAX_FILE_SIZE" value=50000 name="img" onchange="get_img_upload(this)"/></label>
		<button id="sendbutton" >Envoyer la photo</button>
		<button id="startbutton">Prendre une photo</button>
	</div>
	<div class="wrapper-user-photo">
		<?php
		require_once dirname(__FILE__) . '/../../inc/db.php';
		try
		{
			$userid = $_SESSION['auth']->id;
			$photo_per_page = 9;
			$request = $pdo->prepare('SELECT * FROM photos WHERE user_id = ?');
			$request->execute([$userid]);
			$get_all = $request->fetchAll();
			$count_photos = count($get_all);
			$count_pages = ceil($count_photos / $photo_per_page);
			if (isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']))
			{
				if ($_GET['page'] > $count_pages)
				$current = $count_pages;
				else
				$current = $_GET['page'];
			}
			else
				$current = 1;
			$start = ($current - 1) * $photo_per_page;
			$req1 = $pdo->prepare('SELECT * FROM photos WHERE user_id = ? ORDER BY date_photo DESC LIMIT '.$start.','.$photo_per_page.'');
			$req1->execute([$userid]);
			$getID = $req1->fetchAll();

			echo '<div class="allPhotos">';
			foreach ($getID as $elem)
			{
					echo '<div class="photo-user">';
					echo '<img class="each-photo" src="'.$elem->photo_path.'" height="200px" />';
					echo "<input class='input-delete' type='button' value='Supprimer' onClick='deletePhoto(\"$elem->photo_path\", \"$elem->photo_id\", \"$userid\");'>";
					echo '</div>';
			}
			echo '</div>';
		}
		catch (PDOException $e)
		{
			echo "fail";
		}
		echo '<div class="pagination">';
		for ($i=1; $i<=$count_pages; $i++) {
			echo '<a href="home.php?page='.$i.'">'.$i.'</a> ';
			if ($i < $count_pages)
			echo "-";
		}
		echo '</div>';
		?>
	</div>
</form>
<script type="text/javascript" src="./webcam.js"></script>
<script type="text/javascript" src="./deletePhoto.js"></script>
<!-- <link rel="stylesheet" type="text/css" media="screen" href="../../css/camera.css" /> -->
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
