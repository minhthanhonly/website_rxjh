
<div align="center">
<hr style="margin: 5px 0;"><b><font size="4">
<a href="./?a=ranking">X&#7871;p h&#7841;ng c&#7845;p &#273;&#7897;</a> | <a href="./?a=tlc">X&#7871;p h&#7841;ng th&#7871; l&#7921;c chi&#7871;n</a> | <a href="./?a=taiphu">X&#7871;p h&#7841;ng t&#224;i ph&#250;</a>
<hr style="margin: 5px 0;"></font></b>
	<table align='center' width='95%' border='0' cellspacing='0' cellpadding='0'>
		<tr style="color:#CCCCFF;background-color:#000000;font-weight:bold;" height="30px">
			<td width="5%"><FONT COLOR="White"><center><b>T.t&#7921;</td>
			<td width="20%"><FONT COLOR="White"><center><b>T&#234;n nh&#226;n v&#7853;t</td>
			<td width="15%"><FONT COLOR="White"><center><b>Lo&#7841;i</td>
			<td width="5%"><FONT COLOR="White"><center><b>C&#7845;p</td>
			<td width="20%"><FONT COLOR="White"><center><b>M&#244;n ph&#225;i</td>
			<td width="15%"><FONT COLOR="White"><center><b>Th&#7871; l&#7921;c</td>
			<td width="5%"><FONT COLOR="White"><center><b>Gi&#7871;t</td>
			<td width="5%"><FONT COLOR="White"><center><b>Ch&#7871;t</td>
			<td width="5%"><FONT COLOR="White"><center><b>&#272;i&#7875;m</td>
		</tr>
<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	
	require "./include/conn.php";
	//$sql_command = "SELECT 人物名,帮派,势力,等级,杀人数,死亡数 from rxjhgame.dbo.EventTop order by 杀人数 desc, (杀人数-死亡数) desc, 等级 desc";
	$sql_command = "SELECT 人物名,帮派,势力,等级,杀人数,死亡数 from rxjhgame.dbo.EventTop order by (杀人数-死亡数) desc, 等级 desc";
	
	$item = odbc_exec($dbhandle, $sql_command);
	$numberofitem = odbc_num_rows($item);
$line=25;
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
		$page=0;
}
	if($line*($page) >= $numberofitem || $page<0)
	{
		echo "<font color=red size=69><b>?</b></font>";
		die;
	}



$i=-1;
while($row = odbc_fetch_array($item))
{
	$i++;
	if($i>=$line*$page && $i<$line*($page+1))
	{
		$rank = $i+1;


	$guild = $row['帮派'];
	$gx = substr($guild, -1);
	if(!(($gx >= 'a' && $gx <= 'z')||($gx >= 'A' && $gx <= 'Z')||($gx >= '0' && $gx <= '9')))
	{
		$guild = substr($guild, 0, -2);
	}
	$theluc = "Kh&#244;ng c&#243;";
	if($row['势力'] == '正')
	{
		$theluc = "<font color=\"blue\">Ch&#237;nh ph&#225;i</font>";
	}
	else if($row['势力'] == '邪')
	{
		$theluc = "<font color=\"red\">T&#224; ph&#225;i</font>";
	}
	$loai = "Kh&#244;ng x&#225;c &#273;&#7883;nh";
	
	$sqll = "SELECT FLD_JOB FROM rxjhgame.dbo.TBL_Xwwl_Char WHERE FLD_NAME = '".$row['人物名']."'";
	$queryy = odbc_exec($dbhandle,$sqll);
	$resultt = odbc_fetch_array($queryy);
	if($resultt['FLD_JOB'] == 1){
		$loai = "&#272;ao Kh&#225;ch";
	}
	else if($resultt['FLD_JOB'] == 2){
		$loai = "Ki&#7871;m Kh&#225;ch";
	}
	else if($resultt['FLD_JOB'] == 3){
		$loai = "Th&#432;&#417;ng H&#224;o";
	}
	else if($resultt['FLD_JOB'] == 4){
		$loai = "Cung Th&#7911;";
	}
	else if($resultt['FLD_JOB'] == 5){
		$loai = "&#272;&#7841;i Phu";
	}
	else if($resultt['FLD_JOB'] == 6){
		$loai = "Th&#237;ch Kh&#225;ch";
	}
	else if($resultt['FLD_JOB'] == 7){
		$loai = "C&#7847;m S&#432;";
	}
	else if($resultt['FLD_JOB'] == 8){
		$loai = "H&#224;n B&#7843;o Qu&#226;n";
	}
	else if($resultt['FLD_JOB'] == 9){
		$loai = "&#272;&#224;m Hoa Li&#234;n";
	}
	else if($resultt['FLD_JOB'] == 10){
		$loai = "Quy&#7873;n S&#432;";
	}
				
	echo "<tr style=\"background-color:#".($i%2==0?"FBF8EF":"E0E6F8").";\" height=\"25px\">
	<td><center><FONT COLOR='Black'><b>".$rank."</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['人物名']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$loai."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['等级']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$guild."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$theluc."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['杀人数']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['死亡数']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".($row['杀人数']-$row['死亡数'])."&nbsp;</td>
	</tr>";
	}
}
	
	
	
?>
	</table>
	<hr style="margin: 10px 0;">
	<form action="" method="post" id="form1">
	  <center>
	  <?php
	  $truoc=$page-1;
	  $sau=$page+1;
	  $sotrang=round(($numberofitem/$line)-0.5);
	  echo"<i>Trang $page c&#7911;a $sotrang</i> | ";
	for ( $i = $page-2; $i <= $page+2; $i++ )
	{
		if($i>=0 && $i<=$sotrang)
		{
			if($i==$page)
				echo"<strong><font color='red'>$i</font></strong> ";
			else
				echo "<a href='?a=tlc&page=$i'><font color='black'>$i</font></a> ";
		}
	}
	 ?>
	  | 
			<input type="number" name="trang" min="0" max="<?php echo $sotrang;?>" value="<?php echo $page;?>"/>
			<button type="submit">&#272;&#7871;n</button>
	  </center>
	</form>
	
</div>