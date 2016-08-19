<?php
error_reporting(0);

date_default_timezone_set('Europe/Sarajevo');

//$xml = simplexml_load_file('NowOnAir.xml');

$xml = simplexml_load_file('http://tntradio.ba/eter/NowOnAir.xml');

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
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.parseXML demo</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
 
<p id="someElement"><?php echo "$now_song";?></p>
<p id="anotherElement">fdjfdifd</p>
 

 
</body>
</html>