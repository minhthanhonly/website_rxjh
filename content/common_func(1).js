
// ���̾� �˾�
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/mhtml.js?v1.3"></script>');
// �ҷ� �ܾ�
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/bad_word.js"></script>');
// getCookie �Լ�
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/cookie_hash.js"></script>');
// �������� �Լ�
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/func_library.js"></script>');

var mgamePopupObject;	// �˾� ������Ʈ��
var thisUri				=	location.href.replace("http://"+ location.host,"").split("/");
var thisHost			=	location.host.split(".");
var thisDomain			=	thisHost[1];
var isFrameTop = false;	//ä�θ��� ����Ȩ�������� ä�θ�����Ʈ �����ӳ��� ���°��.

// mgame.com�� www.mgame.com���� �̵�
if(location.host == "mgame.com"){
	location.href	=	"http://www.mgame.com/";
}

// ������ ����

if(location.host.indexOf("daum.net") > 0){
	document.domain		=	"daum.net";
} else if(location.host.indexOf("hangame.com") > 0){
	document.domain		=	"hangame.com";
} else if(location.host.indexOf("nopp.co.kr") > 0){
	document.domain		=	"nopp.co.kr";
} else if(location.host.indexOf("netmarble.net") > 0){
	document.domain		=	"netmarble.net";
} else if(location.host.indexOf("ongate.com") > 0){
	document.domain		=	"ongate.com";
} else if(location.host.indexOf("tooniland.com") > 0){
	document.domain		=	"tooniland.com";
} else if(location.host.indexOf("cartoonnetworkkorea.com") > 0){
	document.domain		=	"cartoonnetworkkorea.com";
} else if(location.host.indexOf("club5678.com") > 0){
	document.domain		=	"club5678.com";
} else if(location.host.indexOf("m-reaper.com") > 0){
	document.domain		=	'm-reaper.com';
}else if(location.host.indexOf("gamemania.co.kr") > 0){
	document.domain		=	"gamemania.co.kr";
	thisDomain = 'gamemania';
} else if(location.host.indexOf("picaon.com") > 0){
	document.domain		=	"picaon.com";
} else if(location.host.indexOf("mgame.com") > 0){
	document.domain		=	"mgame.com";
}else{
	document.domain		=	location.host.substr(location.host.indexOf(".")+1);
}

// RPG�������� iframe�� ���
/*
if(thisHost[0].substr(0,2) != "mg" && thisUri[1] == "common_rpgcontents" && window == top) {
	location.href		=	"http://"+ location.host;
}
*/

//###################################################################
// �α��� �� üũ - ä�θ� ����
// ��) <form method="post" onsubmit="return mgameLoginCheck(this)">
//###################################################################
function mgameLoginCheck(f) {
	if(mgameUserCheck(true)) return;

	f.target	=	"_top";

	if(thisDomain == "buddybuddy") {

		if (!f.ID.value.trim()) {
			error("���̵� �Է��ϼ���.");
			return false;
		}

		if (!f.PWD.value.trim()) {
			error("��й�ȣ�� �Է��ϼ���.");
			return false;
		}

		f.action		=	"https://user.buddybuddy.co.kr/Login/Login.asp";
	} else if(thisDomain == "nopp") {

		if (!f.userid.value.trim()) {
			error("���̵� �Է��ϼ���.");
			return false;
		}

		if (!f.passwd.value.trim()) {
			error("��й�ȣ�� �Է��ϼ���.");
			return false;
		}

		f.action		=	"https://www.nopp.co.kr/member/mem_login.asp";
	} else if(thisDomain == "sbs") {
		if (!f.id.value.trim()) {
			error("���̵� �Է��ϼ���.");
			return false;
		}

		if (!f.passwd.value.trim()) {
			error("��й�ȣ�� �Է��ϼ���.");
			return false;
		}

		f.action		=	"https://sbscert.sbs.co.kr/login/Login/verifyed_login.jsp?loginType=1&national_nm=sbntOd0xfFCzQ&Login_ReturnURL="+ top.location.href;
	} else {
		if("YES" == getCookie_key("MGAME_KEY_DEFENDER")) {
			mkdplus_copy_to_form(document.f);
		}

		if(!f.mgid_enc.value.trim()) {
			error("���̵� �Է��ϼ���.");
			return false;
		}

		if(!f.mgpwd_enc.value.trim()) {
			error("��й�ȣ�� �Է��ϼ���.");
			return false;
		}

		f.action		=	"https://sign.mgame.com/login/login_action_pub_type_b.mgame?tu="+ top.location.href +"&ru="+ top.location.href;
	}

	return true;
}


//###################################################################
// �α��� ���� üũ - ü����̵� �˾� ����/ ä�θ� ����
// option�� true�� ��� �޽��� ����� ����
// ��) if(!mgameUserCheck()) return;
// +++++++++++++++++++++++++++
// returnURL �Ķ���� �߰� 2009-09-10 daffodil
// �������� �α��� Layer�� ����ְ�, ä�θ��� �α����������� ��ȯ �ϰ� ������
// �Ʒ����÷� �Ķ���͸� �Ѱ��ش�
// ��) if(!mgameUserCheck('loginpage','���Ϲް����URL')) return;
// ++++++++++++++++++++++++++++
//###################################################################

