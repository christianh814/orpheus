// Variables
var currentPlayList = [];
var shufflePlayList = [];
var tempPlayList = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

//Events
$(document).click(function(click) {
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
});

$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = select.val();
	var songId = select.prev(".songId").val();

	$.post("includes/handlers/ajax/add_to_playlist.php", {playlist_id: playlistId, song_id: songId}).done(function(error) {
		if(error != "") {
			alert(error);
			return;
		}
		hideOptionsMenu();
		select.val("");
	});
});

// Functions
function hideOptionsMenu() {
	var menu = $(".optionsMenu");
	if(menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

function showOptionsMenu(button) {
	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionsMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop(); //distance from top of window to top of document
	var elementOffset = $(button).offset().top; //distance from top of document

	var top = elementOffset - scrollTop;
	var left = $(button).position().left;

	menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline"});
}

function openPage(url) {
	if (timer != null) {
		clearTimeout(timer);
	}
	//
	if (url.indexOf("?") == -1) {
		url = url + "?";
	}
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function removeFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();
	$.post("includes/handlers/ajax/remove_from_playlist.php", { playlist_id: playlistId, song_id: songId }).done(function(error) {
		//do something when AJAX returns
		if(error != "") {
			alert(error);
			return;
		}
			openPage("playlist.php?id=" + playlistId);
	});
}

function createPlaylist() {
	var popup = prompt("Please enter a name for your playlist");

	if(alert != null) {
		$.post("includes/handlers/ajax/create_playlist.php", {name: popup, username: userLoggedIn}).done(function(error) {
			//do something when AJAX returns
			if(error != "") {
				alert(error);
				return;
			}
				openPage("yourmusic.php");
		});
	}
}

function deletePlaylist(playlistid) {
	var warn = confirm("Are you sure you want to delete this playlist?");

	if(warn) {
		$.post("includes/handlers/ajax/delete_playlist.php", { playlist_id: playlistid }).done(function(error) {
			//do something when AJAX returns
			if(error != "") {
				alert(error);
				return;
			}
				openPage("yourmusic.php");
		});
	}
}

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //rounds down
	var seconds = time - (minutes * 60);
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	// Update progressbar
	var progress = (audio.currentTime / audio.duration) * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
	// Update volumebar
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(tempPlayList[0], tempPlayList, true);
}

function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	// Make sure the next song plays after the first song finishes
	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		// "this.duration" refers to this instance of "this.audio"..
		// ...so techinially it's this.audio.duration
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate", function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
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

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}
}
