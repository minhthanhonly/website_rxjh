<?php
// require "/include/define.php";
// require "/include/conn.php";
// require "/include/gump.class.php";


$error1 = "";
$ischeck= false;
if (isset($_POST['username'])) {
	$valide = new GUMP();
	$valide->validation_rules(
		array(
			'username' => 'required|alpha_dash|max_len,12|min_len,6',
			'Password' => 'required|max_len,16|min_len,6',
			'verifyPassword' => 'required|alpha_dash|max_len,16|min_len,6',
			'Password2' => 'required|alpha_dash|max_len,16|min_len,6',
			'verifyPassword2' => 'required|alpha_dash|max_len,16|min_len,6',
			'email' => 'required|valid_email|max_len,50',
			'fullname' => 'required|max_len,50',
			'identityNumber' => 'required|numeric|max_len,15|min_len,6',
			'sex' => 'required|numeric|max_len,1',
			'cauhoi' => 'required|alpha_space|max_len,50',
			'traloi' => 'required|alpha_space|max_len,50',
		)
	);
	$valide->filter_rules(
		array(
			'username' => 'trim|sanitize_string',
			'Password' => 'trim|sanitize_string',
			'verifyPassword' => 'trim|sanitize_string',
			'Password2' => 'trim|sanitize_string',
			'verifyPassword2' => 'trim|sanitize_string',
			'email' => 'trim|sanitize_email',
			'fullname' => 'trim|sanitize_string',
			'identityNumber' => 'trim|whole_number',
			'sex' => 'trim|whole_number',
			'cauhoi' => 'trim|sanitize_string',
			'traloi' => 'trim|sanitize_string',
		)
	);
	$validated_data = $valide->run($_POST);
	if ($validated_data === false) {
		$error = (object) $valide->get_errors_array();
	} else {
		$acc = $validated_data['username'];
		$pass = $validated_data['Password'];
		$pass2 = $validated_data['Password2'];
		$cmnd = $validated_data['identityNumber'];
		$hoten = $validated_data['fullname'];
		$cauhoi = $validated_data['cauhoi'];
		$traloi = $validated_data['traloi'];
		$mail = $validated_data['email'];
		$sex = $validated_data['sex'];
		$ip = $_SERVER['REMOTE_ADDR'];

		$status = '';
		$err = 0;
		if ($_POST['captcha'] == '') {
			$status = "<p class='error'><span>Vui lòng nhập mã bảo vệ</span></p>";
			$err = 1;
		}
		if ( isset($_POST['captcha']) && ($_POST['captcha'] != "") ){
			if(strcasecmp($_SESSION['captcha'], $_POST['captcha']) != 0){
				$status = "<p class='error'><span>Vui lòng nhập đúng mã bảo vệ</span></p>";
				$err = 1;
			}
		}


		$partten = "/([\w_]+){6,12}$/";
		if (preg_match($partten, $pass, $matchs) && preg_match($partten, $pass2, $matchs)) {


			$error1 ='';
			/*kiem ta tai khoan ton tai*/
			$sql = "SELECT ID FROM TBL_ACCOUNT WHERE FLD_ID = '" . $acc . "'";
			$query = odbc_exec($dbhandle, $sql);
			if (odbc_num_rows($query) > 0) {
				$err = 1;
				$error1 = "Tài khoản đã tồn tại. Vui lòng sử dụng tài khoản khác.";
			}

			/*kiem ta email ton tai*/
			$sql = "SELECT FLD_Mail FROM TBL_ACCOUNT WHERE FLD_Mail = '" . $mail . "'";
			$query = odbc_exec($dbhandle, $sql);
			if (odbc_num_rows($query) > 0) {
				$err = 1;
				$error1 .= "<br>Email này đã được sử dụng";
			}

			if (md5($validated_data['Password']) != md5($validated_data['verifyPassword'])) {
				$err = 1;
				$error1 = "Mật khẩu không trùng khớp";
			}

			if (md5($validated_data['Password2']) != md5($validated_data['verifyPassword2'])) {
				$err = 1;
				$error1 = "Mật khẩu cấp 2 không trùng khớp";

			}

			if ($err == 0) {
				$cauhoi = str_replace(" ", "", $cauhoi) . '?';
				$sql = "INSERT INTO TBL_Account (FLD_ID,FLD_PASSWORD,FLD_PASSWORD2,FLD_CARD,FLD_NAME,FLD_QU,FLD_ANSWER,FLD_Mail,FLD_SEX,FLD_REGIP,FLD_RXPIONT,FLD_RXPIONTX)values('$acc','$pass','$pass2','$cmnd','$hoten','$cauhoi','$traloi','$mail','$sex','$ip',0,0)";
				$query = odbc_exec($dbhandle, $sql);

				if ($query) {
					$ischeck = TRUE;
					$error1 = "<span class='green'>Chúc mừng, đăng ký tài khoản: <u>" . $acc . "</u> thành công!!!</span>";
				} else {
					$error1 = "Lỗi đăng ký tài khoản, vui lòng thử lại hoặc liên hệ admin để được hỗ trợ!!!</b></center>";
				}

			}

		} else if (!preg_match($partten, $pass, $matchs)) {
			$error1 = "Mật khẩu 1 chưa đúng định dạng. Mật khẩu không bao gồm các kí tự đặc biệt (6~16 kí tự)";
		} else {
			$error1 = "Mật khẩu 2 chưa đúng định dạng. Mật khẩu không bao gồm các kí tự đặc biệt (6~16 kí tự)";
		}
	}
}
?>
<div>
	<h1 class="hdg-01">
		Đăng ký tài khoản mới
	</h1>
	<h3 class="error mb20 center">
		<?php echo $error1; ?>
	</h3>
	<?php if ($ischeck) { ?>
	<?php } else { ?>
	<form method="POST" autocomplete="off">
		<table class="tbl">
			<tbody>
				<tr>
					<th width="30%" class="right">
						<span>Tài khoản: </span>
					</th>
					<td>
						<input class="srk" type="text" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" id="username" name="username" size="36" maxlength="12"
							placeholder="Tài khoản" pattern="[A-Za-z0-9]+">
						<div class="error">
							<?php echo isset($error->Username) ? $error->Username : '' ?>
						</div>
						<p class="note">6~12 kí tự</p>
					</td>
				</tr>
				<tr>
					<th class="right">
						Mật khẩu: </th>
					<td>
						<input class="srk" type="password" value="<?php if(isset($_POST['Password'])) echo $_POST['Password'];?>" id="password" name="Password" size="36"
							maxlength="16" placeholder="Mật khẩu" pattern="[A-Za-z0-9]+">
						<div class="error">
							<?php echo isset($error->Password) ? $error->Password : '' ?>
						</div>
						<p class="note">6~16 kí tự</p>
					</td>
				</tr>
				<tr>
					<th class="right">
						Nhập lại: </th>
					<td>
						<input class="srk" type="password" value="<?php if(isset($_POST['verifyPassword'])) echo $_POST['verifyPassword'];?>" id="verifyPassword" name="verifyPassword" size="36"
							maxlength="16" placeholder="Nhập lại mật khẩu" pattern="[A-Za-z0-9]+">

						<div class="error">
							<?php echo isset($error->VerifyPassword) ? $error->VerifyPassword : '' ?>
						</div>
						<p class="note">6~16 kí tự</p>
					</td>
				</tr>
				<tr>
					<th class="right">
						Mật khẩu 2: </th>

					<td>
						<input class="srk" type="password" value="<?php if(isset($_POST['Password2'])) echo $_POST['Password2'];?>" id="Password2" name="Password2" size="36"
							maxlength="16" placeholder="Mật khẩu cấp 2" pattern="[A-Za-z0-9]+">
						<div class="error">
							<?php echo isset($error->Password2) ? $error->Password2 : '' ?>
						</div>
						<p class="note">6~16 kí tự</p>
					</td>
				</tr>
				<tr>
					<th class="right">
						Nhập lại: </th>
					<td>
						<input class="srk" type="password" value="<?php if(isset($_POST['verifyPassword2'])) echo $_POST['verifyPassword2'];?>" id="verifyPassword2" name="verifyPassword2"
							size="36" maxlength="16" placeholder="Nhập lại mật khẩu cấp 2"
							pattern="[A-Za-z0-9]+">

						<div class="error">
							<?php echo isset($error->VerifyPassword2) ? $error->VerifyPassword2 : '' ?>
						</div>
						<p class="note">6~16 kí tự</p>
					</td>
				</tr>
				<tr>
					<th class="right">
						Email: </th>
					<td>
						<input class="srk" type="text" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" id="email" name="email" size="36" maxlength="45"
							placeholder="Email"
							pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$">
						<div class="error">
							<?php echo isset($error->Email) ? $error->Email : '' ?>
						</div>
					</td>
				</tr>
				<tr>
					<th class="right">
						Họ tên: </th>
					<td>
						<input class="srk" type="text" value="<?php if(isset($_POST['fullname'])) echo $_POST['fullname'];?>" id="fullname" name="fullname" size="36" maxlength="50"
							placeholder="Họ và tên">
						<div class="error">
							<?php echo isset($error->Fullname) ? $error->Fullname : '' ?>
						</div>
					</td>
				</tr>
				<tr>
					<th class="right">
						Số ĐT: </th>
					<td>
						<input class="srk" type="text" value="<?php if(isset($_POST['identityNumber'])) echo $_POST['identityNumber'];?>" id="identityNumber" name="identityNumber" size="36"
							maxlength="16" placeholder="Số điện thoại" pattern="[0-9]+">
						<div class="error">
							<?php echo isset($error->IdentityNumber) ? $error->IdentityNumber : '' ?>
						</div>
					</td>
				</tr>
				<tr>
					<th class="right">
						Giới tính: </th>
					<td>
						<label class="inline-flex gap5"><input type="radio" name="sex" id="sex" value="1" <?php if(isset($_POST['sex']) && $_POST['sex'] == '1') echo 'checked';?>>
						Nam</label>
						<label class="inline-flex gap5 ml20"><input type="radio" name="sex" id="sex" value="2" <?php if(isset($_POST['sex']) && $_POST['sex'] == '2') echo 'checked';?>>
						Nữ</label>
						<br>
						<p class="note">Lưu ý: Chỉ tạo được nhân vật cùng giới tính.</p>
						<div class="error">
							<?php echo isset($error->Sex) ? $error->Sex : '' ?>
						</div>
					</td>
				</tr>
				<tr></tr>
				<tr>
					<th class="right">
						Câu hỏi: </th>
					<td>
						<select class="srk" id="cauhoi" name="cauhoi">
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
							<option value="Ten nguoi ban than cua ban thoi tho au">Tên người bạn thân của bạn thời thơ
								ấu?</option>
							<option value="Noi ban gap nguoi yeu ban dang yeu">Nơi bạn gặp người yêu bạn đang yêu?
							</option>
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
						<input class="srk" type="text" value="" id="traloi" name="traloi" size="36" maxlength="50"
							placeholder="Câu trả lời bí mật">
						<div class="error">
							<?php echo isset($error->Traloi) ? $error->Traloi : '' ?>
						</div>
					</td>
				</tr>
				<tr>
					<th class="right">
						<span>Captcha</span>
					</th>
					<td>
					<script>
						//Refresh Captcha
						function refreshCaptcha(){
							var img = document.images['captcha_image'];
							img.src = img.src.substring(
								0,img.src.lastIndexOf("?")
								)+"?rand="+Math.random()*1000;
						}
						</script>
						<input type="text" name="captcha" placeholder="Mã bảo vệ"> <img src="captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'>
						<a href='javascript: refreshCaptcha();'>Refresh</a></p>

						<div class="error">
							<?php echo isset($status) ? $status : '' ?>
						</div>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input class="buttonBluel" type="submit" value="Đăng ký" id="submit" name="submit" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<?php }?>
</div>