function simpleUserCheck(){
	//������ ä�θ� ���� üũ
	if(getCookie("MGAME") || getCookie("mgx")){
		return true;
	}else if(getCookie("PN_PUB") && (location.host.indexOf("playnetwork.co.kr") > -1)){
		return true;
	}
}

function mgameUserCheck(opt,returnURL) {
	//���ӻ���Ʈ�� iframe �ȿ��� ����Ǵ� ��� ��� ������	- ������

	if(isFrameTop){
		try{
			var gameHost = parent.location.host;
		}catch(e){
			var gameHost = location.host;
		}
	}else{
		var gameHost = top.location.host;
		var gameName = gameHost.substr(0,gameHost.indexOf("."));
	}

	var currentDomain = gameHost.substr(gameHost.indexOf(".")+1);
	var rurl = "http://"+gameHost;
	if(!returnURL) returnURL = rurl;

	//������
	if(currentDomain == "mgame.com") {
		// �α��� ����
		if(!getCookie("MGAME")){

			if(opt =="loginpage"){

				// 2013-04-17 �Ҵ뿬 ����
				returnURL = encodeURIComponent(returnURL);
				Mgame_CommonLayerOpen_trans('http://www.mgame.com/ulnauth/login_form_pop.mgame?tu='+returnURL, 427, 394, true);
			}
			else if(!opt){
				error();
			}
			return false;
		}
		// ȸ��Ÿ�� ����
		//if(getCookie_2DIM("MGAME","TYPE") != 1000 && getCookie_2DIM("MGAME","TYPE") != 9999 && getCookie_2DIM("MGAME","TYPE") != 7777) {
		if(getCookie_2DIM("MGAME","TYPE") != 1000 && getCookie_2DIM("MGAME","TYPE") != 9999) {
			if(top.location.host == "aw.mgame.com"){
				return true;
			}

			if(!opt) GUEST_POPUP();
			return false;
		}

	//���� (game.daum.net)
	}else if(currentDomain == "game.daum.net" || currentDomain == "mgame.game.daum.net" || currentDomain == "daum.net" || currentDomain == "kids.daum.net" || currentDomain == "mgame.kids.daum.net"){

		if(getCookie("HM_CU")){
			if(!getCookie("mgx")){

				switch(gameName){
					case "wffm":		svcId = "339";	break;
					case "yulgang":		svcId = "330";	break;
					case "js":			svcId = "402";	break;
					case "hero":		svcId = "2343";	break;
					case "argo":		svcId = "3016";	break;
					case "valiant":		svcId = "3647";	break;
					case "hon":			svcId = "6922";	break;
				}

				if(gameName == "argo"){
					error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");
					return false;
				}else if(gameName == "valiant"){
					error("�߸���Ʈ �̿����� ���� �� �ֽñ� �ٶ��ϴ�.");
					return false;
				}else error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");

				if(currentDomain == "kids.daum.net") {
					top.location.href="https://user.daum.net/privagree/privinfoagree.daum?svcId="+svcId+"&codeName="+gameName+"&returnUrl=http://sign.mgame.kids.daum.net/mgame_agree.mgame?codeName="+gameName;
				} else {
					top.location.href="https://user.daum.net/privagree/privinfoagree.daum?svcId="+svcId+"&codeName="+gameName+"&returnUrl=http://sign.mgame.game.daum.net/mgame_agree.mgame?codeName="+gameName;
				}

				return false;
			}
		}else{	//�α���
			if(opt == "loginpage"){
				top.location.href = 'http://login.daum.net/accounts/loginform.do?url='+returnURL
			}else if(!opt){
				error();	return;
			}

			if(gameName == "hon"){
				return channelGoLogin(opt,'http://login.daum.net/accounts/loginform.do?url='+returnURL);
			}
		}
	//�Ѱ��� (hangame.com)
	}else if(currentDomain == "hangame.com" || currentDomain == "mgame.hangame.com"){
		if(getCookie_nhn("HG_CP_LOGIN")){
			if(!getCookie_nhn("mgx")){

				error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");

				top.location.href="https://members.hangame.com/myinfo/thirdparty.nhn?gameid=K_HON&period=30&next=http://sign.mgame.hangame.com/agreement_nhn.mgame?codeName=hon&homeurl=http://www.hangame.com";
				return false;
			}
		}else{

			// �Ѱ��� alpha- �׼����� ���ٽ� �α��� ó�� ( 100513 Ȳ��� �߰�)
			var alphaval = "";
			if(top.location.host.substr(0,top.location.host.indexOf("-"))=="alpha") {
				alphaval = "alpha-";
			}
			return channelGoLogin(opt,'http://'+alphaval+'id.hangame.com/wlogin.nhn?popup=false&adult=false&nxtURL='+returnURL);
		}

	//���Ϸ��� (tooniland.com)
	} else if(currentDomain == "tooniland.com"){
		if(getCookie('xUserId')){
			if(!getCookie('mgx')){
				error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");
				top.location.href='http://mgsign.tooniland.com/agreement_tooniland.mgame';
				return false;
			}
		} else {
			return false;
		}
	//ī����Ʈ��ũ (cartoonnetwork.com)
	} else if(currentDomain == "cartoonnetworkkorea.com"){
		if(getCookie('c_usr')){
			if(!getCookie('mgx')){
				error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");
				top.location.href='http://sign.mgame.cartoonnetworkkorea.com/agreement_cartoon.mgame';
				return false;
			}
		} else {
			return channelGoLogin(opt,'http://www.cartoonnetworkkorea.com/member/login_form.html?url='+returnURL);
		}
	// Ŭ��5678
	} else if(currentDomain == "club5678.com"){
		if(getCookie('gCCV')){
			if(!getCookie('mgx')){
				error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");
				top.location.href='http://sign.mgame.club5678.com/mgame_agree.mgame';
				return false;
			}
		} else {
			return channelGoLogin(opt,'http://www.cartoonnetworkkorea.com/member/login_form.html?url='+returnURL);
		}
	//�°���Ʈ
	}else if(currentDomain == "ongate.com"){
		if(getCookie('IBPROF')){
			if(!getCookie('mgx')){
				error("�̿�߰� ���� �� �̿��� �� �ֽ��ϴ�.");
				return false;
			}
		} else {
			return channelGoLogin('','');
		}
	}else if(currentDomain == "m-reaper.com"){
		if(getCookie('bpchkno')){
			if(!getCookie('mgx')){
				error("�̿����� ���� �� �ֽñ� �ٶ��ϴ�.");
				return false;
			}
		} else {
			return channelGoLogin('','');
		}
	}

	return true;
}

