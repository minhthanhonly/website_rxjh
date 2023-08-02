
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
<a href="./?a=ranking" class="style2">Xếp hạng cấp độ</a> | <a href="./?a=tlc" class="style2">Xếp hạng thế lực chiến</a> | <a href="./?a=taiphu" class="style1">Xếp hạng tài phú</a>
<hr style="margin: 5px 0;">
	<table class="tbl">
		<thead>
		<tr>
			<th width="10%">Thứ tự</th>
			<th width="15%">Tài khoản</th>
			<th width="15%">Điểm</th>
		</tr>
		</thead>
<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	
	require "./include/conn.php";
	//$sql_command = "SELECT 人物名,帮派,势力,等级,杀人数,死亡数 from rxjhgame.dbo.EventTop order by 杀人数 desc, (杀人数-死亡数) desc, 等级 desc";
	//and ((DATEPART(HOUR,GETDATE())-1 >= DATEPART(HOUR,thoigian)) OR DATEPART(DAY,GETDATE()) != DATEPART(DAY,thoigian))
	$sql_command = "
					SELECT   TOP 25  taikhoan, SUM(CONVERT(int,menhgia)) AS tien
					FROM         rxjhaccount.dbo.napthe
					--WHERE thoigian >= '2017-01-27 00:00:00' and thoigian < '2017-01-30 00:00:00' 
					GROUP BY taikhoan
					ORDER BY SUM(CONVERT(int,menhgia)) DESC
					";
	
	$item = odbc_exec($dbhandle, $sql_command);
	$rank = 0;
	while($row = odbc_fetch_array($item))
	{
		echo "<tr style=\"background-color:#".($rank%2==0?"FBF8EF":"E0E6F8").";\" height=\"25px\">
		<td><center><FONT COLOR='Black'><b>".++$rank."</td>
		<td><center><FONT COLOR='Black'>&nbsp;".$row['taikhoan']."&nbsp;</td>
		<td><center><FONT COLOR='Black'>&nbsp;".(round($row['tien']/6996))."&nbsp;</td>
		</tr>";
	}
	
	
?>
	</table>
</div>