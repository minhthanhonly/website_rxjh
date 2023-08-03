
<h1 class="hdg-01">
	Bảng Xếp Hạng
</h1>
<style type="text/css">
<!--
.style1 {color: green}
.style2 {color: #FF0000}
.style3 {color: #FFFFFF}
-->
</style>
<div align="center">
<hr style="margin: 5px 0;">
<a href="./?a=ranking" class="style2">X&#7871;p h&#7841;ng c&#7845;p &#273;&#7897;</a> | <a href="./?a=tlc"  class="style1">X&#7871;p h&#7841;ng th&#7871; l&#7921;c chi&#7871;n</a> | <a href="./?a=taiphu"  class="style2">X&#7871;p h&#7841;ng t&#224;i ph&#250;</a>
<hr style="margin: 5px 0;">
	<table class="tbl">
		<thead>
		<tr>
			<th width="5%">T.t&#7921;</th>
			<th width="20%">T&#234;n nh&#226;n v&#7853;t</th>
			<th width="15%">Lo&#7841;i</th>
			<th width="5%">C&#7845;p</th>
			<th width="20%">M&#244;n ph&#225;i</th>
			<th width="15%">Th&#7871; l&#7921;c</th>
			<th width="5%">Gi&#7871;t</th>
			<th width="5%">Ch&#7871;t</th>
			<th width="5%">&#272;i&#7875;m</th>
		</tr>
		</thead>
<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	
	require "./include/conn.php";
	//$sql_command = "SELECT ������,����,����,�ȼ�,ɱ����,������ from rxjhgame.dbo.EventTop order by ɱ���� desc, (ɱ����-������) desc, �ȼ� desc";
	$sql_command = "SELECT ������,����,����,�ȼ�,ɱ����,������ from rxjhgame.dbo.EventTop order by (ɱ����-������) desc, �ȼ� desc";
	
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
			// echo "<font color=red size=69><b>?</b></font>";
			// die;
			//$error = (object)$validate->get_errors_array();
		} 
		else {
			$page=$validated_data["trang"] -1;
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
			// echo "<font color=red size=69><b>?</b></font>";
			// die;
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
		// echo "<font color=red size=69><b>?</b></font>";
		// die;
	}



$i=-1;
while($row = odbc_fetch_array($item))
{
	$i++;
	if($i>=$line*$page && $i<$line*($page+1))
	{
		$rank = $i+1;


	$guild = $row['����'];
	$gx = substr($guild, -1);
	if(!(($gx >= 'a' && $gx <= 'z')||($gx >= 'A' && $gx <= 'Z')||($gx >= '0' && $gx <= '9')))
	{
		$guild = substr($guild, 0, -2);
	}
	$theluc = "Kh&#244;ng c&#243;";
	if($row['����'] == '��')
	{
		$theluc = "<font color=\"blue\">Ch&#237;nh ph&#225;i</font>";
	}
	else if($row['����'] == 'а')
	{
		$theluc = "<font color=\"red\">T&#224; ph&#225;i</font>";
	}
	$loai = "Kh&#244;ng x&#225;c &#273;&#7883;nh";
	
	$sqll = "SELECT FLD_JOB FROM rxjhgame.dbo.TBL_Xwwl_Char WHERE FLD_NAME = '".$row['������']."'";
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
	<td><center><FONT COLOR='Black'>&nbsp;".$row['������']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$loai."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['�ȼ�']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$guild."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$theluc."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['ɱ����']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['������']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".($row['ɱ����']-$row['������'])."&nbsp;</td>
	</tr>";
	}
}
	
	
	
?>
	</table>
	<hr class="mt20">
	<form action="" method="post" id="form1">
		<div class="flex pagination">
			<?php
			$truoc = $page - 1;
			$sau = $page + 1;
			$sotrang = round(($numberofitem / $line) - 0.51);
			echo "<p>Trang ".($page + 1)." / $sotrang</p>";
			echo "<div class='flex gap10'>";

			for ($i = 1; $i <= $sotrang; $i++) {
				if ($i == $page + 1)
					echo "<strong class='current'>" . $i . "</strong>";
				else
					echo "<a href='?a=tlc&page=" . ($i  - 1). "&type=" . $type . "'>" . $i . "</a> ";
			}
			?>
			<input type="number" name="trang" min="1" max="<?php echo $sotrang; ?>" value="<?php echo $page +1; ?>" class='ml10'">
			<input type="submit" value="Đến"></input>
			</div>
		</div>
	</form>
	
</div>