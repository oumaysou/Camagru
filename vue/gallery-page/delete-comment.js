function deleteComment(comment_id) {
	if (confirm("Es-tu sûr de vouloir supprimer ce commentaire?")) {
		var xml = new XMLHttpRequest();
		xml.open('POST', 'deleteComment.php', true);
		xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xml.send("commentID=" + comment_id);
		xml.onload = function () {
			window.location.reload();
		}
	}
}
