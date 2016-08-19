<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TNT radio :: Najbolji muzički mix</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.popup_back {
	background:url(popupback_jw.png) no-repeat;
}
#player {
	position:absolute;
	top:182px;
	left:350px;
	width:330px;
	height:380px;
	padding:0px;
	margin:0px;
}
.link {
	position:absolute;
	top:131px;
	left:6px;
	width:120px;
	height:30px;
	padding:0px;
	margin:0px;
}
.link > a {
	position:absolute;
	display:block;
	top:0px;
	left:0px;
	width:120px;
	height:30px;
	padding:0px;
	margin:0px;
}
.eterartist {
	font-family:Arial;
	font-size:13px;
	color:#000000;
	position:absolute;
	top:353px;
	left:55px;
	font-weight:bold;
}
.etersong {
	font-family:Arial;
	font-size:11px;
	color:#000000;
	position:absolute;
	top:367px;
	left:55px;
	font-weight:bold;
}
.eterul, .eterli {
	margin:0px;
	padding:0px;
	list-style-type:none;
}
.eterulpos {
	position:absolute;
	top:430px;
	left:38px;
	width:240px;
}
.eterlipos {
	border-top:1px dotted #666666;
	font-size:10px;
	color:#666666;
	font-weight:bold;
	font-family:Arial;
	height:20px;
	padding-top:5px;
}
.eterslikapos {
	position:absolute;
	top:192px;
	left:203px;
}
.eterslika {
	-webkit-border-top-right-radius: 10px;
	-moz-border-radius-topright: 10px;
	border-top-right-radius: 10px;
}
.eteremisijatime {
	font-family:Arial;
	font-size:11px;
	color:#FF0000;
	position:absolute;
	top:208px;
	left:35px;
	font-weight:bold;
}
.eteremisija {
	font-family:Arial;
	font-size:13px;
	color:#000000;
	position:absolute;
	top:221px;
	left:35px;
	width:155px;
	height:35px;
	overflow:hidden;
	font-weight:bold;
}
.eterimagepos {
	position:absolute;
	top:332px;
	left:203px;
}
.ocjena {
	position:absolute;
	top:395px;
	left:38px;
	height:23px;
	width:129px;
	overflow:hidden;
	background:url(oceni.png) no-repeat;
	display:none;
}
.zvijezda1 {
	position:absolute;
	top:5px;
	left:50px;
	height:12px;
	width:15px;
	background:url(zvezdica0.png) no-repeat;
}
.zvijezda2 {
	position:absolute;
	top:5px;
	left:65px;
	height:12px;
	width:15px;
	background:url(zvezdica0.png) no-repeat;
}
.zvijezda3 {
	position:absolute;
	top:5px;
	left:80px;
	height:12px;
	width:15px;
	background:url(zvezdica0.png) no-repeat;
}
.zvijezda4 {
	position:absolute;
	top:5px;
	left:95px;
	height:12px;
	width:15px;
	background:url(zvezdica0.png) no-repeat;
}
.zvijezda5 {
	position:absolute;
	top:5px;
	left:110px;
	height:12px;
	width:15px;
	background:url(zvezdica0.png) no-repeat;
}
.zvijezda {
	cursor:pointer;
}
.zvijezda_act {
	background:url(zvezdica1.png) no-repeat;
}
#login {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	position:absolute;
	top:350px;
	left:360px;
	width:300px;
	text-align:center;
}
#username {
	border:1px solid #000;
	font-size:12px;
	width:150px;
}
#chatlogin {
	border:1px solid #000;
	font-size:12px;
	background-color:#C30;
	color:#FFF;
	font-weight:bold
}
#write {
	border:1px solid #000;
	font-size:12px;
	width:230px;
}
#writedata {
	border:1px solid #000;
	font-size:12px;
	background-color:#C30;
	color:#FFF;
	font-weight:bold
}
.chatWrite {
	position:absolute;
	top:523px;
	left:355px;
	width:300px;
	display:none;
}
#chat {
	position:absolute;
	top:210px;
	left:350px;
	width:320px;
	height:340px;
}
.chatli {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	padding:2px;
}
.lista {
	background:#F2F2F2;
}
.listb {
	background:#FFF;
}
.banner {
	position:absolute;
	top:6px;
	left:700px;
	width:143px;
	height:569px;
	border:none;
}
</style>
<script>
var eter_timer, chat_timer, login_timer;
var login = false;

