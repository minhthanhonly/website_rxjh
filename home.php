<div class="box-home-main">
	<img src="/assets/images/img-main.png" alt="">
</div>
<div class="wrp-container">
	<div class="box-home-wrap">
		<div class="box-home-wrap__left">
			<a href="/?a=download" class="-btn-down">
				<img src="/assets/images/btn-download02.png" alt="Download">
			</a>
			<a href="/?a=login" class="-btn">
				<img src="/assets/images/btn-login.png" alt="Đăng nhập">
			</a>
			<a href="/?a=reg" class="-btn">
				<img src="/assets/images/btn-register02.png" alt="Đăng ký">
			</a>
			<a href="/?a=donate" class="-btn">
				<img src="/assets/images/btn-donate.png" alt="Nạp thẻ">
			</a>


		</div>
		<div class="box-ranking">
			<table>
				<thead>
					<tr>
						<th>#</th>
						<th>Nhân vật</th>
						<th>Cấp độ</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql_command = "SELECT FLD_ID,FLD_NAME,FLD_ZX,FLD_JOB,FLD_LEVEL,FLD_EXP,FLD_JOB_LEVEL,FLD_WX,FLD_ZS from rxjhgame.dbo.TBL_XWWL_Char order by FLD_ZS desc, FLD_LEVEL desc, FLD_EXP desc";
						
						$item = odbc_exec($dbhandle, $sql_command);
						$i=0;
						while($row = odbc_fetch_array($item))
						{
							$taikhoan = $row['FLD_ID'];
							$i++;
							
							if($taikhoan == "hoanglong15" || $taikhoan == "littl3ird" || $taikhoan == "0" || $taikhoan == "krhuy1996" || $taikhoan == "krhuy96" || $taikhoan == "1" || $taikhoan == "2" || $taikhoan == "3" || $taikhoan == "a" || $taikhoan == "b" || $taikhoan == "c")
							{
								$i--;
								continue;
							}
							echo "<tr>
								<td>".$i."</td>
								<td>".$row['FLD_NAME']."</td>
								<td>".$row['FLD_LEVEL']."</td>
							</tr>";
							if($i >= 10){
								break;
							}
						}
					?>
				</tbody>
			</table>
			<a href="/?a=ranking" class="btn-rank-more"><img src="/assets/images/server-more.png" alt="more"></a>
			<img src="/assets/images/lights.png" alt="" class="img-light">
		</div>
		<div class="box-home-wrap__center">
			<div class="box-banner">
				<a href="/?a=donate"><img src="/assets/images/banner.png" alt=""></a>
			</div>
			<div class="box-news tab-wrapper">
				<ul class="box-tab">
					<li><a href="#tab-1" class="-active">Tin Tức</a></li>
					<li><a href="#tab-2">Sự Kiện</a></li>
					<li><a href="#tab-3">Hướng dẫn</a></li>
				</ul>
				<div class="tab-wrap">
					<div id="tab-1" class="-active tab-content">
						<ul class="lst-news">
							<li><a href="#">[Thông báo] Khai mở máy chủ Thiên Mã Cung</a><span class="date">02/08/2023</span></li>
							<li><a href="#">[Thông báo] Phúc lợi ưu đãi máy chủ mới</a><span class="date">02/08/2023</span></li>
							<li><a href="#">[Thông báo] Đại chiến boss map</a><span class="date">02/08/2023</span></li>
							<li><a href="#">[Thông báo] Võ lâm huyết chiến</a><span class="date">02/08/2023</span></li>
						</ul>
					</div>
					<div id="tab-2" class="tab-content">
						<ul class="lst-news">
							<li><a href="#">[Thông báo] Đại chiến boss map</a><span class="date">02/08/2023</span></li>
							<li><a href="#">[Thông báo] Võ lâm huyết chiến</a><span class="date">02/08/2023</span></li>
						</ul>
					</div>
					<div id="tab-3" class=" tab-content">
					</div>
				</div>
				<a href="#" class="btn-news-more"><img src="/assets/images/server-more.png" alt="more"></a>
			</div>
		</div>
		<div class="box-home-wrap__right">
			<div class="box-shop">
				<ul>
					<li title="Búp bê mèo may mắn. EXP +20%, Rớt đồ +20%, Tiền +40%, HP +100 trong 2 giờ(10 lần sử dụng)">
						<div class="img"><img src="/assets/images/shop/1008000232.gif" alt=""></div>
						<p>
							<span class="name">Mèo Tài Phú</span>
							<span class="price"><img src="/assets/images/shop/coin.png" alt=""> 800</span>
						</p>
					</li>
					<li title="Trong vòng 24 giờ nhận thêm 150% điểm Exp (Level có thể dùng: 1~130, có thể dùng 1 lần)">
						<div class="img"><img src="/assets/images/shop/1008000363.gif" alt=""></div>
						<p>
							<span class="name">Hộ tâm đơn (150%) (24 giờ)</span>
							<span class="price"><img src="/assets/images/shop/coin.png" alt=""> 3000</span>
						</p>
					</li>
					<li title="Đạo cụ đặc biệt, tăng lực công kích 15%, sức phòng ngự 15%, sinh lực 1000, điểm kinh nghiệm 40%, lực công kích võ công 10%, sức phòng ngự võ công 10%">
						<div class="img"><img src="/assets/images/shop/1008000194.gif" alt=""></div>
						<p>
							<span class="name">Chí Tôn Hỏa Dương Đơn</span>
							<span class="price"><img src="/assets/images/shop/coin.png" alt=""> 880</span>
						</p>
					</li>
					<li title="+300 Hp tất cả khí công + 1">
						<div class="img"><img src="/assets/images/shop/1008000187.gif" alt=""></div>
						<p>
							<span class="name">Thái Cuồng Đơn (10 ngày)</span>
							<span class="price"><img src="/assets/images/shop/coin.png" alt=""> 1380</span>
						</p>
					</li>
					<li title="Trong 10 ngày + 300 HP 0,5% Def cho nhân vật.">
						<div class="img"><img src="/assets/images/shop/1008000183.gif" alt=""></div>
						<p>
							<span class="name">Cầu Tuyết đơn(10 ngày)</span>
							<span class="price"><img src="/assets/images/shop/coin.png" alt=""> 1500</span>
						</p>
					</li>
					<li class="more">
						<a href="/?a=webshop">+ Xem thêm</a>
					</li>
				</ul>
			</div>

			<div class="box-chanel">
				<ul>
					<li>
						<p>
							Kênh 1
							<span class="<?php if(isset($kenh1) && $kenh1 == true) echo 'online'; ?>"></span>
						</p>
					</li>
					<li>
						<p>
							Kênh 2
							<span class="<?php if(isset($kenh2) && $kenh2 == true) echo 'online'; ?>"></span>
						</p>
					</li>
					<li>
						<p>
							Kênh 3
							<span class="<?php if(isset($kenh3) && $kenh3 == true) echo 'online'; ?>"></span>
						</p>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>