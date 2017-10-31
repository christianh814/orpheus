var currentPlayList = [];
var audioElement;

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //rounds down
	var seconds = time - (minutes * 60);
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("canplay", function() {
		// "this.duration" refers to this instance of "this.audio"..
		// ...so techinially it's this.audio.duration
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}
}
