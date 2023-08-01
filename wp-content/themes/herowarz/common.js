
var DomainStatic = 'http://127.0.0.1/';
var chienluc = 1;

var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

if (isMobile.iOS() || isMobile.BlackBerry() || isMobile.Android() || isMobile.iOS()) {
    //window.location.href = 'https://www.facebook.com/WebSite';
}

function go_call_fancy_popup(elm, w, h) {
    if (typeof $.fn.fancybox != "undefined") {
        go_fancy_popup_iframe(elm, w, h);
    }
    else {
        $.getScript("Scripts/jquery.fancybox-1.3.4.html", function () {
            go_fancy_popup_iframe(elm, w, h);
        });
    }
}

function choiid_fancybox_opennowith(elm, href) {
    $.fancybox({
        afterLoad: function () {
            $.fancybox.update();
        },
        href: href,

        type: 'iframe',
        autoSize: false,
        overlayOpacity: 0.7,
        padding: 0,
        width: '400'
    });
    $.fancybox.toggle();

}

function choiid_fancybox_open(elm, href, w, h) {

    $.fancybox({
        href: href,
        type: 'iframe',
        padding: 0,
        width: w,
        height: h
    });

}
function choiid_fancybox_open1(elm, href, w, h) {

    $.fancybox({
        href: href,
        beforeShow: function () {
            this.skin.css({
                background: "none repeat scroll 0 0 #000000"
            });
        },
        type: 'iframe',
        padding: 0,
        width: w,
        height: h
    });

}
$('#linkregister').click(function () {

    choiid_fancybox_open("#fancybox-tmp", "./login.php", 600, 300);

	return false;
});



!window.jQuery.cookies && document.write(unescape('%3Cscript src="/js/jquery.cookie.js"%3E%3C/script%3E'));
getSource();

function getSource() {
    var source = grgup('utm_source');
    if (source != "") {
        var date = new Date();
        var minutes = 1440;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        $.cookie("utm_source", source, { expires: date });
    } 
}
function getAgency() {

    var source = $.cookie('utm_source');
   
    if (source != null) {
        if (source.indexOf("facebook") > -1) {
            return 1;
        }
        if (source.indexOf("google") > -1) {
            return 2;
        }
        if (source.indexOf("pfct") > -1) {
            return 3;
        }
        if (source.indexOf("coccoc") > -1) {
            return 4;
        }
        if (source.indexOf("nega") > -1) {
            return 5;
        }
        if (source.indexOf("playpark") > -1) {
            return 6;
        }
        if (source.indexOf("gamek") > -1) {
            return 7;
        }
        if (source.indexOf("xemgame") > -1) {
            return 8;
        }
        if (source.indexOf("game4v") > -1) {
            return 9;
        }
        if (source.indexOf("gamethu") > -1) {
            return 10;
        }
        if (source.indexOf("gamen") > -1) {
            return 11;
        }
        if (source.indexOf("hdviet") > -1) {
            return 12;
        }
        if (source.indexOf("truyen368") > -1) {
            return 13;
        }
        if (source.indexOf("voz") > -1) {
            return 14;
        }
        if (source.indexOf("blogtruyen") > -1) {
            return 15;
        }
        if (source.indexOf("goccay") > -1) {
            return 16;
        }
        if (source.indexOf("kenhgamez") > -1) {
            return 17;
        }
        if (source.indexOf("lol24h") > -1) {
            return 18;
        }
    }
    return 0;
}

function grgup(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null)
        return "";
    else
        return results[1];
}
