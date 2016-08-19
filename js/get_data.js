
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
	
	$.getJSON("getdata.php",function(res){
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
getEter();