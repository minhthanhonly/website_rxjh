<?php
	// session_start();
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	// require "/include/gameconn.php";
	if(isset($_SESSION["auth"]['name'])){
		$sql = "SELECT FLD_RXPIONT FROM TBL_ACCOUNT where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$playerInfo = odbc_fetch_array(odbc_exec($dbhandle,$sql));
		odbc_close($dbhandle);
		$sql = "SELECT FLD_NAME,FLD_LEVEL FROM TBL_XWWL_Char where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$nv = odbc_exec($dbhandlegame,$sql);
	}else{
		echo "<script>window.location.href = \"./?a=login\";</script>";
		die;
	}
	
?>

<div>
	<h1>Thông tin tài khoản</h1>
		<table class="tbl">
			<tr>
				<td width="30%" class="right">Tài khoản:</td>
				<td><input class="inpt" value="<?php echo $_SESSION["auth"]['name'];?>" id="hw_an" pattern="[A-Za-z0-9]+" type="text" size="35" readonly></td>
			</tr>
			<tr>
				<td class="right">Mật khẩu cấp 1:</td>
				<td><input class="inpt" value="******" id="hw_sk" pattern="[A-Za-z0-9]+" type="password" size="35" readonly><br>
				<a href="/?a=changepass">
					Đổi mật khẩu
				</a> 
			</td>
			</tr>
			<tr>
				<td class="right">Mật khẩu cấp 2:</td>
				<td><input class="inpt" value="******" id="hw_sk" pattern="[A-Za-z0-9]+" type="password" size="35" readonly></td>
			</tr>
			<tr>
				<td class="right">Cash hiện có:</td>
				<td><input class="inpt" value="<?php echo number_format($_SESSION["auth"]['FLD_RXPIONT'],0);?>@" id="hw_sk" pattern="[0-9]+" type="text" size="35" readonly></td>
			</tr>
			<tr>
				<td class="right">Trạng thái:</td>
				<td><input class="inpt" value="<?php echo $_SESSION["auth"]['FLD_ONLINE']>0?"ONLINE":"OFFLINE"; ?>" id="hw_sk" pattern="[0-9]+" type="text" size="35" readonly></td>
			</tr>
			<tr>
				<td class="right">Nhân vật:</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;
					<?php if(odbc_num_rows($nv) > 0) {?>
						<select class="srk" name="idnv" id="idnv">
						<?php 
						while($row = odbc_fetch_array($nv)) {
							echo '<option value="'.$row['FLD_NAME'].'">Nhân vật: '.$row['FLD_NAME'].' - Cấp độ: '.$row['FLD_LEVEL'].'</option>';
						}
						?>
						</select>
					<?php }?>
				</td>
			</tr>
			<tr>
				<td class="right">Họ và tên:</td>
				<td><input class="inpt" value="<?php echo $_SESSION["auth"]['FLD_NAME'];?>" id="hw_sk" pattern="[A-Za-z0-9]+" type="text" size="35" readonly></td>
			</tr>
			<tr>
				<td class="right">Email:</td>
				<td><input class="inpt" name="passx" value="<?php echo substr(strstr($_SESSION["auth"]['FLD_Mail'], '@', true),0,2)."******".strstr($_SESSION["auth"]['FLD_Mail'], '@');?>" id="hw_sk" pattern="[A-Za-z0-9]+" type="text" size="35" readonly>
				</td>
			</tr>
			<tr>
				<td class="right">Thời gian đăng nhập cuối:</td>
				<td><input class="inpt" name="passx" value="<?php echo $_SESSION["auth"]['FLD_LASTLOGINTIME'];?>" id="hw_sk" pattern="[A-Za-z0-9]+" type="text" size="35" readonly></td>
			</tr>
			<tr>
				<th class="center" colspan="2">
					<a href="/?a=logout">
						<input type="submit" value="Đăng Xuất">
					</a> 
				</th>
			</tr>
		</span>
		</table>
		
	</div>


