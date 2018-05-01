var socialUrl='';

var BrowserDetect={
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
		{string: navigator.userAgent, subString: "OmniWeb", versionSearch: "OmniWeb/", identity: "OmniWeb"},
		{string: navigator.vendor, subString: "Apple", identity: "Safari", versionSearch: "Version"},
		{prop: window.opera, identity: "Opera"},
		{string: navigator.vendor, subString: "iCab", identity: "iCab"},
		{string: navigator.vendor, subString: "KDE", identity: "Konqueror"},
		{string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
		{string: navigator.vendor, subString: "Camino", identity: "Camino"},
		{string: navigator.userAgent, subString: "Netscape", identity: "Netscape"},
		{string: navigator.userAgent, subString: "MSIE", identity: "Explorer", versionSearch: "MSIE"},
		{string: navigator.userAgent, subString: "Gecko", identity: "Mozilla", versionSearch: "rv"},
		{string: navigator.userAgent, subString: "Mozilla", identity: "Netscape", versionSearch: "Mozilla"}
	],
	dataOS : [
		{string: navigator.platform, subString: "Win", identity: "Windows"},
		{string: navigator.platform, subString: "Mac", identity: "Mac"},
		{string: navigator.userAgent, subString: "iPhone", identity: "iPhone/iPod"},
		{string: navigator.platform, subString: "Linux", identity: "Linux"}
	]

};
BrowserDetect.init();


function addOpenSearch(engineURL) {
	window.external.AddSearchProvider(engineURL);
}

function showhidesearchregions(elem) {
	if(document.getElementById) {
		var linkText = elem.firstChild.nodeValue;
		elem.firstChild.nodeValue = (linkText == 'Скрыть регионы') ? 'Показать все регионы' : 'Скрыть регионы';

		var tmp = document.getElementsByTagName('blockquote');
		for (var i=0;i<tmp.length;i++) {
			if(tmp[i].className == 'subregion-optional') {
				tmp[i].style.display = (tmp[i].style.display == 'none') ? 'block' : 'none';
			}
		}
	}
	return false;
}

function scrolltoheader() {
	document.all.newsheader.scrollIntoView(true);
}

function tryMoveAd() {
	if (document.getElementById) {
		divMoveFrom=document.getElementById('admovable');
		divMoveTo=document.getElementById('admovableplace');
		if(typeof(divMoveFrom)!="undefined") {
			if(typeof(divMoveTo)!="undefined") {
				divMoveTo.appendChild(divMoveFrom);
				divMoveTo.style.display='block';
			}
		}
	}
}


function setfavorite(siteurl,sitename) {
	try {
		if ((BrowserDetect.browser=='Safari')||(BrowserDetect.browser=='Chrome')||(BrowserDetect.browser=='Opera')) {
			alert("Нажмите <"+((BrowserDetect.OS=='Mac')?"Command":"Control")+">+D, чтобы запомнить ссылку в закладках");
		}else{
			if (document.all){
				window.external.AddFavorite(siteurl, sitename);
			} else {
				window.sidebar.addPanel(sitename, siteurl, "");
			}
		}
		return false;
	} catch(e){}
	
}

function sethome(o,siteurl,sitename) {
	try {
		if (BrowserDetect.browser=='Explorer') {
			o.style.behavior='url(#default#homepage)';
			o.setHomePage(siteurl);
		}
		return false;
	} catch(e){}
}

