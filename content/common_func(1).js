
// 레이어 팝업
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/mhtml.js?v1.3"></script>');
// 불량 단어
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/bad_word.js"></script>');
// getCookie 함수
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/cookie_hash.js"></script>');
// 리사이즈 함수
document.write('<script type="text/javascript" src="http://static.mgame.com/common_js/func_library.js"></script>');

var mgamePopupObject;	// 팝업 오브젝트명
var thisUri				=	location.href.replace("http://"+ location.host,"").split("/");
var thisHost			=	location.host.split(".");
var thisDomain			=	thisHost[1];
var isFrameTop = false;	//채널링시 게임홈페이지가 채널링사이트 프레임내로 들어가는경우.

// mgame.com은 www.mgame.com으로 이동
if(location.host == "mgame.com"){
	location.href	=	"http://www.mgame.com/";
}

// 도메인 셋팅

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

// RPG컨텐츠는 iframe만 허용
/*
if(thisHost[0].substr(0,2) != "mg" && thisUri[1] == "common_rpgcontents" && window == top) {
	location.href		=	"http://"+ location.host;
}
*/

//###################################################################
// 로그인 폼 체크 - 채널링 지원
// 예) <form method="post" onsubmit="return mgameLoginCheck(this)">
//###################################################################
function mgameLoginCheck(f) {
	if(mgameUserCheck(true)) return;

	f.target	=	"_top";

	if(thisDomain == "buddybuddy") {

		if (!f.ID.value.trim()) {
			error("아이디를 입력하세요.");
			return false;
		}

		if (!f.PWD.value.trim()) {
			error("비밀번호를 입력하세요.");
			return false;
		}

		f.action		=	"https://user.buddybuddy.co.kr/Login/Login.asp";
	} else if(thisDomain == "nopp") {

		if (!f.userid.value.trim()) {
			error("아이디를 입력하세요.");
			return false;
		}

		if (!f.passwd.value.trim()) {
			error("비밀번호를 입력하세요.");
			return false;
		}

		f.action		=	"https://www.nopp.co.kr/member/mem_login.asp";
	} else if(thisDomain == "sbs") {
		if (!f.id.value.trim()) {
			error("아이디를 입력하세요.");
			return false;
		}

		if (!f.passwd.value.trim()) {
			error("비밀번호를 입력하세요.");
			return false;
		}

		f.action		=	"https://sbscert.sbs.co.kr/login/Login/verifyed_login.jsp?loginType=1&national_nm=sbntOd0xfFCzQ&Login_ReturnURL="+ top.location.href;
	} else {
		if("YES" == getCookie_key("MGAME_KEY_DEFENDER")) {
			mkdplus_copy_to_form(document.f);
		}

		if(!f.mgid_enc.value.trim()) {
			error("아이디를 입력하세요.");
			return false;
		}

		if(!f.mgpwd_enc.value.trim()) {
			error("비밀번호를 입력하세요.");
			return false;
		}

		f.action		=	"https://sign.mgame.com/login/login_action_pub_type_b.mgame?tu="+ top.location.href +"&ru="+ top.location.href;
	}

	return true;
}


//###################################################################
// 로그인 여부 체크 - 체험아이디 팝업 지원/ 채널링 지원
// option이 true일 경우 메시지 띄우지 않음
// 예) if(!mgameUserCheck()) return;
// +++++++++++++++++++++++++++
// returnURL 파라미터 추가 2009-09-10 daffodil
// 엠게임은 로그인 Layer를 띄워주고, 채널링은 로그인페이지로 전환 하고 싶으면
// 아래예시로 파라미터를 넘겨준다
// 예) if(!mgameUserCheck('loginpage','리턴받고싶은URL')) return;
// ++++++++++++++++++++++++++++
//###################################################################

function simpleUserCheck(){
	//엠게임 채널링 동시 체크
	if(getCookie("MGAME") || getCookie("mgx")){
		return true;
	}else if(getCookie("PN_PUB") && (location.host.indexOf("playnetwork.co.kr") > -1)){
		return true;
	}
}

