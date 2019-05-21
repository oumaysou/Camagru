function deletePhoto(photopath, photoID, userID) {
	if (confirm("Es-tu sûr de vouloir supprimer cette photo?"))
	{
		var xml = new XMLHttpRequest();
		xml.open('POST', 'deletePhoto.php', true);
		xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xml.send("photo_path=" + photopath + "&photo_id=" + photoID + "&userid=" + userID);
		xml.onload = function () {
			window.location.reload();
		}
	}
}