function channelGoLogin(opt,goUrl){
	if(opt == "loginpage"){
		top.location.href = goUrl;
	}else if(!opt){
		error();
	}
	return false;
}

//###################################################################
// �α׾ƿ� - ä�θ� ����
// ��) <a href="javascript:mgameLogout()">�α׾ƿ�</a>
//###################################################################
function mgameLogout() {
	if(thisDomain == "buddybuddy") {
		setCookie("MGCPAGREE",null,-1);
		top.location.href	=	"http://user.buddybuddy.co.kr/Login/LogOut.asp?URL=http://"+ top.location.host;
	}
	else if(thisDomain == "game.daum") {
		setCookie("MGCPAGREE",null,-1);
		top.location.href	=	"http://go.daum.net/bin/minidaum.cgi?category=game&logout_url=http://"+ top.location.host;
	}
	else if(thisDomain == "nopp") {
		setCookie("MGCPAGREE",null,-1);
		top.location.href	=	"https://www.nopp.co.kr/Member/mem_logout.asp";
	}
	else if(thisDomain == "netmarble") {
		setCookie("MGCPAGREE",null,-1);
		setCookie("mgx",null,-1);
		top.location.href	=	"http://sso.netmarble.net/Logon/Logoff.aspx?r_url=http://"+ top.location.host;
	}
	else if(thisDomain == "sbs") {
		top.go_logout();
	} else {
		top.logoutforirc();
	}
}


//###################################################################
// ���̵�/�н����� ã�� - ä�θ� ����
// ��) <a href="javascript:mgameFindAccount()">���̵�/�н����� ã��</a>
//###################################################################
function mgameFindAccount() {
	if(thisDomain == "buddybuddy") {
		mgamePopup("http://user.buddybuddy.co.kr/idsearch/IdPwSearchGameForm.asp?from=game&CSSURL=http://game.buddybuddy.co.kr/Common/Css/game_member.css",500,500);
	} else if(thisDomain == "sbs") {
		top.location.href	=	"https://sbscert.sbs.co.kr/login/passwd/findpwd_form.jsp";
	} else if(thisDomain == "nopp") {
		top.location.href	=	"http://www.nopp.co.kr/member/search_pw_frm.asp";
	} else {
		mgameLayerPopup("http://sign.mgame.com/t_user_search/",(isIE() ? 400 : 500),350);
	}
}


//###################################################################
// ȸ������ - ä�θ� ����
// ��) <a href="javascript:mgameNewAccount()">ȸ������</a>
//###################################################################
function mgameNewAccount() {
	var hostname ="";
	if(thisDomain == "buddybuddy") {
		if(thisHost[0]=="js"){
			hostname = "justishow";
		}else{
			hostname = thisHost[0];
		}
		pageUrl		=	"http://game.buddybuddy.co.kr/Member/Join.aspx?GAMEPATH="+hostname;
	} else if(thisDomain == "sbs") {
		pageUrl		=	"https://sbscert.sbs.co.kr/login/member/join/agree.jsp";
	} else if(thisDomain == "nopp") {
		pageUrl		=	"http://www.nopp.co.kr/member/mem_registselect_frm.asp?returl=http://"+ location.host;
	} else {
		pageUrl		=	"http://sign.mgame.com/_t_regist/regist_F_0000_PRE.mgx?toGOgame=http://"+ location.host;
	}

	window.open(pageUrl);
}