function mgameUserCheck(opt,returnURL) {
	//게임사이트가 iframe 안에서 노출되는 경우 경로 재지정	- 조원경

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

	//엠게임
	if(currentDomain == "mgame.com") {
		// 로그인 여부
		if(!getCookie("MGAME")){

			if(opt =="loginpage"){

				// 2013-04-17 소대연 수정
				returnURL = encodeURIComponent(returnURL);
				Mgame_CommonLayerOpen_trans('http://www.mgame.com/ulnauth/login_form_pop.mgame?tu='+returnURL, 427, 394, true);
			}
			else if(!opt){
				error();
			}
			return false;
		}
		// 회원타입 여부
		//if(getCookie_2DIM("MGAME","TYPE") != 1000 && getCookie_2DIM("MGAME","TYPE") != 9999 && getCookie_2DIM("MGAME","TYPE") != 7777) {
		if(getCookie_2DIM("MGAME","TYPE") != 1000 && getCookie_2DIM("MGAME","TYPE") != 9999) {
			if(top.location.host == "aw.mgame.com"){
				return true;
			}

			if(!opt) GUEST_POPUP();
			return false;
		}

	//다음 (game.daum.net)
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
					error("이용약관에 동의 해 주시기 바랍니다.");
					return false;
				}else if(gameName == "valiant"){
					error("발리언트 이용약관에 동의 해 주시기 바랍니다.");
					return false;
				}else error("이용약관에 동의 해 주시기 바랍니다.");

				if(currentDomain == "kids.daum.net") {
					top.location.href="https://user.daum.net/privagree/privinfoagree.daum?svcId="+svcId+"&codeName="+gameName+"&returnUrl=http://sign.mgame.kids.daum.net/mgame_agree.mgame?codeName="+gameName;
				} else {
					top.location.href="https://user.daum.net/privagree/privinfoagree.daum?svcId="+svcId+"&codeName="+gameName+"&returnUrl=http://sign.mgame.game.daum.net/mgame_agree.mgame?codeName="+gameName;
				}

				return false;
			}
		}else{	//로그인
			if(opt == "loginpage"){
				top.location.href = 'http://login.daum.net/accounts/loginform.do?url='+returnURL
			}else if(!opt){
				error();	return;
			}

			if(gameName == "hon"){
				return channelGoLogin(opt,'http://login.daum.net/accounts/loginform.do?url='+returnURL);
			}
		}
	//한게임 (hangame.com)
	}else if(currentDomain == "hangame.com" || currentDomain == "mgame.hangame.com"){
		if(getCookie_nhn("HG_CP_LOGIN")){
			if(!getCookie_nhn("mgx")){

				error("이용약관에 동의 해 주시기 바랍니다.");

				top.location.href="https://members.hangame.com/myinfo/thirdparty.nhn?gameid=K_HON&period=30&next=http://sign.mgame.hangame.com/agreement_nhn.mgame?codeName=hon&homeurl=http://www.hangame.com";
				return false;
			}
		}else{

			// 한게임 alpha- 테섭으로 접근시 로그인 처리 ( 100513 황재용 추가)
			var alphaval = "";
			if(top.location.host.substr(0,top.location.host.indexOf("-"))=="alpha") {
				alphaval = "alpha-";
			}
			return channelGoLogin(opt,'http://'+alphaval+'id.hangame.com/wlogin.nhn?popup=false&adult=false&nxtURL='+returnURL);
		}

	//투니랜드 (tooniland.com)
	} else if(currentDomain == "tooniland.com"){
		if(getCookie('xUserId')){
			if(!getCookie('mgx')){
				error("이용약관에 동의 해 주시기 바랍니다.");
				top.location.href='http://mgsign.tooniland.com/agreement_tooniland.mgame';
				return false;
			}
		} else {
			return false;
		}
	//카툰네트워크 (cartoonnetwork.com)
	} else if(currentDomain == "cartoonnetworkkorea.com"){
		if(getCookie('c_usr')){
			if(!getCookie('mgx')){
				error("이용약관에 동의 해 주시기 바랍니다.");
				top.location.href='http://sign.mgame.cartoonnetworkkorea.com/agreement_cartoon.mgame';
				return false;
			}
		} else {
			return channelGoLogin(opt,'http://www.cartoonnetworkkorea.com/member/login_form.html?url='+returnURL);
		}
	// 클럽5678
	} else if(currentDomain == "club5678.com"){
		if(getCookie('gCCV')){
			if(!getCookie('mgx')){
				error("이용약관에 동의 해 주시기 바랍니다.");
				top.location.href='http://sign.mgame.club5678.com/mgame_agree.mgame';
				return false;
			}
		} else {
			return channelGoLogin(opt,'http://www.cartoonnetworkkorea.com/member/login_form.html?url='+returnURL);
		}
	//온게이트
	}else if(currentDomain == "ongate.com"){
		if(getCookie('IBPROF')){
			if(!getCookie('mgx')){
				error("이용야관 동의 후 이용할 수 있습니다.");
				return false;
			}
		} else {
			return channelGoLogin('','');
		}
	}else if(currentDomain == "m-reaper.com"){
		if(getCookie('bpchkno')){
			if(!getCookie('mgx')){
				error("이용약관에 동의 해 주시기 바랍니다.");
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
// 로그아웃 - 채널링 지원
// 예) <a href="javascript:mgameLogout()">로그아웃</a>
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
// 아이디/패스워드 찾기 - 채널링 지원
// 예) <a href="javascript:mgameFindAccount()">아이디/패스워드 찾기</a>
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
// 회원가입 - 채널링 지원
// 예) <a href="javascript:mgameNewAccount()">회원가입</a>
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
// 충전
// 예) <a href="javascript:mgameCashCharge()">충전</a>
//###################################################################
function mgameCashCharge() {
	pageUrl		=	"https://mbill.mgame.com/mbank_2014/?gcode=MCASH";
	window.open(pageUrl, 'winMCashCharge', 'width=600,height=560,left=10,top=10');
}


//###################################################################
// 게임 시작
// 로그인 여부 체크 후 런쳐 실행
// 예) <a href="javascript:mgameStart('popstage')">게임실행</a>
//###################################################################
function mgameStart(game) {

	if(!mgameUserCheck()) return;

	try {
		launch_game(game);
	} catch(e) {
		error("게임 실행에 필요한 함수가 없습니다.");
	}
}


//###################################################################
//이미지 리사이즈
//size값 보다 width값이 클 경우 size값으로 리사이징
//예) <img src="a.jpg" alt="a" onload="imageResize(this,500)" />
//###################################################################
function imageResize(obj,size) {
	if(!size) {
		obj.width		=	"100%";
	} else {
		if(w=eval(obj.width) > size) obj.width = size;
	}
}


//###################################################################
// 바이트 수 제한
// input, textarea에 limit값 만큼만 입력가능
// div값이 있을 경우 해당 id값에 현재 바이트 출력
// 예) <textarea onkeyup="messageLimit(this,100)"></textarea>
// 예)<input type="text" onkeyup="messageLimit(this,50,'byte2')">(<span id="byte2">0/50byte</span>)
//###################################################################
function messageLimit(obj,limit,div) {
	var nByte			=	0;

	for(var i=0;i<obj.value.length;i++) {
		nByte			+=	(obj.value.charCodeAt(i)>128) ? 2 : 1;

		if(nByte >= limit) break;
	}

	if(nByte >= limit) {
		error(limit +" Bytes 까지만 입력이 가능합니다.");
		obj.value			=	obj.value.substr(0,i);
	}

	if(document.getElementById("divMessageLimit")) {
		document.getElementById("divMessageLimit").innerText	=	nByte +"/"+ limit +" Bytes";
	} else if(div) {
		document.getElementById(div).innerText	=	nByte +"/"+ limit +" Bytes";
	}
}


//###################################################################
// 리사이즈
// 웹2.0에 따른 if_Resize2() 업그레이드 버젼
// iframe 사이즈를 변경하는 방식이랑 외부의 margin이나 padding값에도 정확한 리사이징~
// 예) <iframe name="content" width="100%" onload="iframeResize(this)"></iframe>
//###################################################################

function iframeResize(ifrm) {
	//alert("common_func.js의 resize function");
	//alert("네이트온 리사이즈 테스트 네이트 온에서 리사이즈가 되시는 분은 공유해 주세요~");
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

	//alert("common_func.js의 resize function");
	//alert("네이트온 리사이즈 테스트 네이트 온에서 리사이즈가 되시는 분은 공유해 주세요~");
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
// 리사이즈
// 테이블 코딩일 경우 iframe resize 하는데, iframe의 height에 parameter 로 받은 add할 값을 더한다
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
// 예) <iframe name="content" width="100%" onload="iframeResize(this)"></iframe>
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
// 숫자만 받기 - input, textarea에 숫자만 받음
// 예) <input type="text" onkeyup="numberCheck(this)" />
//###################################################################
function numberCheck(obj) {
	obj.value			=	obj.value.replace(/[^0-9]/gi,"");
}


//###################################################################
// 익스플로러 7 검사 - 익스플로러 7이면 true반환
// 예) if(!isIE7()) return;
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
// 공백 제거
// 예) if(!document.form1.subject.value.trim()) return;
//###################################################################
String.prototype.trim = function() {
    return this.replace(/(^[ \f\n\r\t]*)|([ \f\n\r\t]*$)/g, "");
}


//###################################################################
// 천단위 컴마구분
// 예) document.form1.no.value = document.form1.no.value.numberFormat();
//###################################################################
// 1000단위 구분
String.prototype.numberFormat	=	function() {
    return this.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
}


//###################################################################
// 글자수 제한
// 예) document.write(document.form1.subject.cut(15));
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
// 파일 인클루드 - 스크립트 파일 인클루드
// PHP include 함수와 동일
// 예) include("http://www.mgame.com/common_js/mhtml.js");
//###################################################################
function include( filename ) {
	var js	=	document.createElement('script');
	js.setAttribute('type', 'text/javascript');
	js.setAttribute('src', filename);
	js.setAttribute('defer', 'defer');
	document.getElementsByTagName('head')[0].appendChild(js);
}


//###################################################################
// 에러처리 - 레이어 팝업 띄움 /  채널링 지원
// object, iframe체크 후 자동으로 레이어 또는 모달창으로 띄움
// confirm이 true일 경우 confirm용 모달창 띄움
// modal이 true일 경우 무조건 모달창 띄움
//예) error("웹서비스개발팀");
//###################################################################
function error(msg,opt,modal) {

	if(!msg) {
		msg	=	"로그인 후 이용하여 주세요.";
	}

	if(thisDomain == "mgame") {
		if(opt) {
			return Mgame_ConfirmPopupOpen(msg);
		} else {
			var obj		=	document.getElementsByTagName("iframe");
			var flag		=	modal ? 1 : 0;
			for(var i=0;i<obj.length;i++) {
				// 런쳐를 제외한 나머지
				if(obj[i].name != "launch") {
					try {
						// object 포함
						//alert(eval(obj[i].name).document.getElementsByTagName("object").length);
						if(eval(obj[i].name).document.getElementsByTagName("object").length) flag++;
					} catch(ex) {
						flag++;
					}
					// 익스플로러 6은 select 태그 포함
					if(isIE() && !isIE7()) {
						try {
							if(eval(obj[i].name).document.getElementsByTagName("select").length) flag++;
						} catch(ex) {
							flag++;
						}
					}
				}
			}

			if(document.getElementById("mgamePlayer")) flag++;	//	내가 만든 플레이어 아이디
			if(document.getElementById("flvplayer")) flag++;			//	UCC 플레이어 아이디

			// 예외처리
			if(top.location.href.indexOf("guild.mgame.com/guild/game/wffm") != -1) flag = null;
			if(top.location.href.indexOf("flash.mgame.com") != -1) flag++;
			if(location.href.indexOf("wffm.mgame.com") != -1) flag++;


			if(modal) flag++;
			// flag 값이 있으면 모달 팝업

			if(flag) {
				try {
					top.Mgame_ErrorPopupOpen("free",msg);

				} catch(e) {

					Mgame_ErrorPopupOpen("free",msg);
				}
			// flag 값이 없으면 레이어 팝업
			} else {
				try {
					top.Mgame_ErrorLayerOpen("free",msg);
				} catch(e) {
					Mgame_ErrorLayerOpen("free",msg);

				}
			}
		}
	// 나머지 도메인은 모두 기본값
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


// 파일명을 변경
function thisFile(a) {
	var thisHref		=	location.href.split("/");
	var thisReFile		=	thisHref[thisHref.length-1].replace(/(\?(.)*)/gi,"");
	var thisLocate		=	thisReFile.split(".");
	var thisName		=	thisLocate[0].replace(/(_(.)*)/gi,"");

	return a ? thisName + "_" + a +"."+thisLocate[1] : thisName + "."+thisLocate[1];
}


// 클립보드 저장
function copyLink(v) {
	try {
		var copyPath	=	copyUrl;
	} catch(e) {
		var copyPath	=	location.href +"?idx="+ v;
	}

	clipboardData.setData("Text",copyPath);
	error("클립보드에 저장하였습니다.");
}


// 팝업 띄움
function mgamePopup(param,w,h) {
	var popupWidth	=	w ? w : 50;
	var popupHeight	=	h ? h : 50;

	mgamePopupObject	=	window.open(param,"mgamePopup","width="+ popupWidth +",height="+ popupHeight +",top=0,left=0");
}

// 팝업 띄움(스크롤 있게)
function mgamePopup_scroll(param,w,h) {
	var popupWidth	=	w ? w : 50;
	var popupHeight	=	h ? h : 50;

	mgamePopupObject	=	window.open(param,"mgamePopup","width="+ popupWidth +",height="+ popupHeight +",top=0,left=0,scrollbars=1,resizable=yes");
}


// 레이어 팝업 띄움
function mgameLayerPopup(param,w,h) {
	var popupWidth	=	w ? w : 50;
	var popupHeight	=	h ? h : 50;

	Mgame_CommonLayerOpen(param,popupWidth,popupHeight);
}

//###################################################################
// 게시판 관련
//###################################################################
// 등록하기
function writeLink() {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;
	p.action			=	thisFile("write");
	p.submit();
}

// 답변하기
function replyLink() {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;

	p.action			=	thisFile("write");
	p.mode.value		=	"reply";
	p.submit();
}

// 읽기
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
// 읽기_target=_top
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

// 페이지 변경하기
function pageLink(page) {
	var p	=	document.procForm;
	if(p.idx.value != ""){
		p.idx.value = "";
	}
	p.page.value		=	page;
	p.submit();
}

// 리스트로 돌아가기
function listLink() {
	var p	=	document.procForm;

	p.action			=	thisFile();
	p.submit();
}

// 모드값 처리
function modeLink(m) {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;

	p.mode.value		=	m;
	p.action			=	thisFile("proc");
	p.submit();
}

// 삭제하기
function deleteLink() {
	if(!mgameUserCheck()) return;

	if(!error("삭제하시겠습니까?",true)) {
		return;
	}

	var p	=	document.procForm;

	p.mode.value		=	"delete";
	p.action			=	thisFile("proc");
	p.submit();
}

// 수정하기
function editLink() {
	if(!mgameUserCheck()) return;

	var p	=	document.procForm;

	p.mode.value		=	"edit";
	p.action			=	thisFile("write");
	p.submit();
}

// 댓글 처리파일
function ajaxProc() {
	try {
		var cAction		=	ajaxAction;
	} catch(e) {
		var cAction		=	thisFile("comment");
	}

	return cAction;
}

// 댓글 작성 후 리사이즈
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

// 댓글 출력 div명
function ajaxId() {
	try {
		var div			=	ajaxDiv;
	} catch(e) {
		var div			=	"divAjax";
	}

	return div;
}

// 댓글 공통 쿼리
function ajaxVariable() {
	try {
		var query		=	ajaxQuery;
	} catch(e) {
		var query		=	"";
	}

	return query;
}

// 댓글 페이징
function ajaxPage(page) {
	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&page="+ (page ? page : 1));
	ajaxResize();
}

// 댓글 입력
function commentWrite() {

	if(location.host.indexOf("picaon.com") > 0) {
		if(!getCookie("PICAGAMECHANNELINFO")){
			alert('로그인후 사용가능합니다.');
			return;
		}else if(!getCookie("mgx")){
			alert('이용약관 동의 후 이용해주세요.');
			return;
		}
	}

	if(location.host.indexOf("ongate.com") > 0) {
		if(!getCookie("IBPROF")){
			alert("로그인 후 이용해주세요.");
			return;
		}else if(!getCookie("mgx")){
			alert("이용약관 동의 후 이용해주세요.");
			return;
		}
	}
	if(!mgameUserCheck()) return;

	// 제한적 본인인증은 commentAuth에.. 스크립트로 불가능.
	try {
		commentAuth();
	} catch(e) {
	}


	var f	=	document.commentForm;

	if(!f.comment.value.trim()) {
		error("댓글을 입력하여 주세요.");
		return;
	}

	if(f.comment.value.substring(0,4) == "  * "){
		error("댓글을 입력하여 주세요.");
		f.comment.value = "";
		return;
	}

	// 불량단어 제거
	f.comment.value	= ch_BadWord(f.comment.value);
	f.comment.value = f.comment.value.replace(/"/ig, "&quot;");			//    "  값  변경
	f.comment.value = f.comment.value.replace(/'/ig, "&#39;");			//    '  값  변경
	f.comment.value = f.comment.value.replace(/ /ig, "&nbsp;");			//스페이스 값 변경
	f.comment.value = f.comment.value.replace(/\r\n/ig, "<br>");		//엔터값변경

	var chr		= encodeURIComponent(f.comment.value);				//인코딩으로 특수문자 들어가게 변경 (한글 깨짐) (주의 : UTF-8 로 받아야한다)
	var vKey	= (f.vaString) ? f.vaString.value : '';				// 게시판 댓글 등록시 유효성 체크위한 값

	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&mode=write&vaString="+vKey+"&comment="+ encodeURIComponent(chr));
	f.reset();
	ajaxResize();
}

// 댓글 삭제
function commentDelete(idx) {
	if(!mgameUserCheck()) return;
	if(!error("삭제하시겠습니까?",1)) return;

	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&mode=delete&idx="+ idx);
	ajaxResize();
}

// 댓글 답글
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

// 댓글 답글 등록
function commentReplyWrite(idx,reIdx,reLevel,reStep) {

	if(!mgameUserCheck()) return;

	// 제한적 본인인증은 commentAuth에.. 스크립트로 불가능.
	try {
		commentAuth();
	} catch(e) {
	}

	var f	=	eval("document.commentForm.comment_"+ idx);

	if(!f.value.trim()) {
		error("댓글을 입력하여 주세요.");
		return;
	}

	// 불량단어 제거
	f.value	=	ch_BadWord(f.value);
	f.value = f.value.replace(/"/ig, "&quot;");			//    "  값  변경
	f.value = f.value.replace(/'/ig, "&#39;");				//    '  값  변경
	f.value = f.value.replace(/ /ig, "&nbsp;");			//스페이스 값 변경
	f.value = f.value.replace(/\r\n/ig, "<br>");			//엔터값변경

	var vKey	= (document.commentForm.vaString) ? document.commentForm.vaString.value : '';			// 게시판 댓글 등록시 유효성 체크위한 값

	var chr = encodeURIComponent(f.value);							//인코딩으로 특수문자 들어가게 변경 (한글 깨짐) (주의 : UTF-8 로 받아야한다)
	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&mode=reply&idx="+ reIdx +"&reLevel="+ reLevel +"&reStep="+ reStep +"&comment="+ encodeURIComponent(chr)+"&vaString="+vKey);
	document.commentForm.reset();
	ajaxResize();
}

// 댓글 검색
function commentSearch() {
	if(!document.searchForm) return;

	var f	=	document.searchForm;

	ajaxRequest(ajaxId(),ajaxProc(),ajaxVariable() +"&searchName="+ f.searchName.value +"&searchWord="+ f.searchWord.value);
	ajaxResize();
}

//###################################################################
//  공지 , 이벤트 등 콘텐츠 내 URL 변경
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
//  날짜 차이 가져옴
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


// 당첨자 팝업 함수 / 2013-10-22 소대연
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