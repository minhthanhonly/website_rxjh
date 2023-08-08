<?php
// session_start();
// require "/include/define.php";
// require "/include/conn.php";
// require "/include/gump.class.php";
$error1 = "";
if (isset($_POST['accx'])) {
	$valide = new GUMP();
	$_POST = $valide->sanitize($_POST);
	$valide->validation_rules(
		array(
			'accx' => 'required|alpha_dash|max_len,16|min_len,6',
			'passx' => 'required|max_len,16|min_len,6',
			'passx2' => 'required|max_len,16|min_len,6',
			'cauhoi' => 'required|alpha_space|max_len,50',
			'traloi' => 'required|alpha_space|max_len,50',
		)
	);
	$valide->filter_rules(
		array(
			'accx' => 'trim|sanitize_string',
			'passx' => 'trim|sanitize_string',
			'passx2' => 'trim|sanitize_string',
			'cauhoi' => 'trim|sanitize_string',
			'traloi' => 'trim|sanitize_string',
		)
	);
	$validated_data = $valide->run($_POST);
	if ($validated_data === false) {
		$error = (object) $valide->get_errors_array();
	} else {
		$acc = $validated_data['accx'];
		$pass = $validated_data['passx'];
		$pass2 = $validated_data['passx2'];
		$cauhoi = $validated_data['cauhoi'];
		$traloi = $validated_data['traloi'];
		$cauhoi = str_replace(" ", "", $cauhoi) . '?';

		$sql = "SELECT ID FROM TBL_ACCOUNT WHERE FLD_ID = '" . $acc . "' and Pass2 = '" . $pass2 . "' and FLD_QU = '" . $cauhoi . "' and FLD_ANSWER = '" . $traloi . "'";
		$query = odbc_exec($dbhandle, $sql);
		$result = odbc_fetch_array($query);
		if ($result) {
			odbc_exec($dbhandle, "update TBL_ACCOUNT set FLD_PASSWORD='" . $pass . "' where FLD_ID='" . $acc . "'");
			$error1 = "Bạn đã thay đổi mật khẩu 1 tài khoản <u>" . $acc . "</u> thành công !";
		} else {
			$error1 = "Thông tin cũ không chính xác";
		}
	}
}
?>

<form method="POST" autocomplete="off">
	<div>
		<h1 class="hdg-01">
			Lấy Lại Mật Khẩu
		</h1>
		<h3 class="error">
			<?php echo $error1; ?>
		</h3>
		<table class="tbl">
			<tr>
				<th width="30%" class="right">Tài khoản:</th>
				<td class="left"><input class="inpt"
						name="accx" placeholder="Tài khoản | A-Za-z0-9 | hkdvacc" id="hw_an" pattern="[A-Za-z0-9]+"
						type="text" size="35">
					<div class="error">
						<?php echo isset($error->Accx) ? $error->Accx : '' ?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="right">Mật khẩu mới:</th>
				<td class="left"><input class="inpt"
						name="passx" placeholder="Mật khẩu mới | A-Za-z0-9 | ******" id="hw_sk" pattern="[A-Za-z0-9]+"
						type="password" size="35">
					<div class="error">
						<?php echo isset($error->Passx) ? $error->Passx : '' ?>
					</div>
				</td>
			<tr>
				<th class="right">Mật khẩu 2:</th>
				<td class="left"><input class="inpt"
						name="passx2" placeholder="Mật khẩu 2 | A-Za-z0-9 | ******" id="hw_sk" pattern="[A-Za-z0-9]+"
						type="password" size="35">
					<div class="error">
						<?php echo isset($error->Passx2) ? $error->Passx2 : '' ?>
					</div>
				</td>
			<tr>
				<th class="right">
					<span>Câu hỏi: </span>
				</th>
				<td>
					<select class="srk" id="cauhoi" name="cauhoi" pattern="[A-Za-z0-9 ]+">
						<option value="">Hãy chọn câu hỏi bí mật...</option>
						<option value="Nguoi yeu ban ten gi">Người yêu bạn tên gì?</option>
						<option value="Ngoi truong dau tien ban hoc">Ngôi trường đầu tiên bạn học?</option>
						<option value="Nguoi ban yeu quy nhat la ai">Người bạn yêu quý nhất là ai?</option>
						<option value="Ten ca si yeu thich nhat">Tên ca sĩ bạn yêu thích nhất?</option>
						<option value="Bai hat ban yeu thich nhat">Bài hát bạn yêu thích nhất?</option>
						<option value="Ban thich di du lich o dau nhat">Bạn thích đi du lịch ở đâu nhất?</option>
						<option value="Ten co giao dau tien cua ban">Tên cô giáo đầu tiên của bạn?</option>
						<option value="Bien so xe cua ban">Biển số xe của bạn?</option>
						<option value="Mon an nao ban thich nhat">Món ăn nào bạn thích nhất?</option>
						<option value="Ai la than tuong cua ban">Ai là thần tượng của bạn?</option>
						<option value="Ban ghet loai hoa nao nhat">Bạn ghét loại hoa nào nhất?</option>
						<option value="Ten nguoi ban than cua ban thoi tho au">Tên người bạn thân của bạn thời thơ ấu?
						</option>
						<option value="Noi ban gap nguoi yeu ban dang yeu">Nơi bạn gặp người yêu bạn đang yêu?</option>
					</select>
					<div class="error">
						<?php echo isset($error->Cauhoi) ? $error->Cauhoi : '' ?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="right">
					<span>Câu trả lời: </span>
				</th>
				<td>
					<input class="inpt" type="text" value="" id="hw_sk" name="traloi"
						maxlength="50" placeholder="Câu trả lời bí mật | A-Za-z0-9 | Linh Thi Lung"
						pattern="[A-Za-z0-9 ]+" size="35">
					<div class="error">
						<?php echo isset($error->Traloi) ? $error->Traloi : '' ?>
					</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="left"><input type="submit" value="Đổi mật khẩu" id="submit" name="submit"></td>
			</tr>
		</table>
	</div>
</form>