//###################################################################
// ����
// ��) <a href="javascript:mgameCashCharge()">����</a>
//###################################################################
function mgameCashCharge() {
	pageUrl		=	"https://mbill.mgame.com/mbank_2014/?gcode=MCASH";
	window.open(pageUrl, 'winMCashCharge', 'width=600,height=560,left=10,top=10');
}


//###################################################################
// ���� ����
// �α��� ���� üũ �� ���� ����
// ��) <a href="javascript:mgameStart('popstage')">���ӽ���</a>
//###################################################################
function mgameStart(game) {

	if(!mgameUserCheck()) return;

	try {
		launch_game(game);
	} catch(e) {
		error("���� ���࿡ �ʿ��� �Լ��� �����ϴ�.");
	}
}


//###################################################################
//�̹��� ��������
//size�� ���� width���� Ŭ ��� size������ ������¡
//��) <img src="a.jpg" alt="a" onload="imageResize(this,500)" />
//###################################################################
function imageResize(obj,size) {
	if(!size) {
		obj.width		=	"100%";
	} else {
		if(w=eval(obj.width) > size) obj.width = size;
	}
}


//###################################################################
// ����Ʈ �� ����
// input, textarea�� limit�� ��ŭ�� �Է°���
// div���� ���� ��� �ش� id���� ���� ����Ʈ ���
// ��) <textarea onkeyup="messageLimit(this,100)"></textarea>
// ��)<input type="text" onkeyup="messageLimit(this,50,'byte2')">(<span id="byte2">0/50byte</span>)
//###################################################################
function messageLimit(obj,limit,div) {
	var nByte			=	0;

	for(var i=0;i<obj.value.length;i++) {
		nByte			+=	(obj.value.charCodeAt(i)>128) ? 2 : 1;

		if(nByte >= limit) break;
	}

	if(nByte >= limit) {
		error(limit +" Bytes ������ �Է��� �����մϴ�.");
		obj.value			=	obj.value.substr(0,i);
	}

	if(document.getElementById("divMessageLimit")) {
		document.getElementById("divMessageLimit").innerText	=	nByte +"/"+ limit +" Bytes";
	} else if(div) {
		document.getElementById(div).innerText	=	nByte +"/"+ limit +" Bytes";
	}
}


//###################################################################
// ��������
// ��2.0�� ���� if_Resize2() ���׷��̵� ����
// iframe ����� �����ϴ� ����̶� �ܺ��� margin�̳� padding������ ��Ȯ�� ������¡~
// ��) <iframe name="content" width="100%" onload="iframeResize(this)"></iframe>
//###################################################################

function iframeResize(ifrm) {
	//alert("common_func.js�� resize function");
	//alert("����Ʈ�� �������� �׽�Ʈ ����Ʈ �¿��� ������� �ǽô� ���� ������ �ּ���~");
	if(ifrm) {
		try {
			//ifrm.style.height	=	eval(ifrm.name).document.body.scrollHeight;
			//alert( eval(ifrm.name).document.body.scrollHeight);

			//ifrm.setAttribute("height", eval(ifrm.name).document.body.scrollHeight);
			ifrm.style.height = eval(ifrm.name).document.body.scrollHeight + "px";
		} catch(ex) {
		}
		document.body.scrollTop	=	0;

	} else {
		var obj		=	parent.document.getElementsByTagName("iframe");

		for(var i=0;i<obj.length;i++) {

			if(obj[i].name == window.name) {
				try {
					//obj[i].style.height	=	document.body.scrollHeight;
					obj[i].setAttribute("height", document.body.scrollHeight);
				} catch(ex) {
				}
			}

		}
	}
}



function iframeResize_v2(ifrm) {

	//alert("common_func.js�� resize function");
	//alert("����Ʈ�� �������� �׽�Ʈ ����Ʈ �¿��� ������� �ǽô� ���� ������ �ּ���~");
	if(ifrm) {
		try {
			//ifrm.style.height	=	eval(ifrm.name).document.body.scrollHeight;
			var chk = eval(ifrm.name).document.body.scrollHeight + 10;
			ifrm.setAttribute("height", chk);
		} catch(ex) {
		}
		document.body.scrollTop	=	0;

	} else {
		var obj		=	parent.document.getElementsByTagName("iframe");

		for(var i=0;i<obj.length;i++) {

			if(obj[i].name == window.name) {
				try {
					//obj[i].style.height	=	document.body.scrollHeight;
					obj[i].setAttribute("height", document.body.scrollHeight);
				} catch(ex) {
				}
			}

		}
	}
}



