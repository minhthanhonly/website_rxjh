<br>
<div align="center">
	<table width="90%" border="0">
		<tr  align="center">
			<td width="25%">
				<a href="?a=webshop&page=0&type=0"><h2><font color="blue">Tất cả</font></h2></a>
			</td>
			<td width="25%">
				<a href="?a=webshop&page=0&type=1"><h2><font color="blue">Kỳ phẩm</font></h2></a>
			</td>
			<td width="25%">
				<a href="?a=webshop&page=0&type=2"><h2><font color="blue">Áo choàng nữ</font></h2></a>
			</td>
			<td width="25%">
				<a href="?a=webshop&page=0&type=3"><h2><font color="blue">Áo choàng nam</font></h2></a>
			</td>
			<td width="25%">
				<a href="?a=webshop&page=0&type=4"><h2><font color="blue">TEST AO CHOANG</font></h2></a>
			</td>
		</tr>
	</table>
	<hr style="margin: 10px 0;">
	<table align="center" width="98%" border="0" cellspacing="0" cellpadding="0">
		<tr style="color:#CCCCFF;background-color:#000000;font-weight:bold;" height="30px">
		<!--<td width="2%"><FONT COLOR="White"><center><b>T.tự</td>-->
		<td width="10%"><FONT COLOR="White"><center><b>Lệnh mua</td>
		<td width="25%"><FONT COLOR="White"><center><b>Tên vật phẩm</td>
		<td width="5%"><FONT COLOR="White"><center><b>Ảnh</td>
		<td width="5%"><FONT COLOR="White"><center><b>Giá</td>
		<td width="50%"><FONT COLOR="White"><center><b>Thông tin vật phẩm</td>
		<td width="5%"><FONT COLOR="White"><center><b>T.gian</td>
<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	
	require "./include/conn.php";

	if(isset($_GET["type"]))
	{
		
		$validate = new GUMP();
		$_GET = $validate->sanitize($_GET);
		$validate->validation_rules(array(
			'type'    => 'required|numeric|max_len,1',
		));
		$validate->filter_rules(array(
			'type' => 'trim|whole_number',
		));
		$validated_data = $validate->run($_GET);
		if($validated_data === false) {
			echo "<font color=red size=69><b>?</b></font>";
			die;
			//$error = (object)$validate->get_errors_array();
		} 
		else {
			$type=$validated_data["type"];
		}
		
		
	}
	else
		$type=0;
	
	
	$item = "";
	if ($type == 0)
	{
		$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg_test.dbo.ITEMSELL Order by ID DESC");
	}
	else if ($type == 1)
	{
		$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg_test.dbo.ITEMSELL where FLD_TYPE=1 Order by ID");
	}
	else if ($type == 2)
	{
		$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg_test.dbo.ITEMSELL where FLD_TYPE=2 Order by FLD_PRICE,ID");
	}
	else if ($type == 3)
	{
		$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg_test.dbo.ITEMSELL where FLD_TYPE=3 Order by FLD_PRICE,ID");
	}
	else if ($type == 4)
	{
		$item = odbc_exec($dbhandle, "SELECT id,FLD_PID,CONVERT(varbinary(MAX), FLD_NAME),FLD_PRICE,CONVERT(varbinary(MAX), FLD_DESC),FLD_DAYS from bbg_test.dbo.ITEMSELL where FLD_TYPE=4");
	}
	else
	{
		die;
	}
	$numberofitem = odbc_num_rows($item);
?>
<?php
$line=14;
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
	else
	{
		$page=0;
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
	else
	{
		$page=0;
	}
}
	if($line*($page) >= $numberofitem || $page<0)
	{
		echo "<font color=red size=69><b>?</b></font>";
		die;
	}



$i=-1;
while(odbc_fetch_row($item))
{
	$i++;
	if($i>=$line*$page && $i<$line*($page+1))
	{
		
		$tenitem = iconv('UTF-16LE', 'UTF-8', odbc_result($item, 3));
		$desitem = iconv('UTF-16LE', 'UTF-8', odbc_result($item, 5));
		// $tenitem = odbc_result($item, 3);
		// $desitem = odbc_result($item, 5);
		echo "<tr style=\"background-color:#".($i%2==0?"FBF8EF":"E0E6F8").";\" height=\"40px\">
		<!--<td><center><FONT COLOR='Black'><b>".($i + 1)."</td>-->
		<td><center><FONT COLOR='Black'>&nbsp;!mua ".odbc_result($item, 1)."&nbsp;</td>
		<td><center>&nbsp;".$tenitem."&nbsp;</td>
		<td><center><FONT COLOR='Black'>&nbsp;<img src=\"../cpanel/WEBSHOP/ITEM/".odbc_result($item, 2).".gif\"&nbsp;</td>
		<td><center><FONT COLOR='Black'>&nbsp;".number_format(odbc_result($item, 4),0)."@&nbsp;</td>
		<td><center>&nbsp;".$desitem."&nbsp;</td>
		<td><center>&nbsp;".(odbc_result($item, 6)==0?"V.viễn":odbc_result($item, 6)." ngày")."&nbsp;</td>
		</tr>";
	}
}
	
	
	
?>
		</tr>
	</table>
	<hr style="margin: 10px 0;">
	<form action="" method="post" id="form1">
	  <center>
	  <?php
	  $truoc=$page-1;
	  $sau=$page+1;
	  $sotrang=round(($numberofitem/$line)-0.51);
	  echo"<i>Trang $page của $sotrang</i> | ";
	for ( $i = $page-2; $i <= $page+2; $i++ )
	{
		if($i>=0 && $i<=$sotrang)
		{
			if($i==$page)
				echo"<strong><font color='red'>".$i."</font></strong> ";
			else
				echo "<a href='?a=webshop&page=".$i."&type=".$type."'><font color='black'>".$i."</font></a> ";
		}
	}
	 ?>
	  | 
			<input type="number" name="trang" min="0" max="<?php echo $sotrang;?>" value="<?php echo $page;?>"/>
			<button type="submit">Đến</button>
	  </center>
	</form>
	
</div>