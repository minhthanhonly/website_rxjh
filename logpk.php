<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	$error1 = "";
	$err = 0;
	
	
	if(isset($_SESSION["auth"]['name'])){
		$acc = $_SESSION["auth"]['name'];
		$sql = "SELECT FLD_RXPIONT FROM TBL_ACCOUNT where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$playerInfo = odbc_fetch_array(odbc_exec($dbhandle,$sql));
		odbc_close($dbhandle);
		$sql = "SELECT FLD_NAME,FLD_LEVEL FROM TBL_XWWL_Char where FLD_ID = '".$_SESSION["auth"]['name']."'";
		$nv = odbc_exec($dbhandlegame,$sql);
		
		// if($_POST){
			
		// $valide = new GUMP();
		// $valide->validation_rules(array(
			// 'idnv'    => 'required|alpha_dash|max_len,16|min_len,4',
		// ));
		// $valide->filter_rules(array(
			// 'idnv' => 'trim|sanitize_string',
		// ));
		// $validated_data = $valide->run($_POST);
			// if($validated_data === false) {
				// $error1 = "Tên nhân vật không hợp lệ!";
				// //echo "error";
				// //die;
				// //$error = (object)$valide->get_errors_array();
			// }
			// else{
				// $nhanvat = $validated_data['idnv'];
				
			// }
		// }
		
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
<form method="POST" autocomplete="off">

	<hr>		
		<span align="center"><h2><font color="blue">Lịch sử PK!</font></h2></span>
	<hr>
				<table align='center' width='60%' border='0' cellspacing='0' cellpadding='0'>
					<tr style="color:#CCCCFF;background-color:#000000;font-weight:bold;" height="30px">
						<td width="10%"><FONT COLOR="White"><center><b>T.tự</td>
						<td width="25%"><FONT COLOR="White"><center><b>Người giết</td>
						<td width="25%"><FONT COLOR="White"><center><b>Người bị giết</td>
						<td width="40%"><FONT COLOR="White"><center><b>Thời gian</td>
					</tr>
				<?php
				$nhanvat = array("KhongXacDinh6996","KhongXacDinh6996","KhongXacDinh6996","KhongXacDinh6996");
				$i = 0;
				while($row = odbc_fetch_array($nv)) {
					$nhanvat[$i++] = $row['FLD_NAME'];
				}
				$sql_command = "SELECT Nguoigiet,Nguoibigiet,Thoigian from rxjhgame.dbo.LogPK where (Nguoigiet='".$nhanvat[0]."' or Nguoigiet='".$nhanvat[1]."' or Nguoigiet='".$nhanvat[2]."' or Nguoigiet='".$nhanvat[3]."') or (Nguoibigiet='".$nhanvat[0]."' or Nguoibigiet='".$nhanvat[1]."' or Nguoibigiet='".$nhanvat[2]."' or Nguoibigiet='".$nhanvat[3]."') order by Thoigian desc";
				// echo $sql_command;
				$item = odbc_exec($dbhandle, $sql_command);
				$numberofitem = odbc_num_rows($item);
				$line=24;
				$page=0;
				if($_POST)
				{
					if(isset($_POST["trang"]))
					{
						$validate = new GUMP();
						$_POST = $validate->sanitize($_POST);
						$validate->validation_rules(array(
							'trang'    => 'required|numeric|max_len,3',
						));
						$validate->filter_rules(array(
							'trang' => 'trim|whole_number',
						));
						$validated_data = $validate->run($_POST);
						if($validated_data === false) {
							echo "<font color=red size=69><b>?</b></font>";
							die;
							//$error = (object)$validate->get_errors_array();
						} 
						else {
							$page=$validated_data["trang"];
						}
					}
				}
				else
				{
					if(isset($_GET["page"]))
					{
						
						$validate = new GUMP();
						$_GET = $validate->sanitize($_GET);
						$validate->validation_rules(array(
							'page'    => 'required|numeric|max_len,3',
						));
						$validate->filter_rules(array(
							'page' => 'trim|whole_number',
						));
						$validated_data = $validate->run($_GET);
						if($validated_data === false) {
							echo "<font color=red size=69><b>?</b></font>";
							die;
							//$error = (object)$validate->get_errors_array();
						} 
						else {
							$page=$validated_data["page"];
						}
					}
				}
				if($line*($page) >= $numberofitem || $page<0)
				{
					echo "<font color=red size=69><b>Không xác định được!</b></font>";
					die;
				}
				
				$i=-1;
				while($row = odbc_fetch_array($item))
				{
					$i++;
					if($i>=$line*$page && $i<$line*($page+1))
					{
						
						
						echo "
						<tr style=\"background-color:#".($i%2==0?"FBF8EF":"E0E6F8").";\" height=\"25px\">
							<td><center><FONT COLOR='Black'><b>".($i+1)."</td>
							<td><center><FONT COLOR='Black'>&nbsp;".$row['Nguoigiet']."&nbsp;</td>
							<td><center><FONT COLOR='Black'>&nbsp;".$row['Nguoibigiet']."&nbsp;</td>
							<td><center><FONT COLOR='Black'>&nbsp;".$row['Thoigian']."&nbsp;</td>
						</tr>";
					}
				}
				?>
				</table>
				<hr style="margin: 5px 0;">
				  <center>
				  <?php
				  $truoc=$page-1;
				  $sau=$page+1;
				  $sotrang=round(($numberofitem/$line)-0.5);
				  echo"<i>Trang $page của $sotrang</i> | ";
				for ( $i = $page-2; $i <= $page+2; $i++ )
				{
					if($i>=0 && $i<=$sotrang)
					{
						if($i==$page)
							echo"<strong><font color='red'>$i</font></strong> ";
						else
							echo "<a href='?a=logpk&page=$i'><font color='black'>$i</font></a> ";
					}
				}
				 ?>
				  | 
						<input type="number" name="trang" min="0" max="<?php echo $sotrang;?>" value="<?php echo $page;?>"/>
						<button type="submit">Đến</button>
				  </center>
	<center><h3><font color="red"><?php echo $error1;?></font></h3></center>
</form>     
</div>