/*
function iframeResize(ifrm) {
	if(ifrm) {
		var obj		=	ifrm.contentWindow;

		ifrm.height	=	isXHTML(obj) ? obj.document.documentElement.scrollHeight : obj.document.body.scrollHeight;

		if(isXHTML()) {
			document.documentElement.scrollTop	=	0;
		} else {
			document.body.scrollTop	=	0;
		}
	} else {
		var obj	=	parent.document.getElementsByTagName('iframe')[window.name];

		obj.style.height	=	isXHTML() ? document.documentElement.scrollHeight +'px' : document.body.scrollHeight;
	}
}

function isXHTML(obj) {
	var xhtml;

	if(navigator.appName == 'Microsoft Internet Explorer') {
		xhtml		=	(obj ? obj.document.documentElement.clientHeight : document.documentElement.clientHeight) ? 1 : 0;
	} else {
		try {
			xhtml	=	((obj ? obj.document.doctype.publicId.indexOf('XHTML') : document.doctype.publicId.indexOf('XHTML')) == -1) ? 0 : 1;
		} catch(ex) {
			xhtml	=	0;
		}
	}

	return xhtml;
}
*/
function iframeResize2(ifrm) {
	if(ifrm) {
		try {
			ifrm.style.height	=	ifrm.contentWindow.document.documentElement.scrollHeight +'px';
		} catch(ex) {
		}
			document.documentElement.scrollTop	=	0;
	} else {
		var obj		=	document.getElementsByTagName("iframe");
		for(var i=0;i<obj.length;i++) {
			if(obj[i].name == window.name) {
				try {
					obj[i].style.height	=	document.documentElement.scrollHeight +'px';
				} catch(ex) {
				}
			}
		}
	}
}




//###################################################################
// ��������
// ���̺� �ڵ��� ��� iframe resize �ϴµ�, iframe�� height�� parameter �� ���� add�� ���� ���Ѵ�
/*
//sample
<table width="610" border="0" cellspacing="0" cellpadding="0" style="text-align:left; ">
	<tr>
		<td id="resize_td">
			<iframe scrolling="no" name="Content" id="Content" width="100%" height="100%" src="" marginheight="0" marginwidth="0" frameborder="0" align="center" onload="iframe_resize_table_add50()" allowTransparency="true"></iframe>
		</td>
	</tr>
</table>
*/
// ��) <iframe name="content" width="100%" onload="iframeResize(this)"></iframe>
//###################################################################

function iframe_resize_table_add(add_val) {
	//alert(Content.document.body.scrollHeight);
	if(!add_val) add_val= 50;

	//resize_td.height = Content.document.body.scrollHeight + add_val;
	resize_td.height = Content.document.body.scrollHeight ;
	resize_td.width = Content.document.body.scrollWidth;
	//alert(resize_td.height);

}


//###################################################################
// ���ڸ� �ޱ� - input, textarea�� ���ڸ� ����
// ��) <input type="text" onkeyup="numberCheck(this)" />
//###################################################################
function numberCheck(obj) {
	obj.value			=	obj.value.replace(/[^0-9]/gi,"");
}


//###################################################################
// �ͽ��÷η� 7 �˻� - �ͽ��÷η� 7�̸� true��ȯ
// ��) if(!isIE7()) return;
//###################################################################
function isIE7() {
	var flag				=	false;
	var arrVerStr		=	window.navigator.appVersion.split("; ");

	if(arrVerStr.length >= 4) {
		var arrIEVer	=	arrVerStr[1].split(" ");

		if(arrIEVer[1] >= 7.0) {
			flag			=	true;
		}
	}

	return flag;
}


//###################################################################
// ���� ����
// ��) if(!document.form1.subject.value.trim()) return;
//###################################################################
String.prototype.trim = function() {
    return this.replace(/(^[ \f\n\r\t]*)|([ \f\n\r\t]*$)/g, "");
}


//###################################################################
// õ���� �ĸ�����
// ��) document.form1.no.value = document.form1.no.value.numberFormat();
//###################################################################
// 1000���� ����
String.prototype.numberFormat	=	function() {
    return this.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
}


//###################################################################
// ���ڼ� ����
// ��) document.write(document.form1.subject.cut(15));
//###################################################################
String.prototype.cut = function(len) {
	var str	=	this;
	var l	=	0;

	for(var i=0;i<str.length;i++) {
		l += (str.charCodeAt(i) > 128) ? 2 : 1;

		if(l > len) return str.substring(0,i) + "..";
	}

	return str;
}


//###################################################################
// ���� ��Ŭ��� - ��ũ��Ʈ ���� ��Ŭ���
// PHP include �Լ��� ����
// ��) include("http://www.mgame.com/common_js/mhtml.js");
//###################################################################
function include( filename ) {
	var js	=	document.createElement('script');
	js.setAttribute('type', 'text/javascript');
	js.setAttribute('src', filename);
	js.setAttribute('defer', 'defer');
	document.getElementsByTagName('head')[0].appendChild(js);
}


