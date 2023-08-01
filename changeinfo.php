<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	if(isset($_SESSION["auth"]['name'])){
		$acc = $_SESSION["auth"]['name'];
	$error1="";
	if(isset($_POST['Password2'])){
		$valide = new GUMP();
		$valide->validation_rules(array(
			'Password2'    => 'required|alpha_dash|max_len,16|min_len,6',
			'verifyPassword2'    => 'required|alpha_dash|max_len,16|min_len,6',
			'email'       => 'required|valid_email',
			'cauhoi'    => 'required|alpha_space|max_len,50',
			'traloi'    => 'required|alpha_space|max_len,50',
			'Password2new'    => 'required|alpha_dash|max_len,16|min_len,6',
			'verifyPassword2new'    => 'required|alpha_dash|max_len,16|min_len,6',
			'emailnew'       => 'required|valid_email',
			'cauhoinew'    => 'required|alpha_space|max_len,50',
			'traloinew'    => 'required|alpha_space|max_len,50',
		));
		$valide->filter_rules(array(
			'Password2' => 'trim|sanitize_string',
			'verifyPassword2' => 'trim|sanitize_string',
			'email'    => 'trim|sanitize_email',
			'cauhoi' => 'trim|sanitize_string',
			'traloi' => 'trim|sanitize_string',
			'Password2new' => 'trim|sanitize_string',
			'verifyPassword2new' => 'trim|sanitize_string',
			'emailnew'    => 'trim|sanitize_email',
			'cauhoinew' => 'trim|sanitize_string',
			'traloinew' => 'trim|sanitize_string',
		));
		$validated_data = $valide->run($_POST);
		if($validated_data === false) {
			$error = (object)$valide->get_errors_array();
		} else {
			$pass2 = $validated_data['Password2'];
			$cauhoi = $validated_data['cauhoi'];
			$traloi = $validated_data['traloi'];
			$email = $validated_data['email'];
			$pass2new = $validated_data['Password2new'];
			$cauhoinew = $validated_data['cauhoinew'];
			$traloinew = $validated_data['traloinew'];
			$emailnew = $validated_data['emailnew'];
			
			
			$partten = "/^([A-Z]){1}([\w_]+){5,11}$/";
			if(preg_match($partten ,$pass2, $matchs) && preg_match($partten ,$pass2new, $matchs))
			{
			
				$cauhoi = str_replace(" ","",$cauhoi).'?';
				$cauhoinew = str_replace(" ","",$cauhoinew).'?';
				
				$err = 0;
				
				
				if(md5($validated_data['Password2']) != md5($validated_data['verifyPassword2'])){
					$err = 1;
					$error1 = "<br><center><b><font color=red size=4>Mật khẩu không trùng khớp</font></b></center>";
				}
				if(md5($validated_data['Password2new']) != md5($validated_data['verifyPassword2new'])){
					$err = 1;
					$error1 = "<br><center><b><font color=red size=4>Mật khẩu không trùng khớp</font></b></center>";
				}
				
				/*kiem tra thong tin*/
				$sql = "SELECT ID FROM rxjhaccount.dbo.TBL_ACCOUNT WHERE FLD_ID = '".$acc."' and Pass2 = '".$pass2."' and FLD_QU = '".$cauhoi."' and FLD_ANSWER = '".$traloi."' and FLD_Mail = '".$email."'";
				$query = odbc_exec($dbhandle,$sql);
				if(odbc_num_rows($query) <= 0){
					$err = 1;
					$error1 = "<br><center><b><font color=red size=4>Thông tin không chính xác</font></b></center>";
				}
				
				
				if($err == 0){
					odbc_exec($dbhandle,"UPDATE TBL_ACCOUNT SET Pass2 = '".$pass2new."' , FLD_QU = '".$cauhoinew."' , FLD_ANSWER = '".$traloinew."' , FLD_Mail = '".$emailnew."' WHERE FLD_ID='".$acc."'");
					$error1 = "<br><center><b><font color=green size=4>Chúc mừng, bạn thông tin tài khoản: <u>".$acc."</u> thành công !!!</font></b></center>";
				}
			}
			else if (!preg_match($partten ,$pass2, $matchs)){
				$error1 = "Mật khẩu 2 chưa đúng định dạng.<br>Mật khẩu đúng địng dạng có mẫu: Hkdevuong2016<br>Vừa có kí tự chữ hoa nằm đầu tiên, vừa có kí tự chữ thường và vừa có chữ số";
			}
			else{
				$error1 = "Mật khẩu 2 mới chưa đúng định dạng.<br>Mật khẩu đúng địng dạng có mẫu: Hkdevuong2016<br>Vừa có kí tự chữ hoa nằm đầu tiên, vừa có kí tự chữ thường và vừa có chữ số";
			}
		}
	}
?>
<style>
	.error{
		font-size:11px;
		color:red;
	}
</style>

<div style="width:100%; height:100%; padding-top:0%;" align="center">
	<hr style="margin: 15px 0;">		
		<span align="center"><h1><font color="blue">Đổi thông tin tài khoản</font></h1></span>
	<hr style="margin: 15px 0;">
	<center><h3><font color="red"><?php echo $error1;?></font></h3></center>
	
	
	



<form method="POST" autocomplete="off">
<table width="80%" align="center" style="padding-top:3%;">
<tbody>
<tr>
							<td width="30%" align="right" class="span">
												<span>Tài khoản: </span></td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="username" name="username" size="36" maxlength="12" placeholder="<?php echo $acc;?>" pattern="[A-Za-z0-9]+" disabled>
    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Mật khẩu 2:   </td>
		
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="Password2" name="Password2" size="36" maxlength="16"  placeholder="Mật khẩu cấp 2 | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
		<div class = "error"><?php echo isset($error->Password2) ? $error->Password2 : '' ?></div>
    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Nhập lại:    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="verifyPassword2" name="verifyPassword2" size="36" maxlength="16" placeholder="Nhập lại mật khẩu | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
		<div class = "error"><?php echo isset($error->VerifyPassword) ? $error->VerifyPassword : '' ?></div>
	</td>
</tr>

<tr>
	<td align="right">
		<span>Câu hỏi: </span></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
			<option value="Ten nguoi ban than cua ban thoi tho au">Tên người bạn thân  của bạn thời thơ ấu?</option>
			<option value="Noi ban gap nguoi yeu ban dang yeu">Nơi bạn gặp người yêu bạn đang yêu?</option>
		</select>
		<div class = "error"><?php echo isset($error->Cauhoi) ? $error->Cauhoi : '' ?></div>
	</td>
</tr>
<tr>
	<td align="right">
		<span>Câu trả lời: </span></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input  style="padding: 10px 10px;" class="inpt" type="text" value="" id="hw_sk" name="traloi" maxlength="50" placeholder="Câu trả lời bí mật | A-Za-z0-9 | Linh Thi Lung" pattern="[A-Za-z0-9 ]+" size="35">
		<div class = "error"><?php echo isset($error->Traloi) ? $error->Traloi : '' ?></div>
	</td>
</tr>
<tr>
    <td class="span"  align="right">
        Email :  </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="email" name="email" size="36" maxlength="45" placeholder="Email | A-Za-z0-9@ | admin@hkdevuong.net" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$">
		<div class = "error"><?php echo isset($error->Email) ? $error->Email : '' ?></div>
    </td>
</tr>
<tr>
	<td colspan="3">
		<hr>
	</td>
<tr>
<tr>
    <td class="span"  align="right">
        Mật khẩu 2 mới:   </td>
		
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="Password2new" name="Password2new" size="36" maxlength="16"  placeholder="Mật khẩu cấp 2 | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
		<div class = "error"><?php echo isset($error->Password2new) ? $error->Password2new : '' ?></div>
    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Nhập lại:    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="verifyPassword2new" name="verifyPassword2new" size="36" maxlength="16" placeholder="Nhập lại mật khẩu | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
		<div class = "error"><?php echo isset($error->VerifyPasswordnew) ? $error->VerifyPasswordnew : '' ?></div>
	</td>
</tr>

<tr>
	<td align="right">
		<span>Câu hỏi mới: </span></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<select class="srk" id="cauhoinew" name="cauhoinew" pattern="[A-Za-z0-9 ]+">
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
			<option value="Ten nguoi ban than cua ban thoi tho au">Tên người bạn thân  của bạn thời thơ ấu?</option>
			<option value="Noi ban gap nguoi yeu ban dang yeu">Nơi bạn gặp người yêu bạn đang yêu?</option>
		</select>
		<div class = "error"><?php echo isset($error->Cauhoinew) ? $error->Cauhoinew : '' ?></div>
	</td>
</tr>
<tr>
	<td align="right">
		<span>Câu trả lời mới: </span></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input  style="padding: 10px 10px;" class="inpt" type="text" value="" id="hw_sk" name="traloinew" maxlength="50" placeholder="Câu trả lời bí mật | A-Za-z0-9 | Linh Thi Lung" pattern="[A-Za-z0-9 ]+" size="35">
		<div class = "error"><?php echo isset($error->Traloinew) ? $error->Traloinew : '' ?></div>
	</td>
</tr>
<tr>
    <td class="span"  align="right">
        Email mới:  </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="emailnew" name="emailnew" size="36" maxlength="45" placeholder="Email | A-Za-z0-9@ | admin@hkdevuong.net" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$">
		<div class = "error"><?php echo isset($error->Emailnew) ? $error->Emailnew : '' ?></div>
    </td>
</tr>
    <td colspan="1" width="20%">
    </td>
    <td colspan="3" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="buttonBluel" type="submit" value="Đổi thông tin" id="submit" name="submit">
    </td>
</tr>
</tbody>
</table>
</form>     
</div>
<?php
	}
	else
		echo "<script>window.location.href = \"./?a=login\";</script>";
?>