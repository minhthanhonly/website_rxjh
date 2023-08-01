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

							<div style="width:100%; height:30%; padding-top:0%;" align="center">
								<hr style="margin: 15px 0;">
								<span align="center"><h1><font color="blue">Thông tin tài khoản</font></h1></span>
								<hr style="margin: 15px 0;">
									<table width="80%" align="center" style="padding-top:3%;">
										<tr align="right" height="60px">
											<td width="30%" align="right">Tài khoản:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" value="<?php echo $_SESSION["auth"]['name'];?>" id="hw_an" pattern="[A-Za-z0-9]+" type="text" size="35" disabled></td>
										</tr>
										<tr height="60px">
											<td align="right">Mật khẩu cấp 1:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" value="******" id="hw_sk" pattern="[A-Za-z0-9]+" type="password" size="35" disabled></td>
										</tr>
										<tr height="60px">
											<td align="right">Mật khẩu cấp 2:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" value="******" id="hw_sk" pattern="[A-Za-z0-9]+" type="password" size="35" disabled></td>
										</tr>
										<tr height="60px">
											<td align="right">Cash hiện có:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" value="<?php echo number_format($_SESSION["auth"]['FLD_RXPIONT'],0);?>@" id="hw_sk" pattern="[0-9]+" type="text" size="35" disabled></td>
										</tr>
										<tr height="60px">
											<td align="right">Trạng thái:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" value="<?php echo $_SESSION["auth"]['FLD_ONLINE']>0?"ONLINE":"OFFLINE"; ?>" id="hw_sk" pattern="[0-9]+" type="text" size="35" disabled></td>
										</tr>
										<tr height="60px">
											<td align="right">Nhân vật:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;
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
										<tr height="60px">
											<td align="right">Họ và tên:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" value="<?php echo $_SESSION["auth"]['FLD_NAME'];?>" id="hw_sk" pattern="[A-Za-z0-9]+" type="text" size="35" disabled></td>
										</tr>
										<tr height="60px">
											<td align="right">Email:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" name="passx" value="<?php echo substr(strstr($_SESSION["auth"]['FLD_Mail'], '@', true),0,2)."******".strstr($_SESSION["auth"]['FLD_Mail'], '@');?>" id="hw_sk" pattern="[A-Za-z0-9]+" type="text" size="35" disabled>
											</td>
										</tr>
										<tr height="60px">
											<td align="right">Thời gian đăng nhập cuối:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="padding: 10px 10px;" class="inpt" name="passx" value="<?php echo $_SESSION["auth"]['FLD_LASTLOGINTIME'];?>" id="hw_sk" pattern="[A-Za-z0-9]+" type="text" size="35" disabled></td>
										</tr>
									</span>
									</table>
									
								</div>


