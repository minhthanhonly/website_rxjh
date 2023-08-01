<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	$error1="";
	$err = 0;
	
	
	if(isset($_SESSION["auth"]['name'])){
		$acc = $_SESSION["auth"]['name'];
		$sql = "SELECT FLD_RXPIONT FROM TBL_ACCOUNT where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$playerInfo = odbc_fetch_array(odbc_exec($dbhandle,$sql));
		odbc_close($dbhandle);
		$sql = "SELECT FLD_NAME,FLD_LEVEL FROM TBL_XWWL_Char where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$nv = odbc_exec($dbhandlegame,$sql);
		
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
			die;
			$error = (object)$valide->get_errors_array();
		}
		$nhanvat = $validated_data['idnv'];
		
			$sql1 = "SELECT FLD_ONLINE FROM TBL_ACCOUNT WHERE FLD_ID = '".$acc."'";
			$query1 = odbc_exec($dbhandle,$sql1);
			$result1 = odbc_fetch_array($query1);
			if($result1['FLD_ONLINE'] != 0){
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Tài khoản đang online, vui lòng thoát game</font></b></center>";
			}
			$sql = "SELECT Name,Exp FROM rxjhgame.dbo.FIXEXP WHERE Name='".$nhanvat."'";
			$query = odbc_exec($dbhandle,$sql);
			if(odbc_num_rows($query) <= 0){
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Nhân vật ".$nhanvat." không có trong danh sách</font></b></center>";
			}
			$result = odbc_fetch_array($query);
			$exp = $result['Exp'];
			if($err == 0 && $exp>0 && $exp < 9999999999)
			{
				odbc_exec($dbhandle,"DELETE rxjhgame.dbo.FIXEXP WHERE Name='".$nhanvat."'");
				odbc_exec($dbhandle,"update rxjhgame.dbo.TBL_XWWL_Char SET FLD_EXP=FLD_EXP+".$exp." WHERE FLD_NAME='".$nhanvat."'");
				$error1 = "<br><center><b><font color=green size=4>Nhân vật ".$nhanvat." đã nhận exp đền bù thành công!</font></b></center>";
			}else{
				$error1 = "<br><center><b><font color=red size=4>Loi: ".$nhanvat."</font></b></center>";
			}
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
		<span align="center"><h1><font color="blue">Nhận fix exp</font></h1></span>
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
<tr>
    <td colspan="1" width="20%">
    </td>
    <td colspan="3" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="buttonBluel" type="submit" value="Nhận fix exp" id="submit" name="submit">
    </td>
</tr>
</tbody>
</table>
</form>     
</div>