function getEter()
{
	clearTimeout(eter_timer);
	var artist = "";
	var song = "";
	var image = "";
	var history = new Array();
	var time = new Array();
	var list = "";
	var emisija = "";
	var slika = "";
	var start = "";
	var end = "";
	var id = 0;
	var ocjena = 0;
	var glasao = 0;
	
	var date = new Date();
	
	$.getJSON("getdata.php?"+date.getTime(),function(res){
		artist = res.artist;
		song = res.song;
		image = res.image;
		for (var i=0; i<res.history.length; i++)
		{
			history[i] = res.history[i];
			time[i] = res.time[i];
			list += '<li class="eterli eterlipos">'+res.history[i]+'</li>';
		}
		emisija = res.emisija;
		slika = res.slika;
		start = res.start;
		end = res.end;
		id = res.id;
		ocjena = res.ocjena;
		glasao = res.glasao;
				
		$('.eterimage').attr('src', image);
		$('.eterartist').html(artist);
		$('.etersong').html(song);
		$('.eterhistory').html(list);
		
		$('.eterslika').attr('src', slika);
		$('.eteremisija').html(emisija);
		$('.eteremisijatime').html(start+' do '+end);
		
		$('.ocjena').attr('alt', id);
		if (glasao > 0)
		{
			$('.ocjena').attr('title', 'Već ste ocijenili ovu pjesmu.');	
		}
		else
		{
			$('.ocjena').attr('title', 'Ocjeni pjesmu.');	
		}
		$('.zvijezda').removeClass('zvijezda_act');
		for (o=1; o<=ocjena; o++)
		{
			$('.zvijezda'+o).addClass('zvijezda_act');
			$('.zvijezda'+o).attr('alt', 'glas');
		}
	});
	eter_timer = setTimeout ("getEter()", 30000); //1000 = 1 sekunda, 60000 = 1 minuta, 
}

function zvijezda(id) 
{
	if ($('.ocjena').attr('title') == "Ocjeni pjesmu.")
	{
		$('.zvijezda').removeClass('zvijezda_act');
		for (i=1; i<=id; i++)
		{
			$('.zvijezda'+i).addClass('zvijezda_act');
		}
	}
}

function zvijezda_out() 
{
	$('.zvijezda').addClass('zvijezda_act');
	$('.zvijezda[alt!="glas"]').removeClass('zvijezda_act');
}

function ocjeni(ocjena)
{
	var date = new Date();
	if ($('.ocjena').attr('title') == "Ocjeni pjesmu.")
	{
		$.ajax({ 
			type: "POST", 
			url: "ocjeni.php", 
			data: "songid="+$('.ocjena').attr('alt')+'&ocjena='+ocjena+'&time='+date.getTime(), 
			success: function(res)
			{ 
				getEter();
			} 
		});
	}
}

function checkLogin()
{
	clearTimeout(login_timer);
	login_timer = setTimeout("checkLogin()", 1000);
	$('.ocjena').css('display', 'none');
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x=="chatname")
		{
   			//return unescape(y);
			$('.ocjena').css('display', 'block');
			clearTimeout(login_timer);
			break;
		}
 	}	
}

$(document).ready(function(){
	getEter();
	checkLogin();
});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-134895-21']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
<table width="848" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="581" align="left" valign="top" class="popup_back">
      <div class="link"><a href="http://server1.tnt.ba:10100/listen.pls?sid=1"></a></div>
	  <div class="eteremisija"></div>
      <div class="eteremisijatime"></div>
      <div class="eterslikapos"><img class="eterslika" src="default2.png" width="75" height="75" border="0" alt=""></div>
      <div class="eterimagepos"><img class="eterimage" src="default.png" width="75" height="75" border="0" alt=""></div>
      <div class="eterartist"></div>
      <div class="etersong"></div>
      <ul class="eterul eterulpos eterhistory"></ul>
      <div class="ocjena" alt="">
       	<div class="zvijezda1 zvijezda" onmouseover="zvijezda(1);" onmouseout="zvijezda_out();" onclick="ocjeni(1);"></div>
        <div class="zvijezda2 zvijezda" onmouseover="zvijezda(2);" onmouseout="zvijezda_out();" onclick="ocjeni(2);"></div>
        <div class="zvijezda3 zvijezda" onmouseover="zvijezda(3);" onmouseout="zvijezda_out();" onclick="ocjeni(3);"></div>
        <div class="zvijezda4 zvijezda" onmouseover="zvijezda(4);" onmouseout="zvijezda_out();" onclick="ocjeni(4);"></div>
        <div class="zvijezda5 zvijezda" onmouseover="zvijezda(5);" onmouseout="zvijezda_out();" onclick="ocjeni(5);"></div>
      </div>
        <div id="player" class="player"></div>
		<script src="http://jwpsrv.com/library/dMzfJM6eEeKKUxIxOQulpA.js"></script>
        <script>
		jwplayer('player').setup({
			file: 'http://server1.tnt.ba:10100/;*.mp3',/*file: 'http://server1.tnt.ba:10100/;*.mp3', //narodni*/ 
			type: 'mp3',
			width: 330,
			height: 380,
			autostart: true,
			image: 'poster.jpg',
			displaytitle: "TNT Radio",
			events: {
				onPause: function(event) {
				  jwplayer('player').stop();}
			}
		});
		
  </tr>
</table>
</body>
</html>
