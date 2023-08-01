<table  align="center" border="0">

 <tr>
 <td>X&#7871;p h&#7841;ng&nbsp;</td>
<td>&nbsp;T&#234;n nh&#226;n v&#7853;t&nbsp;</td>
<td>&nbsp;Bang h&#7897;i&nbsp;</td>
<td>&nbsp;Th&#7871; l&#7921;c&nbsp;</td>
<td>&nbsp;C&#7845;p &#273;&#7897;&nbsp;</td>
<td>&nbsp;Gi&#7871;t&nbsp;</td>
<td>&nbsp;Ch&#7871;t&nbsp;</td>
<?
$dbhost = "WIN-CLJ1B0GQ6JP\SQLEXPRESS";
$dbuser = "sa";
$dbpasswd = "wang567";
$db = 'rxjhgame';


$msconnect=mssql_connect("$dbhost","$dbuser","$dbpasswd");
$msdb=mssql_select_db("$db",$msconnect);
$ip = $host;
$query1 = 'SELECT TOP 30 NHAN_VAT_TEN,BANG_PHAI,THE_LUC,DANG_CAP,GIET_NGUOI_SO,TU_VONG_SO from EventTop order by É±ÈËÊý desc';
$result1 = mssql_query($query1);
?>
<td><?
for($i=0;$i < mssql_num_rows($result1);++$i)
{
$row = mssql_fetch_row($result1);
$rank = $i+1;

$faction = $i+1;
if($row[2] == 'Ch&#237;nh Ph&#225;i'){$row[2] = '<font color=blue>Ch&#237;nh Ph&#225;i</font>';}
elseif($row[2] == 'T&#224; Ph&#225;i'){$row[2] = '<font color=red>T&#224; Ph&#225;i</font>';}

echo "<tr>
<td>$rank&nbsp;</td>
<td>&nbsp;$row[0]&nbsp;</td>
<td>&nbsp;$row[1]&nbsp;</td>
<td>&nbsp;$row[2]&nbsp;</td>
<td>&nbsp;$row[3]&nbsp;</td>
<td>&nbsp;$row[4]&nbsp;</td>
<td>&nbsp;$row[5]&nbsp;</td>
</tr>";
}
?>

  </tr></table>