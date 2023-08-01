<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	$error1="";
	$err = 0;
	
	
	if(isset($_SESSION["auth"]['name'])){
		$acc = $_SESSION["auth"]['name'];
		$sql = "SELECT SUM(Cash) AS Tong FROM TBL_ADDCASH where account = '".$_SESSION["auth"]['name']."' GROUP BY account";
		$que = odbc_exec($dbhandle,$sql);
		$kq = odbc_fetch_array($que);
		$tiennhanduoc = 0;
		if(odbc_num_rows($que) == 1)
			$tiennhanduoc = $kq['Tong'];
		
		if($_POST){
			
			$sql1 = "SELECT FLD_ONLINE FROM TBL_ACCOUNT WHERE FLD_ID = '".$_SESSION["auth"]['name']."'";
			$query1 = odbc_exec($dbhandle,$sql1);
			$result1 = odbc_fetch_array($query1);
			if($tiennhanduoc <= 0 || odbc_num_rows($que) != 1) {
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Tài khoản bạn không còn @CASH để nhận!</font></b></center>";
			}
			if($result1['FLD_ONLINE'] != 0) {
				$err = 1;
				$error1 = "<br><center><b><font color=red size=4>Tài khoản đang online, vui lòng thoát game!</font></b></center>";
			}
			if($err == 0)
			{
				$cashold = $_SESSION["auth"]['FLD_RXPIONT'];
				
				odbc_exec($dbhandle,"DELETE TBL_ADDCASH WHERE account='".$_SESSION["auth"]['name']."'");
				odbc_exec($dbhandle,"UPDATE TBL_ACCOUNT SET FLD_RXPIONT=FLD_RXPIONT+'".$tiennhanduoc."', FLD_RXPIONTX=FLD_RXPIONTX+'".$tiennhanduoc."' WHERE FLD_ID='".$_SESSION["auth"]['name']."'");
				$_SESSION["auth"]['FLD_RXPIONT'] += $tiennhanduoc;
				$error1 = "<br><center><b><font color=green size=4>Tài khoản <u>".$_SESSION["auth"]['name']."</u> đã nhận <u>".$tiennhanduoc."</u> @CASH!<br>".$cashold." + ".$tiennhanduoc." = ".$_SESSION["auth"]['FLD_RXPIONT']."</font></b></center>";
				
				
					$fh = fopen("C:\checknhancash.txt",'a') or die("cant open file");
					fwrite($fh,date("Y-m-d H:i:s")." : Tài khoản ".$_SESSION["auth"]['name']." đã nhận ".$tiennhanduoc." @CASH! (".$cashold." + ".$tiennhanduoc." = ".$_SESSION["auth"]['FLD_RXPIONT'].")");
					fwrite($fh,"\r\n");
					fclose($fh);
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
		<span align="center"><h1><font color="blue">Nhận thưởng @CASH</font></h1></span>
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
<font size="4" color="black"><b>Chào <font color="red"><?php echo $_SESSION["auth"]['FLD_NAME'];?></font>! Tài khoản của bạn được nhận <font color="red"><?php echo $tiennhanduoc;?></font>@CASH</b></font>
    <td colspan="1" width="20%">
    </td>
    <td colspan="3" width="100%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="buttonBluel" type="submit" value="Nhận thưởng @CASH" id="submit" name="submit">
    </td>
</tr>
</tbody>
</table>
</form>     
</div>