function toggle(obj, photoid) {
	var like;
	console.log(obj);
	if (obj.className == "liked") {
		obj.className = "unliked";
		obj.src = "../../images/heart-4.png";
		like = 0;
	}
	else {
		obj.className = "liked";
		obj.src = "../../images/heart-3.png";
		like = 1;
	}
	var xml = new XMLHttpRequest();
	xml.open('POST', 'like.php', true);
	xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xml.send("photoid=" + photoid + "&like=" + like);
	xml.onload = function () {
		window.location.reload();
	}
}