var SocialNetworks={
	init: function () {
		var encodedTitle=encodeURIComponent(socialTitle);
		var encodedUrl=encodeURIComponent(socialUrl);

		thestr='<a href="#" onclick="setfavorite(\''+socialUrl+'\', \''+socialTitle+'\');return false;" title="В закладки"><span style="background-position:0 -16px;"></span>В закладки</a><a href="#" onclick="window.print();return false;" title="Распечатать"><span style="background-position:0 -32px;"></span>Распечатать</a><div style="clear:both;height:5px;"></div>';
		for (var i=0;i<this.socNetworks.length;i++)	{
			thestr+='<a href="'+socialplug+'&social='+this.socNetworks[i].id+'&amp;url='+encodedUrl+'&amp;title='+encodedTitle+'" title="'+this.socNetworks[i].name+'" target="_blank"><span style="background-position:0 -'+(16*this.socNetworks[i].id)+'px;"></span>'+this.socNetworks[i].name+'</a>';
		}
		thestr+='<div style="clear:both;"></div>';
		$('body').append('<div id="socialmore" onmouseover="SwitchSocials(true);" onmouseout="SwitchSocials(false);">'+thestr+'</div>');


		thestr='';
		for (var i=0;i<this.topNetworks.length;i++) {
			thestr+='<a href="'+socialplug+'&social='+this.topNetworks[i].id+'&amp;url='+encodedUrl+'&amp;title='+encodedTitle+'" title="'+this.topNetworks[i].name+'" target="_blank"><span style="background-position:0 -'+(16*this.topNetworks[i].id)+'px;"></span></a>';
		}
		thestr+='<span class="separator"> | </span>';
		thestr+='<a href="" onclick="setfavorite(\''+socialUrl+'\', \''+socialTitle+'\');return false;" title="В закладки"><span style="background-position:0 -16px;"></span></a>';
		thestr+='<a href="" onclick="window.print();return false;" title="Распечатать"><span style="background-position:0 -32px;"></span></a>';
		thestr+='<span class="separator"> | </span>';
		thestr+='<a href="#" id="socbtn" onmouseover="SwitchSocials(true);" onmouseout="SwitchSocials(false);" onclick="return false;"></a>';
		$('.newsinfo').before('<div id="socialine">'+thestr+'</div><div style="clear:both;"></div>');

	},
	switchState: function(isShow) {
		if (isShow) {
			if (!this.visible) {
				var offs=$("#socialine").offset();
				$("#socialmore").css({
					'top': offs.top+16+"px",
					'left': offs.left+10+"px"
				});
				$("#socialmore").show();
				this.visible=true;
			}
		} else {
			if (this.visible) {
				$("#socialmore").hide();
				this.visible=false;
			}
		}
	},
	socNetworks:[{id:10,name:"LiveJournal"},{id:11,name:"Закладки Google"},{id:53,name:"LiveInternet"},{id:12,name:"Facebook"},{id:13,name:"Twitter"},{id:16,name:"Digg"},{id:17,name:"del.icio.us"},{id:18,name:"MySpace"},{id:19,name:"БобрДобр"},{id:20,name:"SlashDot"},{id:21,name:"Ваау!"},{id:22,name:"МоёМесто"},{id:23,name:"СМИ2"},{id:24,name:"BlinkList"},{id:25,name:"В Контакте"},{id:26,name:"Яндекс.Закладки"},{id:27,name:"FriendFeed"},{id:28,name:"LinkStore"},{id:29,name:"LinkedIn"},{id:30,name:"Memori"},{id:31,name:"Mister Wong"},{id:33,name:"Myscoop"},{id:34,name:"News2.ru"},{id:37,name:"Newsvine"},{id:38,name:"Propeller"},{id:39,name:"Reddit"},{id:41,name:"RuSpace"},{id:43,name:"StumbleUpon"},{id:44,name:"Technorati"},{id:46,name:"toodoo.ru"},{id:48,name:"Yahoo! My Web"},{id:49,name:"100 закладок"},{id:50,name:"buzz"},{id:51,name:"Микроблоги"},{id:52,name:"Ссылки@Mail.Ru"}],
	topNetworks:[{id:10,name:"LiveJournal"},{id:11,name:"Закладки Google"},{id:25,name:"В Контакте"},{id:12,name:"Facebook"},{id:13,name:"Twitter"},{id:23,name:"СМИ2"},{id:52,name:"Ссылки@Mail.Ru"},{id:19,name:"БобрДобр"}],
	visible: false,
	timeOut: null
};

function SwitchSocials(isShow) {
	if (isShow) {
		if (SocialNetworks.timeOut) {
			clearTimeout(SocialNetworks.timeOut);
		}
		SocialNetworks.switchState(isShow);
	} else {
		SocialNetworks.timeOut=setTimeout("SocialNetworks.switchState(false)", 1000);
	}
}

/*
	Функции, запускающиеся по загрузке структуры документа	*/
$(document).ready(function() {
	if (socialUrl) { SocialNetworks.init(); }
	//geotarget();
});