<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	
	$error1="";
	
	
	
	
	if(isset($_SESSION["auth"]['name'])){
		$acc = $_SESSION["auth"]['name'];
		$sql = "SELECT FLD_RXPIONT FROM TBL_ACCOUNT where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$playerInfo = odbc_fetch_array(odbc_exec($dbhandle,$sql));
		odbc_close($dbhandle);
		$sql = "SELECT FLD_NAME,FLD_LEVEL,FLD_TAISINH FROM TBL_XWWL_Char where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$nv = odbc_exec($dbhandlegame,$sql);
		$nvv = odbc_exec($dbhandlegame,$sql);
		
		if($_POST){
			
		$valide = new GUMP();
		$valide->validation_rules(array(
			'idnv'    => 'required|alpha_dash|max_len,16|min_len,4',
		));
		$valide->filter_rules(array(
			'idnv' => 'trim|sanitize_string',
		));
		$validated_data = $valide->run($_POST);
		if($validated_data === false) {
			echo "error";
			$error = (object)$valide->get_errors_array();
			goto KETTHUC;
		}
		$nhanvat = $validated_data['idnv'];
		
		$CapDoHienTai = 1;
		$SoLanTrungsinh = 0;
		
		
			while($row = odbc_fetch_array($nvv)) {
				if($row['FLD_NAME'] == $nhanvat)
				{
					$error1 = "";
					$SoLanTrungsinh = $row['FLD_TAISINH'];
					$CapDoHienTai = $row['FLD_LEVEL'];
					break;
				}
			}
		$error1 = "<br><center><b><font color=red size=4>Tên nhân vật không chính xác</font></b></center>";
			if($SoLanTrungsinh <= 0) $data_reborn = $Reborn_1;
			else if($SoLanTrungsinh == 1) $data_reborn = $Reborn_2;
			else if($SoLanTrungsinh == 2) $data_reborn = $Reborn_3;
			else if($SoLanTrungsinh == 3) $data_reborn = $Reborn_4;
			else if($SoLanTrungsinh >= 4) $data_reborn = $Reborn_5;
			else die;
			
			$data_reborn = explode(";", $data_reborn);
			$capdoyeucau = $data_reborn[0];
			$dame = $data_reborn[1];
			$def = $data_reborn[2];
			$hp = $data_reborn[3];
			$mp = $data_reborn[4];
			$vh = $data_reborn[5];
			
			$sql1 = "SELECT FLD_ONLINE,FLD_RXPIONT FROM TBL_ACCOUNT WHERE FLD_ID = '".$_SESSION["auth"]['name']."'";
			$query1 = odbc_exec($dbhandle,$sql1);
			$result1 = odbc_fetch_array($query1);
			if($result1['FLD_ONLINE'] != 0){
				$error1 = "<br><center><b><font color=red size=4>Tài khoản đang online, vui lòng thoát game</font></b></center>";
				goto KETTHUC;
			}
			
			if($result1['FLD_RXPIONT'] < $Cost_Reborn){
				$error1 = "<br><center><b><font color=red size=4>Yêu cầu trùng sinh lần ".($SoLanTrungsinh+1)." là phải có ".$Cost_Reborn." CASH!</font></b></center>";
				goto KETTHUC;
			}
			if($CapDoHienTai < $capdoyeucau){
				$error1 = "<br><center><b><font color=red size=4>Yêu cầu trùng sinh lần ".($SoLanTrungsinh+1)." là phải đạt ".$capdoyeucau." cấp độ!</font></b></center>";
				goto KETTHUC;
			}
			
			odbc_exec($dbhandle,"update rxjhaccount.dbo.tbl_account set FLD_RXPIONT=FLD_RXPIONT-".$Cost_Reborn.",FLD_RXPIONTX=FLD_RXPIONTX-".$Cost_Reborn." where FLD_ID='".$_SESSION["auth"]['name']."'");
			odbc_exec($dbhandle,"update rxjhgame.dbo.TBL_XWWL_Char SET FLD_TAISINH=FLD_TAISINH+1,FLD_JOB_LEVEL=6,FLD_EXP=0,FLD_LEVEL=".$Level_TS.",FLD_ADD_AT=FLD_ADD_AT+".$dame.",FLD_ADD_DF=FLD_ADD_DF+".$def.",FLD_ADD_HP=FLD_ADD_HP+".$hp.",FLD_ADD_MP=FLD_ADD_MP+".$mp.",FLD_WX=FLD_WX+".$vh." WHERE FLD_NAME='".$nhanvat."'");
			odbc_exec($dbhandle,"exec rxjhgame.dbo.XoaKyNangThangThien @tennv = '".$nhanvat."'");
			$error1 = "<br><center><b><font color=green size=4>Nhân vật <font color=\"red\">".$nhanvat."</font> đã di trùng sinh lần <font color=\"red\">".($SoLanTrungsinh+1)."</font> thành công</font></b></center>";
			$SoLanTrungsinh++;
			KETTHUC:
		}
		
	}else{
		echo "<script>window.location.href = \"./?a=login\";</script>";
		die;
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
		<span align="center"><h1><font color="blue">Trùng sinh nhân vật</font></h1></span>
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
										<tr height="60px">
											<td align="right">Nhân vật:</td>
											<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<?php if(odbc_num_rows($nv) > 0) {?>
												  <select class="srk" name="idnv" id="idnv">
												  <?php 
												   while($row = odbc_fetch_array($nv)) {
														echo '<option value="'.$row['FLD_NAME'].'">Nhân vật: '.$row['FLD_NAME'].' - Cấp độ: '.$row['FLD_LEVEL'].' - Trùng sinh: '.$row['FLD_TAISINH'].'</option>';
													}
													?>
												  </select>
												<?php }?>
											</td>
										</tr>
<tr>
    <td colspan="1" width="20%">
    </td>
    <td colspan="3" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="buttonBluel" type="submit" value="Trùng sinh" id="submit" name="submit"> <b>-> Cấp độ sau khi trùng sinh là <font color="red"><?php echo $Level_TS?></font> cấp độ</b>
    </td>
</tr>
</tbody>
</table>
</form>
	<hr style="margin: 15px 0;"> 
<table border="1" cellpadding="0" cellspacing="0" width="90%">
		<tr style="background-color:#fdc780;font-weight:bold;" height="30px">
			<td width="10%"><center><b>Lần</td>
			<td width="10%"><center><b>Cấp độ</td>
			<td width="15%"><center><b>Tấn công</td>
			<td width="15%"><center><b>Phòng ngự</td>
			<td width="15%"><center><b>Sinh lực</td>
			<td width="15%"><center><b>Nội công</td>
			<td width="10%"><center><b>Võ huân</td>
			<td width="10%"><center><b>@CASH</td>
		</tr>
		<?php
		$data_reborn_1 = explode(";", $Reborn_1);
		$data_reborn_2 = explode(";", $Reborn_2);
		$data_reborn_3 = explode(";", $Reborn_3);
		$data_reborn_4 = explode(";", $Reborn_4);
		$data_reborn_5 = explode(";", $Reborn_5);
		?>
		<tr style="color:#000000;background-color:#FFFFFF;font-weight:bold;" height="25px">
			<td><center><b>0->1</td>
			<td><center><b><?php echo number_format($data_reborn_1[0], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_1[1], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_1[2], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_1[3], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_1[4], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_1[5], 0)?></td>
			<td><center><b>-<?php echo number_format($Cost_Reborn, 0)?></td>
		</tr>
		<tr style="color:#000000;background-color:#FFFFFF;font-weight:bold;" height="25px">
			<td><center><b>1->2</td>
			<td><center><b><?php echo number_format($data_reborn_2[0], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_2[1], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_2[2], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_2[3], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_2[4], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_2[5], 0)?></td>
			<td><center><b>-<?php echo number_format($Cost_Reborn, 0)?></td>
		</tr>
		<tr style="color:#000000;background-color:#FFFFFF;font-weight:bold;" height="25px">
			<td><center><b>2->3</td>
			<td><center><b><?php echo number_format($data_reborn_3[0], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_3[1], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_3[2], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_3[3], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_3[4], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_3[5], 0)?></td>
			<td><center><b>-<?php echo number_format($Cost_Reborn, 0)?></td>
		</tr>
		<tr style="color:#000000;background-color:#FFFFFF;font-weight:bold;" height="25px">
			<td><center><b>3->4</td>
			<td><center><b><?php echo number_format($data_reborn_4[0], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_4[1], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_4[2], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_4[3], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_4[4], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_4[5], 0)?></td>
			<td><center><b>-<?php echo number_format($Cost_Reborn, 0)?></td>
		</tr>
		<tr style="color:#000000;background-color:#FFFFFF;font-weight:bold;" height="25px">
			<td><center><b>4->5</td>
			<td><center><b><?php echo number_format($data_reborn_5[0], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_5[1], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_5[2], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_5[3], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_5[4], 0)?></td>
			<td><center><b>+<?php echo number_format($data_reborn_5[5], 0)?></td>
			<td><center><b>-<?php echo number_format($Cost_Reborn, 0)?></td>
		</tr>
	</table>
</div>