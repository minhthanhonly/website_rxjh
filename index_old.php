<?php
// session_start();
// require "./include/define.php";
// require "./include/conn.php";
// require "./include/gump.class.php";
// require "./include/gameconn.php";
?>
<!DOCTYPE html>
<html>

<head>
	<?php include_once "./assets/include/head.php"; ?>
	<?php include_once "./assets/include/commoncss.php"; ?>
</head>

<body>
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
							<input type="text" name="username" id="username" autocomplete="off" class="id text"
								placeholder="Tài khoản" minlength="4" maxlength="32" autocomplete="off" required=""
								pattern="[A-Za-z0-9]+">
							<input type="password" name="password" id="password" autocomplete="off" class="pw text"
								placeholder="Mật khẩu" minlength="4" maxlength="32" autocomplete="off" required=""
								pattern="[A-Za-z0-9]+">
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
								<input onClick="clicked(event)" class="btn btn-primary btn-block" type="submit"
									value="Đăng nhập" />
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
						<a href="https://www.facebook.com/groups/1790819084633034/permalink/1790819737966302/"
							onClick="javascript: viewLink(9361, 1);">
							<span
								style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự
								kiện</span>
							⛔ Open 19:00PM 19/11/2022 | Even Chia Sẻ Facebook
						</a>
						<img src="content/icon_new.gif" alt="NEW">
						<span class="date">19/11/2022</span>
					</li>

					<li>
						<a href="" onClick="javascript: viewLink(9361, 1);">
							<span
								style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Tin
								tức</span>
							⛔ 18:00PM 04/11 | BẢO TRÌ | Tổng hợp cậ...
						</a>
						<img src="content/icon_new.gif" alt="NEW">
						<span class="date">03/11/2021</span>
					</li>

					<li>
						<a href="" onClick="javascript: viewLink(9361, 1);">
							<span
								style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự
								kiện</span>
							Mừng ngày sinh nhật Hiệp Khách 2022...
						</a>
						<img src="content/icon_new.gif" alt="NEW">
						<span class="date">17/10/2021</span>
					</li>

					<li>
						<a href=" onClick=" javascript: viewLink(9361, 1);">
							<span
								style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự
								kiện</span>
							Sự kiện săn pill võ huân!...
						</a>
						<img src="content/icon_new.gif" alt="NEW">
						<span class="date">01/10/2021</span>
					</li>

					<li>
						<a href="" onClick="javascript: viewLink(9361, 1);">
							<span
								style="display: inline-block;background: #f5f5f5;border: 0.5px solid #E6E6FA;text-align: center;width: 55px;vertical-align: middle;color: #000;">Sự
								kiện</span>
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
				$(".schedule .list").not(":eq(" + rand_num + ")").hide();
				$(".schedule .tabs li:eq(" + rand_num + ")").addClass("on").show();

				$(".schedule .tabs li").click(function () {
					$(".schedule .tabs li.on").removeClass("on");
					$(this).addClass("on");
					$(".schedule .list").hide();
					$($('a', this).attr("href")).show();
					return false;
				});
			});
				</script>
			</div>

			<?php include "load.php"; ?>
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
									<td colspan="4">
										<center>
											<div class="footercopyright" align="center" style="width:1180px;">Copyright
												&copy; Mgame<br>Hiệp Khách Giang Hồ by KTeam 2022.</div>
										</center>
									</td>
								</tr>
							</table>
						</center>
					</div>
				</section>
			</div>
		</footer>


	</div><!-- .site -->

</body>
<?php include_once "./assets/include/commonjs.php"; ?>

</html>