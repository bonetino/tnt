<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script>
var eter_timer;

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

	<script>

	$(document).ready(function() {
		var data = "[{"artist":"Regata","song":"Andrea","id":"regata_-_andrea","ocjena":"5","glasao":"0","image":"default.png","history":["Tnt Id 7 - Tnt Id 7","Nina Badric - Dan D","Tony Cetinski - Opet Si Pobijedila","Vikend Id 1 - Vikend Id 1","Zdravko Colic - Ne Mogu Biti Tvoj"],"time":["22:23:30","22:18:24","22:13:35","22:13:33","22:08:51"],"emisija":"Najbolji muziÄŤÂŤki mix","slika":"emisije/default2.png","start":"02:00","end":"23:59"}]";

		var obj = $.parseJSON(data);

		$.each(obj, function() {

		$('.eterimage').attr('src', image);
		$('.eterartist').html(artist);
		$('.etersong').html(song);
		$('.eterhistory').html(list);
		
		$('.eterslika').attr('src', slika);
		$('.eteremisija').html(emisija);
		$('.eteremisijatime').html(start+' do '+end);

		}
	}
</script>


	
	$.getJSON("http://tntradio.ba/eter/getdata.php",function(res){
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
				
		$('.eterimage').attr('src', image);
		$('.eterartist').html(artist);
		$('.etersong').html(song);
		$('.eterhistory').html(list);
		
		$('.eterslika').attr('src', slika);
		$('.eteremisija').html(emisija);
		$('.eteremisijatime').html(start+' do '+end);
	});
	eter_timer = setTimeout ("getEter()", 60000); //1000 = 1 sekunda, 60000 = 1 minuta, 
}

function startPlayer()
{
	var day = new Date();
	var id = day.getTime();
	var url = 'player.php';
	window.open(url,id,'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=848,height=581');	
}

$(document).ready(function(){
	getEter();
});
</script>
<style type="text/css">
body {
	margin:0px;
}
.eterartist {
	font-family:Arial;
	font-size:13px;
	color:#000000;
	position:absolute;
	top:293px;
	left:45px;
	font-weight:bold;
}
.etersong {
	font-family:Arial;
	font-size:11px;
	color:#000000;
	position:absolute;
	top:307px;
	left:45px;
	font-weight:bold;
}
.eterul, .eterli {
	margin:0px;
	padding:0px;
	list-style-type:none;
}
.eterulpos {
	position:absolute;
	top:340px;
	left:22px;
	width:205px;
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
	top:160px;
	left:163px;
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
	top:174px;
	left:25px;
	font-weight:bold;
}
.eteremisija {
	font-family:Arial;
	font-size:13px;
	color:#000000;
	position:absolute;
	top:187px;
	left:25px;
	width:130px;
	height:35px;
	overflow:hidden;
	font-weight:bold;
}
.eterimagepos {
	position:absolute;
	top:275px;
	left:163px;
}
</style>
<body>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="250" height="507" style="background:url('back.png') no-repeat; cursor:pointer;" align="left" valign="top" onClick="javascript:startPlayer();">
    <div class="eteremisija"></div>
    <div class="eteremisijatime"></div>
    <div class="eterslikapos"><img class="eterslika" src="default2.png" width="60" height="60" border="0" alt=""></div>
    <div class="eterimagepos"><img class="eterimage" src="default.png" width="60" height="60" border="0" alt=""></div>
    <div class="eterartist"></div>
    <div class="etersong"></div>
    <ul class="eterul eterulpos eterhistory"></ul>
    </td>
  </tr>
</table>
</body>