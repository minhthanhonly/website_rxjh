

var baseVol = 0.5; //audioのベースの音量
var fadeSpeed = 2000; //フェードイン・フェードアウトのスピード
var audioCont = new Audio();
var isAudio = true;
(function() {
	var ua = navigator.userAgent;
	var isMobile = (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 || ua.indexOf('iPad') > 0);
	if(!isMobile) {
		audioCont.src = '/assets/music/bgm01.mp3';
		audioCont.load();
		audioCont.loop = true;
	} else{
        $('.fixedParts').hide()
    }
})();

//
function addOnBlurListener(onBlurCallback, onFocusCallback) {
	var hidden, visibilityState, visibilityChange; // check the visiblility of the page

	if (typeof document.hidden !== "undefined") {
	  hidden = "hidden"; visibilityChange = "visibilitychange"; visibilityState = "visibilityState";
	} else if (typeof document.mozHidden !== "undefined") {
	  hidden = "mozHidden"; visibilityChange = "mozvisibilitychange"; visibilityState = "mozVisibilityState";
	} else if (typeof document.msHidden !== "undefined") {
	  hidden = "msHidden"; visibilityChange = "msvisibilitychange"; visibilityState = "msVisibilityState";
	} else if (typeof document.webkitHidden !== "undefined") {
	  hidden = "webkitHidden"; visibilityChange = "webkitvisibilitychange"; visibilityState = "webkitVisibilityState";
	}
	if (typeof document.addEventListener === "undefined" || typeof hidden === "undefined") {
	  // not supported
	} else {
	  document.addEventListener(visibilityChange, function() {
		switch (document[visibilityState]) {
		  case "visible":
			if (onFocusCallback) onFocusCallback();
			break;
		  case "hidden":
			if (onBlurCallback) onBlurCallback();
			break;
		}
	  }, false);
	}
}
//
function audioContStart(){
	var ua = navigator.userAgent;
	var isMobile = (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 || ua.indexOf('iPad') > 0);
	if(!isMobile && isAudio){
		audioCont.volume = 0;
		var intervalPlay = false;
		var promise = audioCont.play();
		if (promise !== undefined) {
			promise.then(function() {
			}).catch(function(error){
				$('.soundBtn').addClass('off');
				isAudio = false;
				intervalPlay = setInterval(function(){
					var promise = audioCont.play();
					if(!audioCont.paused){
						clearInterval(intervalPlay);
					}
					promise.then(function() {
						$('.soundBtn').removeClass('off');
						isAudio = true;
					}).catch(function(error){
					});
				}, 1000);
			});
		}
		var volumeFadeIn = setInterval(function() {
			audioCont.volume = audioCont.volume + (baseVol / 100);
			if(audioCont.volume >= baseVol - (baseVol / 100)) {
				audioCont.volume = baseVol;
				clearInterval(volumeFadeIn);
			}
		}, fadeSpeed * baseVol / 100);


		addOnBlurListener(function(){
			audioCont.muted = true;
		},
		function(){
			audioCont.muted = false;
		});
	}
}
function audioContStop(){
	var ua = navigator.userAgent;
	var isMobile = (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 || ua.indexOf('iPad') > 0);
	if(!isMobile) {
		var volumeFadeOut = setInterval(function() {
	        var vol = audioCont.volume - (baseVol / 100);
			audioCont.volume = vol < 0 ? 0: vol;
	        if(audioCont.volume <= (baseVol / 100)) {
	            audioCont.volume = baseVol;
	            audioCont.pause();
	            clearInterval(volumeFadeOut);
	        }
	    }, fadeSpeed * baseVol / 100);
	}
}

$(function(){
    var isStopAudio = localStorage.getItem("isStopAudio");
    if(isStopAudio) {
        isAudio = false;
        $('.soundBtn').addClass('off');
    }else{
        isAudio = true;
    }
    if(isAudio) audioContStart();
    $('.soundBtn').on('click',function(el){
		$('.soundBtn').toggleClass('off');
		isAudio = !isAudio;
		if(isAudio){
			audioContStart();
            localStorage.removeItem("isStopAudio");
		}else{
			audioContStop();
            localStorage.setItem("isStopAudio", true);
		}
		return false;
	});
});