//###################################################################
// ����ó�� - ���̾� �˾� ��� /  ä�θ� ����
// object, iframeüũ �� �ڵ����� ���̾� �Ǵ� ���â���� ���
// confirm�� true�� ��� confirm�� ���â ���
// modal�� true�� ��� ������ ���â ���
//��) error("�����񽺰�����");
//###################################################################
function error(msg,opt,modal) {

	if(!msg) {
		msg	=	"�α��� �� �̿��Ͽ� �ּ���.";
	}

	if(thisDomain == "mgame") {
		if(opt) {
			return Mgame_ConfirmPopupOpen(msg);
		} else {
			var obj		=	document.getElementsByTagName("iframe");
			var flag		=	modal ? 1 : 0;
			for(var i=0;i<obj.length;i++) {
				// ���ĸ� ������ ������
				if(obj[i].name != "launch") {
					try {
						// object ����
						//alert(eval(obj[i].name).document.getElementsByTagName("object").length);
						if(eval(obj[i].name).document.getElementsByTagName("object").length) flag++;
					} catch(ex) {
						flag++;
					}
					// �ͽ��÷η� 6�� select �±� ����
					if(isIE() && !isIE7()) {
						try {
							if(eval(obj[i].name).document.getElementsByTagName("select").length) flag++;
						} catch(ex) {
							flag++;
						}
					}
				}
			}

			if(document.getElementById("mgamePlayer")) flag++;	//	���� ���� �÷��̾� ���̵�
			if(document.getElementById("flvplayer")) flag++;			//	UCC �÷��̾� ���̵�

			// ����ó��
			if(top.location.href.indexOf("guild.mgame.com/guild/game/wffm") != -1) flag = null;
			if(top.location.href.indexOf("flash.mgame.com") != -1) flag++;
			if(location.href.indexOf("wffm.mgame.com") != -1) flag++;


			if(modal) flag++;
			// flag ���� ������ ��� �˾�

			if(flag) {
				try {
					top.Mgame_ErrorPopupOpen("free",msg);

				} catch(e) {

					Mgame_ErrorPopupOpen("free",msg);
				}
			// flag ���� ������ ���̾� �˾�
			} else {
				try {
					top.Mgame_ErrorLayerOpen("free",msg);
				} catch(e) {
					Mgame_ErrorLayerOpen("free",msg);

				}
			}
		}
	// ������ �������� ��� �⺻��
	} else {
		if(opt) {
			return confirm(msg);
		} else {
			if(location.host.indexOf("playnetwork.co.kr") > 0 || location.host.indexOf("gamemania.co.kr") > 0){
				alert(msg);
			} else {
				Mgame_ErrorPopupOpen('free', msg);

			}

		}
	}

}


// ���ϸ��� ����
function thisFile(a) {
	var thisHref		=	location.href.split("/");
	var thisReFile		=	thisHref[thisHref.length-1].replace(/(\?(.)*)/gi,"");
	var thisLocate		=	thisReFile.split(".");
	var thisName		=	thisLocate[0].replace(/(_(.)*)/gi,"");

	return a ? thisName + "_" + a +"."+thisLocate[1] : thisName + "."+thisLocate[1];
}


// Ŭ������ ����
function copyLink(v) {
	try {
		var copyPath	=	copyUrl;
	} catch(e) {
		var copyPath	=	location.href +"?idx="+ v;
	}

	clipboardData.setData("Text",copyPath);
	error("Ŭ�����忡 �����Ͽ����ϴ�.");
}


// �˾� ���
function mgamePopup(param,w,h) {
	var popupWidth	=	w ? w : 50;
	var popupHeight	=	h ? h : 50;

	mgamePopupObject	=	window.open(param,"mgamePopup","width="+ popupWidth +",height="+ popupHeight +",top=0,left=0");
}

// �˾� ���(��ũ�� �ְ�)
function mgamePopup_scroll(param,w,h) {
	var popupWidth	=	w ? w : 50;
	var popupHeight	=	h ? h : 50;

	mgamePopupObject	=	window.open(param,"mgamePopup","width="+ popupWidth +",height="+ popupHeight +",top=0,left=0,scrollbars=1,resizable=yes");
}


// ���̾� �˾� ���
function mgameLayerPopup(param,w,h) {
	var popupWidth	=	w ? w : 50;
	var popupHeight	=	h ? h : 50;

	Mgame_CommonLayerOpen(param,popupWidth,popupHeight);
}

//###################################################################
// �Խ��� ����
//###################################################################
// ����ϱ�
function writeLink() {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;
	p.action			=	thisFile("write");
	p.submit();
}

// �亯�ϱ�
function replyLink() {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;

	p.action			=	thisFile("write");
	p.mode.value		=	"reply";
	p.submit();
}

// �б�
function viewLink(idx,a) {
	//parent.document.getElementByid('ifr_content').style.display ='none';
	var p	=	document.procForm;
	p.idx.value			=	idx;

	if(a) {
		p.action		=	a;
	} else {
		try {
			p.action	=	procAction;
		} catch(e) {
			p.action	=	thisFile("view");
		}
	}
	p.submit();
}
// �б�_target=_top
function viewLink_top(idx,a) {
	var p	=	document.procForm;
	p.idx.value			=	idx;

	if(a) {
		p.action		=	a;
	} else {
		try {
			p.action	=	procAction;
		} catch(e) {
			p.action	=	thisFile("view");
		}
	}
	p.target="_top";
	p.submit();
}

