<?php
	// require "./include/define.php";
	// require "./include/conn.php";
	// require "./include/gump.class.php";
	// require "./include/gameconn.php";
	if(isset($_GET['a'])){
		$validate = new GUMP();
		$_GET = $validate->sanitize($_GET);
		$validate->validation_rules(array(
			'a'    => 'required|alpha_dash|max_len,20',
		));
		$validate->filter_rules(array(
			'a' => 'trim|sanitize_string',
		));
		$validated_data = $validate->run($_GET);
		if($validated_data === false) {
			$error = (object)$validate->get_errors_array();
		} else {
			$func = $validated_data['a'];
			if($func == 'login'){
				include "login.php";
			}
			else if($func == 'logout'){
				include "logout.php";
			}
			else if($func == 'info'){
				include "playerinfo.php";
			}
			else if($func == 'reg'){
				include "register.php";
			}
			else if($func == 'lostpass'){
				include "lostpass.php";
			}
			else if($func == 'download'){
				include "download.php";
			}
			else if($func == 'ranking'){
				include "ranking.php";
			}
			else if($func == 'tlc'){
				include "ranking_tlc.php";
			}
			else if($func == 'taiphu'){
				include "ranking_taiphu.php";
			}
			else if($func == 'webshop'){
				include "webshop.php";
			}
			else if($func == 'changepass'){
				include "changepass.php";
			}
			else if($func == 'changeinfo'){
				include "changeinfo.php";
			}
			else if($func == 'reborn'){
				include "reborn.php";
			}
			else if($func == 'movemap'){
				include "movemap.php";
			}
			else if($func == 'logpk'){
				include "logpk.php";
			}
			else if($func == 'donate'){
				include "donate.php";
			}
			else if($func == 'forum'){
				include "forum.php";
			}
			else if($func == 'fanpage'){
				include "fanpage.php";
			}
			else if($func == 'dapdovip'){
				include "dapdovip.php";
			}
			else if($func == 'reward'){
				include "reward.php";
			}
			else{
				if(isset($_SESSION["auth"]['name'])){
					include "playerinfo.php";	
				}
				else{
					include "login.php";	
				}
			}
		}
	}
	else{
		include "home.php";
	}
?>