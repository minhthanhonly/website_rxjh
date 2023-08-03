

var baseVol = 0.5; //audioのベースの音量
var fadeSpeed = 2000; //フェードイン・フェードアウトのスピード
var audioCont = new Audio();
var isAudio = true;
(function () {
    var ua = navigator.userAgent;
    var isMobile = (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 || ua.indexOf('iPad') > 0);
    if (!isMobile) {
        audioCont.src = '/assets/music/bgm01.mp3';
        audioCont.load();
        audioCont.loop = true;
    } else {
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
        document.addEventListener(visibilityChange, function () {
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
function audioContStart() {
    var ua = navigator.userAgent;
    var isMobile = (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 || ua.indexOf('iPad') > 0);
    if (!isMobile && isAudio) {
        audioCont.volume = 0;
        var intervalPlay = false;
        var promise = audioCont.play();
        if (promise !== undefined) {
            promise.then(function () {
            }).catch(function (error) {
                $('.soundBtn').addClass('off');
                isAudio = false;
                intervalPlay = setInterval(function () {
                    var promise = audioCont.play();
                    if (!audioCont.paused) {
                        clearInterval(intervalPlay);
                    }
                    promise.then(function () {
                        $('.soundBtn').removeClass('off');
                        isAudio = true;
                    }).catch(function (error) {
                    });
                }, 1000);
            });
        }
        var volumeFadeIn = setInterval(function () {
            audioCont.volume = audioCont.volume + (baseVol / 100);
            if (audioCont.volume >= baseVol - (baseVol / 100)) {
                audioCont.volume = baseVol;
                clearInterval(volumeFadeIn);
            }
        }, fadeSpeed * baseVol / 100);


        addOnBlurListener(function () {
            audioCont.muted = true;
        },
            function () {
                audioCont.muted = false;
            });
    }
}
function audioContStop() {
    var ua = navigator.userAgent;
    var isMobile = (ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 || ua.indexOf('iPad') > 0);
    if (!isMobile) {
        var volumeFadeOut = setInterval(function () {
            var vol = audioCont.volume - (baseVol / 100);
            audioCont.volume = vol < 0 ? 0 : vol;
            if (audioCont.volume <= (baseVol / 100)) {
                audioCont.volume = baseVol;
                audioCont.pause();
                clearInterval(volumeFadeOut);
            }
        }, fadeSpeed * baseVol / 100);
    }
}

$(function () {
    var isStopAudio = localStorage.getItem("isStopAudio");
    if (isStopAudio) {
        isAudio = false;
        $('.soundBtn').addClass('off');
    } else {
        isAudio = true;
    }
    if (isAudio) audioContStart();
    $('.soundBtn').on('click', function (el) {
        $('.soundBtn').toggleClass('off');
        isAudio = !isAudio;
        if (isAudio) {
            audioContStart();
            localStorage.removeItem("isStopAudio");
        } else {
            audioContStop();
            localStorage.setItem("isStopAudio", true);
        }
        return false;
    });




    var LeafScene = function (el) {
        this.viewport = el;
        this.world = document.createElement('div');
        this.leaves = [];

        this.options = {
            numLeaves: 15,
            wind: {
                magnitude: 1,
                maxSpeed: 3,
                duration: 600,
                start: 0,
                speed: 0
            },
        };

        this.width = this.viewport.offsetWidth;
        this.height = this.viewport.offsetHeight;

        // animation helper
        this.timer = 0;

        this._resetLeaf = function (leaf) {

            // place leaf towards the top left
            leaf.x = this.width * 1 - Math.random() * this.width * 1.75;
            leaf.y = -2;
            leaf.z = Math.random() * 200;
            if (leaf.x > this.width) {
                leaf.x = this.width + 10;
                leaf.y = Math.random() * this.height / 2;
            }
            // at the start, the leaf can be anywhere
            if (this.timer == 0) {
                leaf.y = Math.random() * this.height;
            }

            // Choose axis of rotation.
            // If axis is not X, chose a random static x-rotation for greater variability
            leaf.rotation.speed = Math.random() * 5;
            var randomAxis = Math.random();
            if (randomAxis > 0.5) {
                leaf.rotation.axis = 'X';
            } else if (randomAxis > 0.25) {
                leaf.rotation.axis = 'Y';
                leaf.rotation.x = Math.random() * 180 + 90;
            } else {
                leaf.rotation.axis = 'Z';
                leaf.rotation.x = Math.random() * 360 - 180;
                // looks weird if the rotation is too fast around this axis
                leaf.rotation.speed = Math.random() * 3;
            }

            // random speed
            leaf.xSpeedVariation = - Math.random() * 5 - 0.4;
            leaf.ySpeed = Math.random() + 0.5;

            return leaf;
        }

        this._updateLeaf = function (leaf) {
            var leafWindSpeed = this.options.wind.speed(this.timer - this.options.wind.start, leaf.y);

            var xSpeed = leafWindSpeed + leaf.xSpeedVariation;
            leaf.x -= xSpeed;
            leaf.y += leaf.ySpeed;
            leaf.rotation.value += leaf.rotation.speed;

            var t = 'translateX( ' + leaf.x + 'px ) translateY( ' + leaf.y + 'px ) translateZ( ' + leaf.z + 'px )  rotate' + leaf.rotation.axis + '( ' + leaf.rotation.value + 'deg )';
            if (leaf.rotation.axis !== 'X') {
                t += ' rotateX(' + leaf.rotation.x + 'deg)';
            }
            leaf.el.style.webkitTransform = t;
            leaf.el.style.MozTransform = t;
            leaf.el.style.oTransform = t;
            leaf.el.style.transform = t;

            // reset if out of view
            if (leaf.x < -10 || leaf.y > this.height + 10) {
                this._resetLeaf(leaf);
            }
        }

        this._updateWind = function () {
            // wind follows a sine curve: asin(b*time + c) + a
            // where a = wind magnitude as a function of leaf position, b = wind.duration, c = offset
            // wind duration should be related to wind magnitude, e.g. higher windspeed means longer gust duration

            if (this.timer === 0 || this.timer > (this.options.wind.start + this.options.wind.duration)) {

                this.options.wind.magnitude = Math.random() * this.options.wind.maxSpeed;
                this.options.wind.duration = this.options.wind.magnitude * 50 + (Math.random() * 20 - 10);
                this.options.wind.start = this.timer;

                var screenHeight = this.height;

                this.options.wind.speed = function (t, y) {
                    // should go from full wind speed at the top, to 1/2 speed at the bottom, using leaf Y
                    var a = this.magnitude / 2 * (screenHeight - 2 * y / 3) / screenHeight;
                    return a * Math.sin(2 * Math.PI / this.duration * t + (3 * Math.PI / 2)) + a;
                }
            }
        }
    }

    LeafScene.prototype.init = function () {

        for (var i = 0; i < this.options.numLeaves; i++) {
            var leaf = {
                el: document.createElement('div'),
                x: 0,
                y: 0,
                z: 0,
                rotation: {
                    axis: 'X',
                    value: 0,
                    speed: 0,
                    x: 0
                },
                xSpeedVariation: 0,
                ySpeed: 0,
                path: {
                    type: 1,
                    start: 0,

                },
                image: 1
            };
            this._resetLeaf(leaf);
            this.leaves.push(leaf);
            this.world.appendChild(leaf.el);
        }

        this.world.className = 'leaf-scene';
        this.viewport.appendChild(this.world);

        // set perspective
        this.world.style.webkitPerspective = "400px";
        this.world.style.MozPerspective = "400px";
        this.world.style.oPerspective = "400px";
        this.world.style.perspective = "400px";

        // reset window height/width on resize
        var self = this;
        window.onresize = function (event) {
            self.width = self.viewport.offsetWidth;
            self.height = self.viewport.offsetHeight;
        };
    }

    LeafScene.prototype.render = function () {
        this._updateWind();
        for (var i = 0; i < this.leaves.length; i++) {
            this._updateLeaf(this.leaves[i]);
        }

        this.timer++;

        requestAnimationFrame(this.render.bind(this));
    }

    // start up leaf scene
    var leafContainer = document.querySelector('.falling-leaves'),
        leaves = new LeafScene(leafContainer);

    leaves.init();
    leaves.render();
});