// ������ �����ϱ�
function pageLink(page) {
	var p	=	document.procForm;
	if(p.idx.value != ""){
		p.idx.value = "";
	}
	p.page.value		=	page;
	p.submit();
}

// ����Ʈ�� ���ư���
function listLink() {
	var p	=	document.procForm;

	p.action			=	thisFile();
	p.submit();
}

// ��尪 ó��
function modeLink(m) {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;

	p.mode.value		=	m;
	p.action			=	thisFile("proc");
	p.submit();
}

// �����ϱ�
function deleteLink() {
	if(!mgameUserCheck()) return;

	if(!error("�����Ͻðڽ��ϱ�?",true)) {
		return;
	}

	var p	=	document.procForm;

	p.mode.value		=	"delete";
	p.action			=	thisFile("proc");
	p.submit();
}

// �����ϱ�
function editLink() {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;

	p.mode.value		=	"edit";
	p.action			=	thisFile("write");
	p.submit();
}

// ��� ó������
function ajaxProc() {
	try {
		var cAction		=	ajaxAction;
	} catch(e) {
		var cAction		=	thisFile("comment");
	}

	return cAction;
}

// ��� �ۼ� �� ��������
function ajaxResize() {

	if(parent.document.getElementById("resize_td")) {
		if(parent.window.if_Resize2) parent.if_Resize2();
	}else {
		try
		{
			iframeResize();
			try{
				parent.iframeResize3(parent.document.all['Content']);
			}catch(eb){
			}
		}
		catch (e)
		{
		}
	}

}

// ��� ��� div��
function ajaxId() {
	try {
		var div			=	ajaxDiv;
	} catch(e) {
		var div			=	"divAjax";
	}

	return div;
}

// ��� ���� ����
function ajaxVariable() {
	try {
		var query		=	ajaxQuery;
	} catch(e) {
		var query		=	"";
	}

	return query;
}

// ��� ����¡
function ajaxPage(page) {
	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&page="+ (page ? page : 1));
	ajaxResize();
}

