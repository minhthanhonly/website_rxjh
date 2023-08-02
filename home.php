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
						$i=-1;
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
						}
					?>
				</tbody>
			</table>
			<a href="/?a=ranking" class="btn-rank-more"><img src="/assets/images/server-more.png" alt="more"></a>
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
			<ul class="lst-link">
				<li><a href="/?a=webshop"><img src="/assets/images/icn-shop.png" alt="">Cửa Hàng</a></li>
				<li><a href="https://www.facebook.com/ThoLamGames" target="_blank"><img src="/assets/images/icn-support.png" alt="">Hỗ Trợ</a></li>
				<li><a href="https://www.facebook.com/ThoLamGames" target="_blank"><img src="/assets/images/icn-fb2.png" alt="">Fanpage</a></li>
				<li><a href="https://www.facebook.com/ThoLamGames" target="_blank"><img src="/assets/images/icn-group.png" alt="">FB Group</a></li>
			</ul>
			<ul class="lst-icon">
				<li><a href="https://www.facebook.com/ThoLamGames" target="_blank"><img src="/assets/images/icn-fb.png" alt=""></a></li>
				<li><a href="#" target="_blank"><img src="/assets/images/icn-zalo.png" alt=""></a></li>
			</ul>
		</div>
	</div>
</div>