<?php
session_start();
require "./include/define.php";
require "./include/conn.php";
require "./include/gump.class.php";
require "./include/gameconn.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<?php include_once "./assets/include/head.php"; ?>
	<?php include_once "./assets/include/commoncss.php"; ?>
</head>
<body>
	<div class="l-container">
		<?php include_once "./assets/include/header.php"; ?>
		<div class="p-content">
			<?php include "load.php"; ?>
		</div>
		<?php include_once "./assets/include/footer.php"; ?>
	</div>
</body>
<?php include_once "./assets/include/commonjs.php"; ?>
</html>