// ��� �Է�
function commentWrite() {

	if(location.host.indexOf("picaon.com") > 0) {
		if(!getCookie("PICAGAMECHANNELINFO")){
			alert('�α����� ��밡���մϴ�.');
			return;
		}else if(!getCookie("mgx")){
			alert('�̿��� ���� �� �̿����ּ���.');
			return;
		}
	}

	if(location.host.indexOf("ongate.com") > 0) {
		if(!getCookie("IBPROF")){
			alert("�α��� �� �̿����ּ���.");
			return;
		}else if(!getCookie("mgx")){
			alert("�̿��� ���� �� �̿����ּ���.");
			return;
		}
	}
	if(!mgameUserCheck()) return;

	// ������ ���������� commentAuth��.. ��ũ��Ʈ�� �Ұ���.
	try {
		commentAuth();
	} catch(e) {
	}


	var f	=	document.commentForm;

	if(!f.comment.value.trim()) {
		error("����� �Է��Ͽ� �ּ���.");
		return;
	}

	if(f.comment.value.substring(0,4) == "  * "){
		error("����� �Է��Ͽ� �ּ���.");
		f.comment.value = "";
		return;
	}

	// �ҷ��ܾ� ����
	f.comment.value	= ch_BadWord(f.comment.value);
	f.comment.value = f.comment.value.replace(/"/ig, "&quot;");			//    "  ��  ����
	f.comment.value = f.comment.value.replace(/'/ig, "&#39;");			//    '  ��  ����
	f.comment.value = f.comment.value.replace(/ /ig, "&nbsp;");			//�����̽� �� ����
	f.comment.value = f.comment.value.replace(/\r\n/ig, "<br>");		//���Ͱ�����

	var chr		= encodeURIComponent(f.comment.value);				//���ڵ����� Ư������ ���� ���� (�ѱ� ����) (���� : UTF-8 �� �޾ƾ��Ѵ�)
	var vKey	= (f.vaString) ? f.vaString.value : '';				// �Խ��� ��� ��Ͻ� ��ȿ�� üũ���� ��

	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&mode=write&vaString="+vKey+"&comment="+ encodeURIComponent(chr));
	f.reset();
	ajaxResize();
}

// ��� ����
function commentDelete(idx) {
	if(!mgameUserCheck()) return;
	if(!error("�����Ͻðڽ��ϱ�?",1)) return;

	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&mode=delete&idx="+ idx);
	ajaxResize();
}

// ��� ���
function commentReply(idx) {
	if(!mgameUserCheck()) return;

	var obj;
	obj		=	document.getElementById("divAjax").getElementsByTagName("div");
	for(var i=0;i<obj.length;i++) {

		if(obj[i].id.substr(0,7) == "divAjax" && obj[i].id.substr(8,obj[i].id.length) != idx) {
			obj[i].style.display	=	"none";
		}
	}

	obj		=	document.getElementById("divAjax_"+idx);

	if(obj.style.display == "block") {
		obj.style.display	=	"none";
	} else {
		obj.style.display	=	"block";
		eval("document.commentForm.comment_"+idx).focus();
	}

	ajaxResize();
}

// ��� ��� ���
function commentReplyWrite(idx,reIdx,reLevel,reStep) {

	if(!mgameUserCheck()) return;

	// ������ ���������� commentAuth��.. ��ũ��Ʈ�� �Ұ���.
	try {
		commentAuth();
	} catch(e) {
	}

	var f	=	eval("document.commentForm.comment_"+ idx);

	if(!f.value.trim()) {
		error("����� �Է��Ͽ� �ּ���.");
		return;
	}

	// �ҷ��ܾ� ����
	f.value	=	ch_BadWord(f.value);
	f.value = f.value.replace(/"/ig, "&quot;");			//    "  ��  ����
	f.value = f.value.replace(/'/ig, "&#39;");				//    '  ��  ����
	f.value = f.value.replace(/ /ig, "&nbsp;");			//�����̽� �� ����
	f.value = f.value.replace(/\r\n/ig, "<br>");			//���Ͱ�����

	var vKey	= (document.commentForm.vaString) ? document.commentForm.vaString.value : '';			// �Խ��� ��� ��Ͻ� ��ȿ�� üũ���� ��

	var chr = encodeURIComponent(f.value);							//���ڵ����� Ư������ ���� ���� (�ѱ� ����) (���� : UTF-8 �� �޾ƾ��Ѵ�)
	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&mode=reply&idx="+ reIdx +"&reLevel="+ reLevel +"&reStep="+ reStep +"&comment="+ encodeURIComponent(chr)+"&vaString="+vKey);
	document.commentForm.reset();
	ajaxResize();
}

// ��� �˻�
function commentSearch() {
	if(!document.searchForm) return;

	var f	=	document.searchForm;

	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&searchName="+ f.searchName.value +"&searchWord="+ f.searchWord.value);
	ajaxResize();
}

//###################################################################
//  ���� , �̺�Ʈ �� ������ �� URL ����
//###################################################################
function notice_commonLink(strUrl,linkType){
	//linkType : 1 (popup)
	//linkType : 0 (link)
	strUrl = "http://"+location.host+strUrl;

	if(linkType == "1")
		window.open(strUrl,"newcontents","width=800, height=600, location=yes, directories=yes, menubar=yes,scrollbars=yes,resizable=yes,status=yes,toolbar=yes");
	else
		location.href = strUrl;
}


//###################################################################
//  ��¥ ���� ������
//###################################################################

function getDateDiff(date, diffType){
	//date = '2009-10-29 12:30:35';

	var gapTime;
	var writeDate = new Date(date.substr(0,4),date.substr(5,2),date.substr(8,2),date.substr(11,2),date.substr(14,2));

	var nowDate = new(Date);
	var nowYear = nowDate.getYear();
	var nowMonth = nowDate.getMonth()+1;
	var nowDay = nowDate.getDate();
	var nowHours = nowDate.getHours();
	var nowMinutes = nowDate.getMinutes();

	var currentDate = new Date(nowYear,nowMonth,nowDay,nowHours,nowMinutes);

	var gapTimeStamp = currentDate.getTime()-writeDate.getTime();

	if(diffType == "D")
		gapTime = Math.abs(Math.floor(gapTimeStamp/(60*60*24*1000)));
	else if(diffType == "H")
		gapTime = Math.abs(Math.floor(gapTimeStamp/(60*60*1000)));
	else if(diffType == "M")
		gapTime = Math.abs(Math.floor(gapTimeStamp/(60*1000)));

	return gapTime;
}

/*
| -------------------------------------------------------------------
| CSRF INJECTION KEY MAKING
| -------------------------------------------------------------------
*/
function __csrfkeymake(fname, rkey, callback){

	var form = (typeof fname == "object") ? fname : ( (fname.indexOf("#")==0) ? document.getElementById(fname.substr(1)) : document[fname] );

	$.getJSON('/common_lib/mgame_csrf_makekey.mgame?rkey='+rkey, function(data) {
		try{
			if(data.code == "0"){
				return false;
			}else{
				if(typeof form._CODE_ == "undefined"){
					var input = document.createElement('input');
					input.type = 'hidden';
					input.name = input.id = '_CODE_';
					form.appendChild(input);
				}
				form._CODE_.value = data.code;
				if(typeof callback == "function"){
					callback();
				}else{
					form.submit();
				}
			}
		}catch(e1){
			return false;
		}
	});
}


// ��÷�� �˾� �Լ� / 2013-10-22 �Ҵ뿬
function winner_popup(eno){
	window.open("http://www.mgame.com/event/popup_winner.mgame?Eno=" + eno, "_winner", "width=400, height=400");
}

function iframeResize3(obj){
	//changeDomain();
	$(obj).height($(obj).contents().find('body')[0].scrollHeight+30+"px");
	//alert($(obj).contents().find('body')[0].scrollHeight+30+"px");
}
function iframeResize4(obj,height){
	//changeDomain();
	$(obj).height(height);
	//alert($(obj).contents().find('body')[0].scrollHeight+30+"px");
}