<?
error_reporting(0);
date_default_timezone_set('Europe/Sarajevo');
$xml = simplexml_load_file('NowOnAir.xml');

if (session_id() == "")
{
	session_start();
}
$sid = session_id();

$now_artist = ucwords(strtolower($xml->Event->Song->Artist['name']));
$now_song = ucwords(strtolower($xml->Event->Song['title']));
$now_id = str_replace(" ","_",strtolower($xml->Event->Song->Artist['name'])."_-_".strtolower($xml->Event->Song['title']));

if (strlen($now_artist) > 16)
{
	$now_artist = substr($now_artist, 0, 16)." ...";
}

if (strlen($now_song) > 21)
{
	$now_song = substr($now_song, 0, 21)."...";
}

$xml = simplexml_load_file('AirPlayHistory.xml');

$history = "";
$time = "";

for ($i=count($xml->Song)-1; $i>=0; $i--)
{
	if ($i==count($xml->Song)-1)
	{
		$s = ucwords(strtolower($xml->Song[$i]->Artist['name']." - ".$xml->Song[$i]['title']));
		if (strlen($s) > 36)
		{
			$s = substr($s, 0, 36)."...";
		}
		$history .= "\"".$s."\"";
		$time .= "\"".$xml->Song[$i]->Info['StartTime']."\"";
	}
	else
	{
		$s = ucwords(strtolower($xml->Song[$i]->Artist['name']." - ".$xml->Song[$i]['title']));
		if (strlen($s) > 36)
		{
			$s = substr($s, 0, 36)."...";
		}
		$history .= ",\"".$s."\"";
		$time .= ",\"".$xml->Song[$i]->Info['StartTime']."\"";	
	}
}

//Ukinuti ovaj red ispod
$image = "default.png";
include "dbconf.php";
$timestamp = date ("H:i:s");
$weekday = date ("w");

$res = mysql_query ("SELECT naziv, slika, start, end FROM eter_emisije WHERE weekday = '$weekday' AND start <= '$timestamp' AND end >= '$timestamp' LIMIT 1")
or die ();

if (mysql_num_rows($res)>0)
{
	list ($emisija, $slika, $start, $end) = mysql_fetch_row($res);
	$start = date ("H:i", strtotime($start));
	$end = date ("H:i", strtotime($end));
	if ($slika == "")
	{
		$slika = "emisije/default2.png";	
	}
	else
	{
		$slika = "emisije/".$slika;
	}
}
else
{
	$emisija = "Radio TNT";
	$slika = "emisije/default2.png";
	$start = "00:00";
	$end = "23:59";
}

$res = mysql_query ("SELECT COUNT(songid), SUM(ocjena) FROM eter_ocjena WHERE songid = '$now_id'")
or die ();

list ($total, $ocjene) = mysql_fetch_row($res);
$ocjena = round($ocjene/$total);

$res = mysql_query ("SELECT COUNT(sid) FROM eter_ocjena WHERE songid = '$now_id' AND sid = '$sid'")
or die ();
list ($done) = mysql_fetch_row($res);

mysql_close($dblink);

echo "{\"artist\":\"".$now_artist."\",\"song\":\"".$now_song."\",\"id\":\"".$now_id."\",\"ocjena\":\"".$ocjena."\",\"glasao\":\"".$done."\",\"image\":\"".$image."\",\"history\":[".$history."],\"time\":[".$time."],\"emisija\":\"$emisija\",\"slika\":\"$slika\",\"start\":\"$start\",\"end\":\"$end\"}";
?>