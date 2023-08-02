<?php
// require "/include/define.php";
// require "/include/conn.php";
// require "/include/gump.class.php";
if (isset($_SESSION["auth"]['name'])) {
	$acc = $_SESSION["auth"]['name'];
	$error1 = "";
	if (isset($_POST['Password'])) {
		$valide = new GUMP();
		$valide->validation_rules(
			array(
				'Password' => 'required|alpha_dash|max_len,16|min_len,6',
				'verifyPassword' => 'required|alpha_dash|max_len,16|min_len,6',
				'Password2' => 'required|alpha_dash|max_len,16|min_len,6',
			)
		);
		$valide->filter_rules(
			array(
				'Password' => 'trim|sanitize_string',
				'verifyPassword' => 'trim|sanitize_string',
				'Password2' => 'trim|sanitize_string',
			)
		);
		$validated_data = $valide->run($_POST);
		if ($validated_data === false) {
			$error = (object) $valide->get_errors_array();
		} else {
			$pass = $validated_data['Password'];
			$pass2 = $validated_data['Password2'];


			$partten = "/^([A-Z]){1}([\w_]+){5,11}$/";
			if (preg_match($partten, $pass, $matchs) && preg_match($partten, $pass2, $matchs)) {

				$err = 0;

				if (md5($validated_data['Password']) != md5($validated_data['verifyPassword'])) {
					$err = 1;
					$error1 = "<br><center><b><font color=red size=4>Mật khẩu không trùng khớp</font></b></center>";
				}

				/*kiem tra thong tin*/
				$sql = "SELECT ID FROM TBL_ACCOUNT WHERE FLD_ID = '" . $acc . "' and Pass2 = '" . $pass2 . "'";
				$query = odbc_exec($dbhandle, $sql);
				if (odbc_num_rows($query) <= 0) {
					$err = 1;
					$error1 = "<br><center><b><font color=red size=4>Thông tin không chính xác</font></b></center>";
				}


				if ($err == 0) {
					odbc_exec($dbhandle, "UPDATE TBL_ACCOUNT SET FLD_PASSWORD='" . $pass . "' WHERE FLD_ID='" . $acc . "'");
					$error1 = "<br><center><b><font color=green size=4>Chúc mừng, bạn đổi mật khẩu tài khoản: <u>" . $acc . "</u> thành công !!!</font></b></center>";
				}

			} else if (!preg_match($partten, $pass, $matchs)) {
				$error1 = "Mật khẩu 1 chưa đúng định dạng.<br>Mật khẩu đúng địng dạng có mẫu: HkGiangHo2016<br>Vừa có kí tự chữ hoa nằm đầu tiên, vừa có kí tự chữ thường và vừa có chữ số";
			} else {
				$error1 = "Mật khẩu 2 chưa đúng định dạng.<br>Mật khẩu đúng địng dạng có mẫu: HkGiangHo2016<br>Vừa có kí tự chữ hoa nằm đầu tiên, vừa có kí tự chữ thường và vừa có chữ số";
			}
		}
	}
	?>
	<style>
		.error {
			font-size: 11px;
			color: red;
		}
	</style>

	<div>

		<h1 class="hdg-01">Đổi mật khẩu</h1>
		<h3 class="error">
			<?php echo $error1; ?>
		</h3>


		<form method="POST" autocomplete="off">
			<table class="tbl">
				<tbody>
					<tr>
						<td width="30%" align="right" class="span">
							<span>Tài khoản: </span>
						</td>
						<td>
							<input class="srk" type="text" value="" id="username" name="username" size="36" maxlength="12"
								placeholder="<?php echo $acc; ?>" pattern="[A-Za-z0-9]+" readonly>
						</td>
					</tr>
					<tr>
						<td class="span" align="right">
							Mật khẩu mới: </td>
						<td>
							<input class="srk" type="password" value="" id="password" name="Password" size="36"
								maxlength="16" placeholder="Mật khẩu mới | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
							<div class="error">
								<?php echo isset($error->Password) ? $error->Password : '' ?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="span" align="right">
							Nhập lại mật khẩu mới: </td>
						<td>
							<input class="srk" type="password" value="" id="verifyPassword" name="verifyPassword" size="36"
								maxlength="16" placeholder="Nhập lại mật khẩu mới | A-Za-z0-9 | ******"
								pattern="[A-Za-z0-9]+">
							<div class="error">
								<?php echo isset($error->VerifyPassword) ? $error->VerifyPassword : '' ?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="span" align="right">
							Mật khẩu 2: </td>

						<td>
							<input class="srk" type="password" value="" id="Password2" name="Password2" size="36"
								maxlength="16" placeholder="Mật khẩu cấp 2 | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
							<div class="error">
								<?php echo isset($error->Password2) ? $error->Password2 : '' ?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="1" width="20%">
						</td>
						<td colspan="3" width="100%">
							<input class="buttonBluel" type="submit" value="Đổi mật khẩu" id="submit" name="submit">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<?php
} else
	echo "<script>window.location.href = \"./?a=login\";</script>";
?>