<?php
	// session_start();
	// require "/include/define.php";
	// require "/include/conn.php";
	// require "/include/gump.class.php";
	if(isset($_SESSION["auth"]['ID'])){
				$_SESSION["auth"]['ID'] = "" ;
				$_SESSION["auth"]['name'] = "";
				$_SESSION["auth"]['FLD_RXPIONT'] = "";
				$_SESSION["auth"]['FLD_ONLINE'] = "";
				$_SESSION["auth"]['FLD_CARD'] = "" ;
				$_SESSION["auth"]['FLD_NAME'] = "" ;
				$_SESSION["auth"]['FLD_Mail'] = "" ;
				$_SESSION["auth"]['FLD_QU'] = "" ;
				$_SESSION["auth"]['FLD_ANSWER'] = "" ;
	}
	session_destroy();
	
?>
<script>window.location.href = "/";</script>
