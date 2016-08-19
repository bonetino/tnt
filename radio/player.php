<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TNT radio :: Najbolji muzički mix</title>
<link rel="stylesheet" href="style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="playerJW.js"></script>

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
	
	$.getJSON("http://tntradio.ba/eter/getdata.php?"+date.getTime(),function(res){
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
		</script>
      
    </td>
  </tr>
</table>
</body>
</html>
