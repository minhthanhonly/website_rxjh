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
<a href="./?a=ranking" class="style1">Xếp hạng cấp độ</a> | <a href="./?a=tlc" class="style2">Xếp hạng thế lực chiến</a> | <a href="./?a=taiphu" class="style2">Xếp hạng tài phú</a>
<hr style="margin: 5px 0;">
<a href="./?a=ranking" class="<?php if(!isset($_GET["char"])) echo 'style1';?>">Toàn bộ</a> -
<a href="./?a=ranking&char=1" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 1) echo 'style1';?>">Đao</a> -
<a href="./?a=ranking&char=2" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 2) echo 'style1';?>">Kiếm</a> -
<a href="./?a=ranking&char=3" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 3) echo 'style1';?>">Thương</a> -
<a href="./?a=ranking&char=4" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 4) echo 'style1';?>">Cung</a> -
<a href="./?a=ranking&char=5" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 5) echo 'style1';?>">Đ.Phu</a> -
<a href="./?a=ranking&char=6" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 6) echo 'style1';?>">T.Khách</a> -
<a href="./?a=ranking&char=7" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 7) echo 'style1';?>">Cầm</a>
<!--<a href="./?a=ranking&char=8" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 8) echo 'style1';?>">HBQ</a> -
<a href="./?a=ranking&char=9" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 9) echo 'style1';?>">ĐHL</a> -
<a href="./?a=ranking&char=10" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 10) echo 'style1';?>">Quyền</a> -
<a href="./?a=ranking&char=11" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 11) echo 'style1';?>">D.Yến</a> -
<a href="./?a=ranking&char=12" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 12) echo 'style1';?>">Tử Hào</a> -
<a href="./?a=ranking&char=13" class="<?php if(isset($_GET["char"]) && $_GET["char"] == 13) echo 'style1';?>">Thần Nữ</a> - -->
	<hr style="margin: 5px 0;">
	<table class="tbl">
		<thead>
			<tr>
				<th width="5%">T.tự</th>
				<th width="20%">Tên nhân vật</th>
				<th width="15%">Phái</th>
				<th width="5%">Cấp</th>
				<th width="15%">Thế lực</th>
				<th width="5%">T.chức</th>
				<th width="10%">Võ huân</th>
				<th width="5%">T.sinh</th>
			</tr>
		</thead>
<?php
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	$char=0;
	if(isset($_GET["char"]))
	{
		
		$validate = new GUMP();
		$_GET = $validate->sanitize($_GET);
		$validate->validation_rules(array(
			'char'    => 'required|numeric|max_len,2',
		));
		$validate->filter_rules(array(
			'char' => 'trim|whole_number',
		));
		$validated_data = $validate->run($_GET);
		if($validated_data === false) {
			echo "<font color=red size=69><b>?</b></font>";
			die;
			//$error = (object)$validate->get_errors_array();
		} 
		else {
			$char=$validated_data["char"];
		}
	}
	else{
		$char=0;
	}
	$count_command = "SELECT COUNT(FLD_ID) AS NumberOfProducts FROM rxjhgame.dbo.TBL_XWWL_Char";
	$line=23;
	$sql_command = "SELECT FLD_ID,FLD_NAME,FLD_ZX,FLD_JOB,FLD_LEVEL,FLD_EXP,FLD_JOB_LEVEL,FLD_WX,FLD_ZS from rxjhgame.dbo.TBL_XWWL_Char order by FLD_ZS desc, FLD_LEVEL desc, FLD_EXP desc";
	
	if($char > 0 && $char <= 11)
	{
		$sql_command = "SELECT FLD_ID,FLD_NAME,FLD_ZX,FLD_JOB,FLD_LEVEL,FLD_EXP,FLD_JOB_LEVEL,FLD_WX,FLD_ZS from rxjhgame.dbo.TBL_XWWL_Char where FLD_JOB=".$char." order by FLD_ZS desc, FLD_LEVEL desc, FLD_EXP desc";
	}
	
	$item = odbc_exec($dbhandle, $sql_command);
	$numberofitem = odbc_num_rows($item);

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
		// echo "<font color=red size=69><b>?</b></font>";
		// die;
	}



