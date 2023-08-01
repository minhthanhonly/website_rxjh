<?php
	session_start();
	require "./include/define.php";
	require "./include/conn.php";
	require "./include/gump.class.php";
	require "./include/gameconn.php";
//
// index.php code bellow
// ...
//
?>
<!DOCTYPE html>
<html>

<!-- Mirrored from www.hk-dv.net/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Nov 2022 02:47:11 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>.:: Hiệp Khách Giang Hồ ::.</title>
<link rel="shortcut icon" href="http://yulgang.mgame.com/favicon.ico" type="image/x-icon">
<link href="content/webfont_new.css" type="text/css" rel="stylesheet">
<link href="content/main_new.css" type="text/css" rel="stylesheet">
<link href="content/popup_new.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="../cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">

	    <!-- Required meta tags -->
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="google-site-verification" content="pREndLVVRadvwpFjs6eOgxzKXLUFwBzxlimyHVU-8m8" />
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127045668-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-127045668-1');
		          function killCopy(e){ 
            return false } 
        function reEnable(){ 
            return true } 
        document.onselectstart = new Function (“return false”) 
        
        if (window.sidebar){  
            document.onmousedown=killCopy 
            document.onclick=reEnable 
		</script>

		<meta name="keywords" content="hiepkhachgiangho.vn,hk-dv.net,hkkteam,hiepkhach,hiep khach,hiepkhachgiangho,hiep khach giang ho,hiep khach dv,hiep khach kteam,hk k team,hk kteam,hkgh,yulgang online,yulgang">
		<!-- START: Facebook Meta -->
		<meta property="fb:app_id"	content="227255975199766"> 
		<meta property="og:title" content=".: Hiệp Khách Giang Hồ -  Phiên bản mới nhất :.">
		<meta property="og:type" content="game">
		<meta property="og:url" content="http://hiepkhachgiangho.vn">
		<meta property="og:image" content="http://hiepkhachgiangho.vn/imgfb.png">
		<meta property="og:site_name" content="hiepkhachgiangho.vn">
		<meta name="description" content="ฏ๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎ํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํ Hiệp Khách Giang Hồ, Hiệp Khách Kteam Hiệp Khách v17, Hiệp Khách Thăng Thiên 5, hkkteam"/>
		<meta property="og:description" content="ฏ๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎๎ํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํํ Hiệp Khách Giang Hồ, Hiệp Khách Kteam, Hiệp Khách v20 Hiệp Khách Thăng Thiên 5, hkkteam"/>
	
	<!--
		 _   _ _  ______     __     __                         _   _      _   
		| | | | |/ /  _ \  __\ \   / /   _  ___  _ __   __ _  | \ | | ___| |_ 
		| |_| | ' /| | | |/ _ \ \ / / | | |/ _ \| '_ \ / _` | |  \| |/ _ \ __|
		|  _  | . \| |_| |  __/\ V /| |_| | (_) | | | | (_| |_| |\  |  __/ |_ 
		|_| |_|_|\_\____/ \___| \_/  \__,_|\___/|_| |_|\__, (_)_| \_|\___|\__|
													   |___/                  
				
	-->
	
<script type="text/javascript" src="content/design_v1.js"></script>
<script type="text/javascript" src="content/common_func(1).js"></script>
<script type="text/javascript" src="content/mzzang.v4(1).js"></script>
<script type="text/javascript" src="content/mymgame.js"></script>


<style>
.header {
  -webkit-box-sizing: content-box;
     -moz-box-sizing: content-box;
          box-sizing: content-box;
}
.footer {
	background: #737373;
}
address {
	color: #fff;
}
.email {
	color: #fff;
}

body {
	background: #252525 url('images/bg-content-yulgang.png');
	background-size: cover;
	font-family: Tahoma;
	color:#ffffff;
}
</style>

</head>
<body style="background-color:#252525;color:#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


	<div class="wrap">
		<div class="header">
			<h1><a href="/"><img src="content/logo.png"></a></h1>
			<ul class="gnb">
				<li class="dir">
					<a href="./?a=reg">ĐĂNG KÝ</a>
				</li>
				<li class="dir">
					<a href="./?a=donate">NẠP THẺ</a>
				</li>
				<li class="dir">
					<a href="./?a=download">TẢI VỀ</a>
				</li>
				<li class="dir">
					<a href="./?a=ranking">XẾP HẠNG</a>
				</li>
				<li class="dir">
					<a href="./?a=webshop">CỬA HÀNG</a>
				</li>
				<li class="dir">
					<a href="./?a=forum">DIỄN ĐÀN</a>
				</li>
			</ul>
			<div class="gamestart">
				<a href="./?a=download"><img src="content/btn_start_main.jpg" alt="Tải game"></a>
			</div>
			<div class="login">

				<fieldset class="fLogin main">
					<form name="f" id="f" method="post" action="./?a=login">
						<div class="input">
							<input type="text" name="username" id="username" autocomplete="off" class="id text" placeholder="Tài khoản" minlength="4" maxlength="32" autocomplete="off" required="" pattern="[A-Za-z0-9]+">
							<input type="password" name="password" id="password" autocomplete="off" class="pw text" placeholder="Mật khẩu" minlength="4" maxlength="32" autocomplete="off" required="" pattern="[A-Za-z0-9]+">
							<a href="#login">
								<style>
								.btn-block {
									display: block;
									width: 98%;
								}
								.btn-primary {
									color: #fff;
									background-color: #007bff;
								}
								.btn {
									display: inline-block;
									text-align: center;
									white-space: nowrap;
									vertical-align: middle;
									border: transparent;
									padding: .375rem .75rem;
									font-size: 1rem;
									cursor: pointer;
								}
								</style>
								<input onClick="clicked(event)" class="btn btn-primary btn-block" type="submit" value="Đăng nhập"/>
							</a>
						</div>
						<div class="member">
							<a href="?a=reg" target="_blank">Đăng ký</a> <span>|</span>
							<a href="?a=lostpass" target="_blank">Quên mật khẩu?</a>
						</div>
					</form>
				</fieldset>
			</div>
			<div class="issue">
				<img id="headerImage" src="content/btn_issue/img1.png" alt="">
			</div>
			<div class="issue">
				<img id="headerImage2" src="#" alt="">
			</div>
		</div>
		<div class="content">
			<div class="box news" id="newsGroup">
				<h2>TIN TỨC</h2>
				<ul id="news1" class="list">
				
							<li>
								<a href="https://www.facebook.com/groups/1790819084633034/permalink/1790819737966302/" onClick="javascript: viewLink(9361, 1);">
									<span style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự kiện</span>
									⛔ Open 19:00PM 19/11/2022 | Even Chia Sẻ Facebook
								</a>
								<img src="content/icon_new.gif" alt="NEW">
								<span class="date">19/11/2022</span>
							</li>
				
							<li>
								<a href="" onClick="javascript: viewLink(9361, 1);">
									<span style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Tin tức</span>
									⛔ 18:00PM 04/11 | BẢO TRÌ | Tổng hợp cậ...
								</a>
								<img src="content/icon_new.gif" alt="NEW">
								<span class="date">03/11/2021</span>
							</li>
						
							<li>
								<a href="" onClick="javascript: viewLink(9361, 1);">
									<span style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự kiện</span>
									Mừng ngày sinh nhật Hiệp Khách 2022...
								</a>
								<img src="content/icon_new.gif" alt="NEW">
								<span class="date">17/10/2021</span>
							</li>
						
							<li>
								<a href=" onClick="javascript: viewLink(9361, 1);">
									<span style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự kiện</span>
									Sự kiện săn pill võ huân!...
								</a>
								<img src="content/icon_new.gif" alt="NEW">
								<span class="date">01/10/2021</span>
							</li>
						
							<li>
								<a href="" onClick="javascript: viewLink(9361, 1);">
									<span style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự kiện</span>
									Tìm Điểm Khác Biệt [Event Fanpage]...
								</a>
								<img src="content/icon_new.gif" alt="NEW">
								<span class="date">24/09/2021</span>
							</li>
										</ul>

				<a href="#" id="_more" class="more"><img src="content/btn_more.gif" alt="More"></a>
			</div>
			<div class="box schedule">
				<h2>HOẠT ĐỘNG</h2>
				<ul class="tabs">
					<li><a href="#schedule1">Thường</a></li>
					<li><a href="#schedule2">Cuối tuần</a></li>
					<li><a href="#schedule3">Lễ</a></li>
				</ul>
				<ul id="schedule1" class="list">
					<li>
						09:00 Phát giftcode
					</li>
					<li>
						15:00 Phát giftcode
					</li>
					<li>
						<strong>20:00 Thế lực chiến</strong>
					</li>
					<li>
						21:00 Phát giftcode
					</li>
					<li>
						24:00 backup dữ liệu hằng ngày
					</li>
				</ul>
				<ul id="schedule2" class="list">

					<li>
						00:00 Nhân 2 kinh nghiệm (24 giờ)
					</li>
					<li>
						09:00 Phát giftcode
					</li>
					<li>
						15:00 Phát giftcode
					</li>
					<li>
						<strong>20:00 Thế lực chiến</strong>
					</li>
					<li>
						21:00 Phát giftcode
					</li>
				</ul>

				<ul id="schedule3" class="list">
					<li>
						00:00 Nhân 2 kinh nghiệm (24 giờ)
					</li>
					<li>
						09:00 Phát giftcode
					</li>
					<li>
						15:00 Phát giftcode
					</li>
					<li>
						<strong>20:00 Thế lực chiến</strong>
					</li>
					<li>
						21:00 Phát giftcode
					</li>
				</ul>
				<a href="#" class="more"><img src="content/btn_more.gif" alt="더보기"></a>
				<script>
					$(function () {
						var rand_num;
						rand_num = Math.floor(Math.random() * 3);
						//$(".schedule .list").not(":first").hide();
						//$(".schedule .tabs li:first").addClass("on").show();
						$(".schedule .list").not(":eq("+rand_num+")").hide();
						$(".schedule .tabs li:eq("+rand_num+")").addClass("on").show();

						$(".schedule .tabs li").click(function() {
							$(".schedule .tabs li.on").removeClass("on");
							$(this).addClass("on");
							$(".schedule .list").hide();
							$($('a',this).attr("href")).show();
							return false;
						});
					});
				</script>
			</div>

		<?php include "load.php";?>
	</div>
	<div style="clear:both"></div>

	

     <div id="wrapperfooterspace"></div>
	<footer id="colophon" role="contentinfo">
		<div class="site-info footernormal">
			<section id="text-5" class="widget widget_text">			
				<div class="textwidget">
					<center>
						<table width="1180" cellspacing="0" cellpadding="0" border="0" style="text-align:left">
							<tr>
								<td colspan="4"><center>
				<div class="footercopyright" align="center" style="width:1180px;">Copyright &copy; Mgame<br>Hiệp Khách Giang Hồ by KTeam 2022.</div></center>
								</td>
							</tr>
						</table>
					</center>
				</div>
			</section>        
		</div>
	</footer>
<!-- Lightbox Plus Colorbox v2.7.2/1.5.9 - 2013.01.24 - Message: 0-->
<script type="text/javascript">
jQuery(document).ready(function($){
  $("a[rel*=lightbox]").colorbox({initialWidth:"30%",initialHeight:"30%",maxWidth:"90%",maxHeight:"90%",opacity:0.8});
});
</script>
<link rel='stylesheet' id='metaslider-flex-slider-css'  href='wp-content/plugins/ml-slider/assets/sliders/flexslider/flexslidere485.css?ver=3.3.6' type='text/css' media='all' property='stylesheet' />
<link rel='stylesheet' id='metaslider-public-css'  href='wp-content/plugins/ml-slider/assets/metaslider/publice485.css?ver=3.3.6' type='text/css' media='all' property='stylesheet' />
<script type='text/javascript' src='wp-content/themes/herowarz/js/skip-link-focus-fixfcb8.js?ver=20151112'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var screenReaderText = {"expand":"expand child menu","collapse":"collapse child menu"};
/* ]]> */
</script>
<script type='text/javascript' src='wp-content/themes/herowarz/js/functionsdbb0.js?ver=20151204'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/libs/cycle2/jquery.cycle2.min6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/libs/cycle2/jquery.cycle2.carousel.min6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/libs/cycle2/jquery.cycle2.swipe.min6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/libs/cycle2/jquery.cycle2.tile.min6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/libs/cycle2/jquery.cycle2.video.min6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/templates/dark/script6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/templates/thumbnails/script6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/cyclone-slider-2/js/client6af1.js?ver=2.11.0'></script>
<script type='text/javascript' src='wp-content/plugins/lightbox-plus/js/jquery.colorbox.1.5.9-min7fb9.js?ver=1.5.9'></script>
<script type='text/javascript' src='wp-includes/js/wp-embed.mina94e.js?ver=4.4.1'></script>
<script type='text/javascript' src='wp-content/plugins/ml-slider/assets/sliders/flexslider/jquery.flexslider-mine485.js?ver=3.3.6'></script>
<script type='text/javascript' src='wp-content/plugins/ml-slider/assets/easing/jQuery.easing.mine485.js?ver=3.3.6'></script>

</div><!-- .site -->

<script src="wp-content/themes/herowarz/js/main.js"></script> <!-- Gem jQuery -->

    <script src="/wp-content/themes/herowarz/jquery.cookie.js"></script>
    <script src="/wp-content/themes/herowarz/jquery.fancybox.js"></script>
    <script src="/wp-content/themes/herowarz/common.js"></script>
    <link type="text/css" rel="stylesheet" href="/wp-content/themes/herowarz/addon.css" />

</body>

<script language="JavaScript">
    window.onload = function() {
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        }, false);
        document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
            // "I" key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                disabledEvent(e);
            }
            // "J" key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                disabledEvent(e);
            }
            // "S" key + macOS
            if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                disabledEvent(e);
            }
            // "U" key
            if (e.ctrlKey && e.keyCode == 85) {
                disabledEvent(e);
            }
            // "F12" key
            if (event.keyCode == 123) {
                disabledEvent(e);
            }
        }, false);

        function disabledEvent(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            } else if (window.event) {
                window.event.cancelBubble = true;
            }
            e.preventDefault();
            return false;
        }
    };
</script>

</html>

