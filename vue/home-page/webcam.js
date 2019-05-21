var streaming = false,
	video = document.querySelector('#video'),
	cover = document.querySelector('#cover'),
	canvas = document.querySelector('#canvas'),
	photo = document.querySelector('#photo'),
	startbutton = document.querySelector('#startbutton'),
	sendbutton = document.querySelector('#sendbutton'),
	filter = 0,
	img_upload,
	upload = 0,
	width = 520,
	error_webcam = 0,
	height = 0;

if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	// Not adding `{ audio: true }` since we only want video now
	navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
		//video.src = window.URL.createObjectURL(stream);
		video.srcObject = stream;
		video.play();
	});
}

function getFilter(num) {
	filter = num;
	if (error_webcam == 0)
		startbutton.disabled = false;
	if (upload == 1)
		sendbutton.disabled = false;
}

function sendData_webcam(data) {
	var xml = new XMLHttpRequest()
	xml.open('POST', 'get-webcam-photo.php', true);
	xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xml.send("data=" + data + "&filter=" + filter);
	xml.onload = function () {
		window.location.reload();
	}
}
// Prendre photo + envoie
function takepicture() {
	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	var data = canvas.toDataURL('image/png');
	sendData_webcam(data);
}


function isInArray(extensions, extension) {
	return extensions.indexOf(extension.toLowerCase()) > -1;
}
function get_img_upload(img) {
	if (img.length != 0) {
		var name = img.files[0].name;
		var res = name.split('.');
		var nb_elem = res.length;
		var extension = res[nb_elem - 1];
		var allowedExtensions = ["png", "jpg", "jpeg", "PNG", "JPG", "JPEG"];
		if (!isInArray(allowedExtensions, extension)) {
			upload = 0;
			alert("Le fichier sélectionné n'est pas une image");
			sendbutton.disabled = true;
			startbutton.disabled = false;
		}
		else {
			upload = 1;
			img_upload = img;
			if (filter != 0)
				sendbutton.disabled = false;
		}
	}
	else
		upload = 0;
}
function check_img_extension(img) {
	var length = img.length;
	var start = length - 4;
	var end = length;
}

// Start JS
video.addEventListener('canplay', function (ev) {
	if (!streaming) {
		height = video.videoHeight / (video.videoWidth / width);
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
		streaming = true;
	}
}, false);
startbutton.addEventListener('click', function (ev) {
	takepicture();
	ev.preventDefault();
}, false);
sendbutton.addEventListener('click', function (ev) {
	if (upload == 1)
		sendData_upload(img_upload, upload);
	ev.preventDefault();
}, false);

function sendData_upload(data, upload) {
	var img_data;
	if (upload == 1) {
		const reader = new FileReader();
		const file = data.files[0];
		reader.onload = function (upload) {
			img_data = upload.target.result;
			var xml = new XMLHttpRequest()
			xml.open('POST', 'get-webcam-photo.php', true);
			xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xml.send("data=" + img_data + "&filter=" + filter);
			xml.onload = function () {
				window.location.reload();
			}
		};
		reader.readAsDataURL(file);
	}
}