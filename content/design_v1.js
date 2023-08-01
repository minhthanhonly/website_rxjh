// common
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3)
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_jumpMenu_blank(selObj,restore){ //v3.0
  eval("window.open='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


// rollover
function initRollovers() {
	if (!document.getElementById) return

	var aPreLoad = new Array();
	var sTempSrc;
	var aImages = document.getElementsByTagName('img');

	for (var i = 0; i < aImages.length; i++) {
		if (aImages[i].className == 'imgover') {
			var src = aImages[i].getAttribute('src');
			var ftype = src.substring(src.lastIndexOf('.'), src.length);

			if(src.indexOf('_on') < 0 ){		// class=imgover 다써놔도 되게 하기 위해 추가
				var hsrc = src.replace(ftype, '_on'+ftype);

				aImages[i].setAttribute('hsrc', hsrc);

				aPreLoad[i] = new Image();
				aPreLoad[i].src = hsrc;

				aImages[i].onmouseover = function() {
					sTempSrc = this.getAttribute('src');
					this.setAttribute('src', this.getAttribute('hsrc'));
				}

				aImages[i].onmouseout = function() {
					if (!sTempSrc) sTempSrc = this.getAttribute('src').replace('_on'+ftype, ftype);
					this.setAttribute('src', sTempSrc);
				}
			}
		}
	}
}
window.onload = initRollovers;

// Tab Content
function initTabMenu(tabContainerID) {
	var tabContainer = document.getElementById(tabContainerID);
	var tabAnchor = tabContainer.getElementsByTagName("a");
	var i = 0;

	for(i=0; i<tabAnchor.length; i++) {
		if (tabAnchor.item(i).className == "tab")
			thismenu = tabAnchor.item(i);
		else
			continue;

		thismenu.container = tabContainer;
		thismenu.targetEl = document.getElementById(tabAnchor.item(i).href.split("#")[1]);
		thismenu.targetEl.style.display = "none";
		thismenu.imgEl = thismenu.getElementsByTagName("img").item(0);
		thismenu.onclick = function tabMenuClick() {
			currentmenu = this.container.current;
			if (currentmenu == this)
				return false;

			if (currentmenu) {
				currentmenu.targetEl.style.display = "none";
				if (currentmenu.imgEl) {
					currentmenu.imgEl.src = currentmenu.imgEl.src.replace("_on.gif", ".gif");
				} else {
					currentmenu.className = currentmenu.className.replace(" on", "");
				}
			}
			this.targetEl.style.display = "";
			if (this.imgEl) {
				this.imgEl.src = this.imgEl.src.replace(".gif", "_on.gif");
			} else {
				this.className += " on";
			}
			this.container.current = this;

			return false;
		};

		if (!thismenu.container.first)
			thismenu.container.first = thismenu;
	}
	if (tabContainer.first)
		tabContainer.first.onclick();
}

// png
function setPng24(obj) {
    obj.width=obj.height=1;
    obj.className=obj.className.replace(/\bpng24\b/i,'');
    obj.style.filter =
    "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
    obj.src='http://image.mgame.com/icon_bin.gif';
    return '';
}

// vertical-align middle
function verticalAlign(obj){
    result=(obj.offsetParent.offsetHeight - obj.offsetHeight)/2+"px";
    if(obj.readyState == "complete"){
        obj.style.marginTop="0";
        obj.style.marginTop=result;
    }else{
        return result;
    }
}

//max-width, max-height
function maxSize(obj,w,h){
    if(obj.readyState != "complete") return "auto";
    real_w=obj.offsetWidth;
    real_h=obj.offsetHeight;
    virt_w=obj.offsetWidth;
    virt_h=obj.offsetHeight;
    if(w>0 && virt_w>w){
        virt_w = w;
        virt_h = real_h * (virt_w/real_w);
    }
    if(h>0 && virt_h>h){
        virt_h = h;
        virt_w = real_w * (virt_h/real_h);
    }

    obj.style.width="0";
    obj.style.height="0";
    obj.style.width=virt_w+"px";
    obj.style.height=virt_h+"px";

}

//min-height
function min_height(obj,h){
    if(obj.readyState != "complete") return "auto";
    if(obj.offsetHeight<h){
        obj.style.height="0";
        obj.style.height=h+"px";
    }

}

// Change Over Row Class
function changeOverRowClass(elId, tagName, searchClass) {
	var el = document.getElementById(elId).getElementsByTagName(tagName);

	for (i=0; i<el.length; i++) {
		if (el[i].className == searchClass || el[i].className == searchClass + " on") {
			el[i].onmouseover = changeOverRowClassOver;
			el[i].onmouseout = changeOverRowClassOut;
		}
	}
}
function changeOverRowClassOver() {
	if (this.className == "") {
		this.className = this.className + " on";
	} else {
		this.className = "on";
	}
}
function changeOverRowClassOut() {
	if (this.className == "on") {
		this.className = "";
	} else {
		this.className = this.className.replace(" on", "");
	}
}

// Add Even Row Class
function addEvenRowClass(elId, tagName, searchClass, addClass) {
	var count = 1;
	var el = document.getElementById(elId).getElementsByTagName(tagName);

for (i=0; i<el.length; i++) {
		if (el[i].className == searchClass) {
			if (count%2) {
				el[i].className = el[i].className + " " + addClass;
			}
			count++;
		}
	}
}

// definition list toggle
function initToggle(tabContainer) {
	triggers = tabContainer.getElementsByTagName("a");

	for(i = 0; i < triggers.length; i++) {
		if (triggers.item(i).href.split("#")[1])
			triggers.item(i).targetEl = document.getElementById(triggers.item(i).href.split("#")[1]);

		if (!triggers.item(i).targetEl)
			continue;

		triggers.item(i).targetEl.style.display = "none";
		triggers.item(i).onclick = function () {
			if (tabContainer.current == this) {
				this.targetEl.style.display = "none";
				tabContainer.current = null;
			} else {
				if (tabContainer.current) {
					tabContainer.current.targetEl.style.display = "none";
				}
				this.targetEl.style.display = "block";
				tabContainer.current = this;
			}
			return false;
		}
	}
}

// iframe resize
function resizeFrame(frm) {
	frm.style.height = "auto";
	contentHeight = frm.contentWindow.document.documentElement.scrollHeight;
	frm.style.height = contentHeight + 0 + "px";
}

// scroll layer
function initMoving(target, position, topLimit, btmLimit) {
	if (!target)
		return false;

	var obj = target;
	obj.initTop = position;
	obj.topLimit = topLimit;
	obj.bottomLimit = document.documentElement.scrollHeight - btmLimit;

	obj.style.position = "absolute";
	obj.top = obj.initTop;
	obj.left = obj.initLeft;

	if (typeof(window.pageYOffset) == "number") {
		obj.getTop = function() {
			return window.pageYOffset;
		}
	} else if (typeof(document.documentElement.scrollTop) == "number") {
		obj.getTop = function() {
			return document.documentElement.scrollTop;
		}
	} else {
		obj.getTop = function() {
			return 0;
		}
	}

	if (self.innerHeight) {
		obj.getHeight = function() {
			return self.innerHeight;
		}
	} else if(document.documentElement.clientHeight) {
		obj.getHeight = function() {
			return document.documentElement.clientHeight;
		}
	} else {
		obj.getHeight = function() {
			return 500;
		}
	}

	obj.move = setInterval(function() {
		if (obj.initTop > 0) {
			pos = obj.getTop() + obj.initTop;
		} else {
			pos = obj.getTop() + obj.getHeight() + obj.initTop;
			//pos = obj.getTop() + obj.getHeight() / 2 - 15;
		}

		if (pos > obj.bottomLimit)
			pos = obj.bottomLimit;
		if (pos < obj.topLimit)
			pos = obj.topLimit;

		interval = obj.top - pos;
		obj.top = obj.top - interval / 3;
		obj.style.top = obj.top + "px";
	}, 30)
}

// Top Menu
function initNavigation(seq) {
	nav = document.getElementById("gnb");
	nav.menu = new Array();
	nav.current = null;
	nav.menuseq = 0;
	navLen = nav.childNodes.length;

	allA = nav.getElementsByTagName("a")
	for(k = 0; k < allA.length; k++) {
		allA.item(k).onmouseover = allA.item(k).onfocus = function () {
			nav.isOver = true;
		}
		allA.item(k).onmouseout = allA.item(k).onblur = function () {
			nav.isOver = false;
			setTimeout(function () {
				if (nav.isOver == false) {
					if (nav.menu[seq])
						nav.menu[seq].onmouseover();
					else if(nav.current) {
						menuImg = nav.current.childNodes.item(0);
						menuImg.src = menuImg.src.replace("_on.gif", ".gif");
						if (nav.current.submenu)
							nav.current.submenu.style.display = "none";
						nav.current = null;
					}
				}
			}, 500);
		}
	}

	for (i = 0; i < navLen; i++) {
		navItem = nav.childNodes.item(i);
		if (navItem.tagName != "LI")
			continue;

		navAnchor = navItem.getElementsByTagName("a").item(0);
		navAnchor.submenu = navItem.getElementsByTagName("ul").item(0);

		navAnchor.onmouseover = navAnchor.onfocus = function () {
			if (nav.current) {
				menuImg = nav.current.childNodes.item(0);
				menuImg.src = menuImg.src.replace("_on.gif", ".gif");
				if (nav.current.submenu)
					nav.current.submenu.style.display = "none";
				nav.current = null;
			}
			if (nav.current != this) {
				menuImg = this.childNodes.item(0);
				menuImg.src = menuImg.src.replace(".gif", "_on.gif");
				if (this.submenu)
					this.submenu.style.display = "block";
				nav.current = this;
			}
			nav.isOver = true;
		}
		nav.menuseq++;
		nav.menu[nav.menuseq] = navAnchor;
	}
	if (nav.menu[seq])
		nav.menu[seq].onmouseover();
}

// showhide layer
function popupLayer(divName){
	var div_style =document.getElementById(divName).style.display;
	if (div_style == "block")
	{
		document.getElementById(divName).style.display ="none";
	}else {
		document.getElementById(divName).style.display ="block";
	}
}

try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}