$i=-1;
while($row = odbc_fetch_array($item))
{
	$i++;
	if($i>=$line*$page && $i<$line*($page+1))
	{
		$taikhoan = $row['FLD_ID'];
	$item2 = odbc_exec($dbhandle, "select FLD_ZT,FLD_ONLINE from rxjhaccount.dbo.TBL_ACCOUNT where FLD_ID='".$taikhoan."'");
	$row2 = odbc_fetch_array($item2);

	
	$item1 = odbc_exec($dbhandle, "select G_Name from rxjhgame.dbo.TBL_XWWL_GuildMember where FLD_NAME='".$row['FLD_NAME']."'");
	$row1 = odbc_fetch_array($item1);


	$rank = $i+1;


	if($row2['FLD_ZT'] == 1)
	{
		$row['FLD_NAME']  = "<s> ".$row['FLD_NAME']." </s>";
		$checkband  = "<img src='./images/band.png'>";
	}
	else
	{
		if($row2['FLD_ONLINE'] == 1)
		{
			$checkband  = "<img src='./images/online.png'>";
		}
		else
		{
			$checkband  = "<img src='./images/offline.png'>";
		}
	}

	if($row['FLD_JOB'] == 1){ $row['FLD_JOB'] = "<FONT COLOR='Red'>Đao Khách</font>";
	}
	if($row['FLD_JOB'] == 2){ $row['FLD_JOB'] = "<FONT COLOR='Blue'>Kiếm Khách</font>";
	}
	if($row['FLD_JOB'] == 3){ $row['FLD_JOB'] = "<FONT COLOR='Fuchsia'>Thương Hào</font>";
	}
	if($row['FLD_JOB'] == 4){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Cung Thủ</font>";
	}
	if($row['FLD_JOB'] == 5){ $row['FLD_JOB'] = "<FONT COLOR='Gray'>Đại Phu</font>";
	}
	if($row['FLD_JOB'] == 6){ $row['FLD_JOB'] = "<FONT COLOR='DimGray'>Thích Khách</font>";
	}
	if($row['FLD_JOB'] == 7){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Cầm Sư</font>";
	}
	if($row['FLD_JOB'] == 8){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Hàn Bảo Quân</font>";
	}
	if($row['FLD_JOB'] == 9){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Đàm Hoa Liên</font>";
	}
	if($row['FLD_JOB'] == 10){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Quyền Sư</font>";
	}
	if($row['FLD_JOB'] == 11){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Diệu Yến</font>";
	}
	if($row['FLD_JOB'] == 12){ $row['FLD_JOB'] = "<FONT COLOR='Black'>Tử Hào</font>";
	}
	if($row['FLD_JOB'] == 13){ $row['FLD_JOB'] = "<FONT COLOR='Blue'>Thần Nữ</font>";
	}
	if($row['FLD_LEVEL'] == 0){ $row['FLD_LEVEL'] = "<FONT COLOR='red'>L&#7895;i</font>";
	}

	if($row['FLD_ZX'] == 0){ $row['FLD_ZX'] = "<FONT COLOR='Green'>Chưa gia nhập</font>";
	}
	if($row['FLD_ZX'] == 1){ $row['FLD_ZX'] = "<FONT COLOR=blue>Chính phái</font>";
	}
	if($row['FLD_ZX'] == 2){ $row['FLD_ZX'] = "<FONT COLOR=red>Tà phái";
	}




	$vang=$row['FLD_WX'];
	//$guild=$row1['G_Name'];
	//$gx = substr($guild, -1);
	//if(!(($gx >= 'a' && $gx <= 'z')||($gx >= 'A' && $gx <= 'Z')||($gx >= '0' && $gx <= '9')))
	//{
		//$guild = substr($guild, 0, -2);
	//}
	
	$tienvang=number_format($row['FLD_ZS'],0);
	$vohuan=number_format($row['FLD_WX'],0);

	
	
	
	if($taikhoan == "hoanglong15" || $taikhoan == "littl3ird" || $taikhoan == "0" || $taikhoan == "krhuy1996" || $taikhoan == "krhuy96" || $taikhoan == "1" || $taikhoan == "2" || $taikhoan == "3" || $taikhoan == "a" || $taikhoan == "b" || $taikhoan == "c")
	{
		$row['FLD_NAME'] = "<b><font color=\"green\">[<font color=\"red\">GM</font>]</font> ".$row['FLD_NAME']."</b>";
		$i--;
		continue;
	}
	
	
	
	
	
	
	
	echo "<tr style=\"background-color:#".($i%2==0?"FBF8EF":"E0E6F8").";\" height=\"25px\">
	<td><center><FONT COLOR='Black'><b>".$rank."</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['FLD_NAME']."&nbsp;</td>
	<td><center>&nbsp;".$row['FLD_JOB']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['FLD_LEVEL']."&nbsp;</td>
	<td><center>&nbsp;".$row['FLD_ZX']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$row['FLD_JOB_LEVEL']."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$vohuan."&nbsp;</td>
	<td><center><FONT COLOR='Black'>&nbsp;".$tienvang."&nbsp;</td>
	</tr>";
	}
}
	
	
	
?>
  </table>
<?php
	$sotrang = round(($numberofitem / $line) - 0.51);
 	if($sotrang > 0) { ?>
  	<hr class="mt20">
	<form action="" method="post" id="form1">
		<div class="flex pagination">
			<?php
			$truoc = $page - 1;
			$sau = $page + 1;

			echo "<p>Trang ".($page + 1)." / $sotrang</p>";
			echo "<div class='flex gap10'>";

			for ($i = 1; $i <= $sotrang; $i++) {
				if ($i == $page + 1)
					echo "<strong class='current'>" . $i . "</strong>";
				else
					echo "<a href='?a=ranking&page=" . ($i  - 1). "&type=" . $type . "'>" . $i . "</a> ";
			}
			?>
			<input type="number" name="trang" min="1" max="<?php echo $sotrang; ?>" value="<?php echo $page +1; ?>" class='ml10'">
			<input type="submit" value="Đến"></input>
			</div>
		</div>
	</form>
<?php } ?>
</div>