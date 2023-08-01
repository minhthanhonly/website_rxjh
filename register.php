<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	$error1="";
	if(isset($_POST['username'])){
		$valide = new GUMP();
		$valide->validation_rules(array(
			'username'    => 'required|alpha_dash|max_len,12|min_len,6',
			'Password'    => 'required|alpha_dash|max_len,16|min_len,6',
			'verifyPassword'    => 'required|alpha_dash|max_len,16|min_len,6',
			'Password2'    => 'required|alpha_dash|max_len,16|min_len,6',
			'verifyPassword2'    => 'required|alpha_dash|max_len,16|min_len,6',
			'email'       => 'required|valid_email',
			'fullname'    => 'required|alpha_space|max_len,50',
			'identityNumber'    => 'required|numeric|max_len,15|min_len,6',
			'sex'    => 'required|numeric',
			'cauhoi'    => 'required|alpha_space|max_len,50',
			'traloi'    => 'required|alpha_space|max_len,50',
		));
		$valide->filter_rules(array(
			'username' => 'trim|sanitize_string',
			'password' => 'trim|sanitize_string',
			'verifyPassword' => 'trim|sanitize_string',
			'Password2' => 'trim|sanitize_string',
			'verifyPassword2' => 'trim|sanitize_string',
			'email'    => 'trim|sanitize_email',
			'fullname'    => 'trim|sanitize_string',
			'identityNumber'    => 'trim|whole_number',
			'sex'    => 'trim|whole_number',
			'cauhoi' => 'trim|sanitize_string',
			'traloi' => 'trim|sanitize_string',
		));
		$validated_data = $valide->run($_POST);
		if($validated_data === false) {
			$error = (object)$valide->get_errors_array();
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
			
			
			$partten = "/^([A-Z]){1}([\w_]+){5,11}$/";
			if(preg_match($partten ,$pass, $matchs) && preg_match($partten ,$pass2, $matchs)){
			
			$err = 0;
			/*kiem ta tai khoan ton ta*/
			$sql = "SELECT ID FROM TBL_ACCOUNT WHERE FLD_ID = '".$acc."'";
			$query = odbc_exec($dbhandle,$sql);
			if(odbc_num_rows($query) > 0){
				$err = 1;
				echo"<script>alert('Tài khoản đã tồn tại. Vui lòng sử dụng tài khoản khác');</script>";
			}
			
			/*kiem ta email ton tai*/
			$sql = "SELECT FLD_Mail FROM TBL_ACCOUNT WHERE FLD_Mail = '".$mail."'";
			$query = odbc_exec($dbhandle,$sql);
			if(odbc_num_rows($query) > 0){
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Email này đã được sử dụng rồi</font></b></center>";
			}
			
			if(md5($validated_data['Password']) != md5($validated_data['verifyPassword'])){
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Mật khẩu không trùng khớp</font></b></center>";
			}

			if(md5($validated_data['Password2']) != md5($validated_data['verifyPassword2'])){
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Mật khẩu cấp 2 không trùng khớp</font></b></center>";
			
			}
			
			if($err == 0){
				$cauhoi = str_replace(" ","",$cauhoi).'?';
				$sql =  "INSERT INTO TBL_Account (FLD_ID,FLD_PASSWORD,FLD_PASSWORD2,FLD_CARD,FLD_NAME,FLD_QU,FLD_ANSWER,FLD_Mail,FLD_SEX,FLD_REGIP,FLD_RXPIONT,FLD_RXPIONTX)values('$acc','$pass','$pass2','$cmnd','$hoten','$cauhoi','$traloi','$mail','$sex','$ip',0,0)";
				$query = odbc_exec($dbhandle,$sql);
				$error1 = "<br><center><b><font color=green size=4>Chúc mừng, đăng ký tài khoản: <u>".$acc."</u> thành công !!!</font></b></center>";
			}
				
			}
			else if (!preg_match($partten ,$pass, $matchs)){
				$error1 = "Mật khẩu 1 chưa đúng định dạng.<br>Mật khẩu đúng địng dạng có mẫu: HkGiangHo2022<br>Vừa có kí tự chữ hoa nằm đầu tiên, vừa có kí tự chữ thường và vừa có chữ số";
			}
			else{
				$error1 = "Mật khẩu 2 chưa đúng định dạng.<br>Mật khẩu đúng địng dạng có mẫu: HkGiangHo2022<br>Vừa có kí tự chữ hoa nằm đầu tiên, vừa có kí tự chữ thường và vừa có chữ số";
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
		<span align="center"><h1><font color="blue">Đăng ký tài khoản mới</font></h1></span>
	<hr style="margin: 15px 0;">
	<center><h3><font color="red"><?php echo $error1;?></font></h3></center>
	
	
	



<form method="POST" autocomplete="off">
<table width="80%" align="center" style="padding-top:3%;">
<tbody>

<tr>
    <td class="span"  align="right">
        Lưu ý:    </td>
    <td><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mật khẩu phải có kí tự chữ hoa nằm đầu tiên.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vừa có kí tự chữ thường.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hoặc có chữ số. Ví dụ: <b>HKGiangHo2022</b></i>    </td>
</tr>
<tr>
							<td width="30%" align="right" class="span">
												<span>Tài khoản: </span></td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="username" name="username" size="36" maxlength="12" placeholder="Tài khoản | A-Za-z0-9 | hiepkhachacc" pattern="[A-Za-z0-9]+">
        <div class = "error"><?php echo isset($error->Username) ? $error->Username : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Mật khẩu:     </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="password" name="Password" size="36" maxlength="16"  placeholder="Mật khẩu | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
		<div class = "error"><?php echo isset($error->Password) ? $error->Password : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Nhập lại:    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="verifyPassword" name="verifyPassword" size="36" maxlength="16" placeholder="Nhập lại mật khẩu | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Mật khẩu 2:   </td>
		
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="Password2" name="Password2" size="36" maxlength="16"  placeholder="Mật khẩu cấp 2 | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">
		<div class = "error"><?php echo isset($error->Password2) ? $error->Password2 : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Nhập lại:  </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="password" value="" id="verifyPassword2" name="verifyPassword2" size="36" maxlength="16" placeholder="Nhập lại mật khẩu cấp 2 | A-Za-z0-9 | ******" pattern="[A-Za-z0-9]+">    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Email :  </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="email" name="email" size="36" maxlength="45" placeholder="Email | A-Za-z0-9@ | admin@daotest.com" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$">
		<div class = "error"><?php echo isset($error->Email) ? $error->Email : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Họ tên:   </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="fullname" name="fullname" size="36" maxlength="50" placeholder="Họ và tên | A-Za-z0-9 | Nguyen Van A" pattern="[A-Za-z0-9 ]+">
		<div class = "error"><?php echo isset($error->Fullname) ? $error->Fullname : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Số ĐT:   </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="identityNumber" name="identityNumber" size="36" maxlength="16" placeholder="Số điện thoại | 0-9 | 01202456789" pattern="[0-9]+">      
		<div class = "error"><?php echo isset($error->IdentityNumber) ? $error->IdentityNumber : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        Giới tính: </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="sex" id="sex" value="1">
        Nam 
        <input type="radio" name="sex" id="sex" value="2"> 
        Nữ</td>
</tr>
<tr></tr>
<tr>
    <td class="span"  align="right">
        Câu hỏi:   </td>
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
		<div class = "error"><?php echo isset($error->Cauhoi) ? $error->Cauhoi : '' ?></div>    </td>
</tr>
<tr>
    <td class="span"  align="right">
        <span>Câu trả lời: </span></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="srk" type="text" value="" id="traloi" name="traloi" size="36" maxlength="50" placeholder="Câu trả lời bí mật | A-Za-z0-9 | Nguyễn Văn A" pattern="[A-Za-z0-9 ]+">
		<div class = "error"><?php echo isset($error->Traloi) ? $error->Traloi : '' ?></div>    </td>
</tr>
<tr>
    <td colspan="1" width="37%">    </td>
    <td colspan="3" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input class="buttonBluel" type="submit" value="Đăng ký" id="submit" name="submit" /></td>
</tr>
</tbody>
</table>
</form>     
</div>