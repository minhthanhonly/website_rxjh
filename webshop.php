<div>
	<h1 class="hdg-01">
		Cửa Hàng
	</h1>
	<ul class="box-tab02">
		<li>
			<a href="?a=webshop&page=0&type=0" class="<?php if (!isset($_GET["type"]) || $_GET["type"] == 0) { echo "-active"; } ?>">
				Tất cả
			</a>
		</li>
		<li>
			<a href="?a=webshop&page=0&type=1" class="<?php if (isset($_GET["type"]) && $_GET["type"] == 1) { echo "-active"; } ?>">
				Kỳ phẩm
			</a>
		</li>
		<li>
			<a href="?a=webshop&page=0&type=2" class="<?php if (isset($_GET["type"]) && $_GET["type"] == 2) { echo "-active"; } ?>">
				Áo choàng nữ
			</a>
		</li>
		<li>
			<a href="?a=webshop&page=0&type=3" class="<?php if (isset($_GET["type"]) && $_GET["type"] == 3) { echo "-active"; } ?>">
				Áo choàng nam
			</a>
		</li>
		<li>
			<a href="?a=webshop&page=0&type=7" class="<?php if (isset($_GET["type"]) && $_GET["type"] == 7) { echo "-active"; } ?>">
				Pill Train
			</a>
		</li>
	</ul>
	<hr style="margin: 10px 0;">
	
			<?php
			// require "/include/define.php";
			// require "/include/conn.php";
			// require "/include/gump.class.php";
			
			require "./include/conn.php";

			if (isset($_GET["type"])) {

				$validate = new GUMP();
				$_GET = $validate->sanitize($_GET);
				$validate->validation_rules(
					array(
						'type' => 'required|numeric|max_len,1',
					)
				);
				$validate->filter_rules(
					array(
						'type' => 'trim|whole_number',
					)
				);
				$validated_data = $validate->run($_GET);
				if ($validated_data === false) {
					//echo "<font color=red size=69>?</b>";
					die;
					//$error = (object)$validate->get_errors_array();
				} else {
					$type = $validated_data["type"];
				}


			} else
				$type = 0;


			$item = "";
			if ($type == 0) {
				$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg.dbo.ITEMSELL Order by FLD_TYPE,ID DESC");
			} else if ($type == 1) {
				$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg.dbo.ITEMSELL where FLD_TYPE=1 Order by ID");
			} else if ($type == 2) {
				$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg.dbo.ITEMSELL where FLD_TYPE=2 Order by FLD_PRICE,ID");
			} else if ($type == 3) {
				$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg.dbo.ITEMSELL where FLD_TYPE=3 Order by FLD_PRICE,ID");
			} else if ($type == 4) {
				$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg_test.dbo.ITEMSELL where FLD_TYPE=69 or FLD_TYPE=70");
			} else if ($type == 7) {
				$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg.dbo.ITEMSELL where FLD_TYPE=7 Order by FLD_PRICE,ID");
			} else {
				//die;
			}
			$numberofitem = odbc_num_rows($item);
			?>
			<?php
			$line = 13;
			if ($_POST) {

				if (isset($_POST["trang"])) {
					$validate = new GUMP();
					$_POST = $validate->sanitize($_POST);
					$validate->validation_rules(
						array(
							'trang' => 'required|numeric|max_len,3',
						)
					);
					$validate->filter_rules(
						array(
							'trang' => 'trim|whole_number',
						)
					);
					$validated_data = $validate->run($_POST);
					if ($validated_data === false) {
						//echo "<font color=red size=69>?</b>";
						die;
						//$error = (object)$validate->get_errors_array();
					} else {
						$page = $validated_data["trang"];
					}
				} else {
					$page = 0;
				}


			} else {
				if (isset($_GET["page"])) {
					$validate = new GUMP();
					$_GET = $validate->sanitize($_GET);
					$validate->validation_rules(
						array(
							'page' => 'required|numeric|max_len,3',
						)
					);
					$validate->filter_rules(
						array(
							'page' => 'trim|whole_number',
						)
					);
					$validated_data = $validate->run($_GET);
					if ($validated_data === false) {
						//echo "<font color=red size=69>?</b>";
						die;
						//$error = (object)$validate->get_errors_array();
					} else {
						$page = $validated_data["page"];
					}


				} else {
					$page = 0;
				}
			}
			if ($line * ($page) >= $numberofitem || $page < 0) {
				//echo "<font color=red size=69>?</b>";
				//die;
			}
		?>
		<?php
			if($numberofitem > 0){
		?>
			<table class="tbl -color">
				<thead>
				<tr>
					<!--<td width="2%">T.tự</td>-->
					<th width="10%">Lệnh mua</th>
					<th width="25%">Tên vật phẩm</th>
					<th width="5%">Ảnh</th>
					<th width="5%">Giá</th>
					<th width="50%">Thông tin vật phẩm</th>
					<th width="5%">T.gian</th>
				<tr>
				</thead>
				<tbody>
		
				<?php 
					$i = -1;
					while (odbc_fetch_row($item)) {
						$i++;
						if ($i >= $line * $page && $i < $line * ($page + 1)) {

							$tenitem = iconv('UTF-16LE', 'UTF-8', odbc_result($item, 3));
							$desitem = iconv('UTF-16LE', 'UTF-8', odbc_result($item, 5));
							// $tenitem = odbc_result($item, 3);
							// $desitem = odbc_result($item, 5);
							echo "<tr>
								<!--<td>" . ($i + 1) . "</td>-->
								<td>!mua " . odbc_result($item, 1) . "</td>
								<td>" . $tenitem . "</td>
								<td><img src=\"../cpanel/WEBSHOP/ITEM/" . odbc_result($item, 2) . ".gif\"</td>
								<td>" . number_format(odbc_result($item, 4), 0) . "@</td>
								<td>" . $desitem . "</td>
								<td>" . (odbc_result($item, 6) == 0 ? "V.viễn" : odbc_result($item, 6) . " ngày") . "</td>
							</tr>";
						}
					}
				?>
				</tbody>
			</table>
			<hr class="mt20">
			<form action="" method="post" id="form1">
				<div class="flex pagination">
					<?php
					$truoc = $page - 1;
					$sau = $page + 1;
					$sotrang = round(($numberofitem / $line) - 0.51);
					echo "<p>Trang $page / $sotrang</p>";
					echo "<div class='flex gap10'>";

					for ($i = 1; $i <= $sotrang; $i++) {
						if ($i >= 0 && $i <= $sotrang) {
							if ($i == $page)
								echo "<strong class='current'>" . $i . "</strong>";
							else
								echo "<a href='?a=webshop&page=" . $i . "&type=" . $type . "'>" . $i . "</a> ";
						}
					}
					?>
					<input type="number" name="trang" min="0" max="<?php echo $sotrang; ?>" value="<?php echo $page; ?>" class='ml10'">
					<input type="submit" value="Đến"></input>
					</div>
				</div>
			</form>
		<?php } else { ?>
				<p class="center mt20">Không tìm thấy vật phẩm nào.</p>
		<?php } ?>
</div>