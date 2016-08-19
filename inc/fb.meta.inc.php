<?
if ($_REQUEST['page'] == "video" and $_REQUEST['action'] == "view")
{
	require_once 'google/src/Google_Client.php';
	require_once 'google/src/contrib/Google_YouTubeService.php';
	
	/* Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
	Google APIs Console <http://code.google.com/apis/console#access>
	Please ensure that you have enabled the YouTube Data API for your project. */
	$DEVELOPER_KEY = 'AIzaSyCqlTIhcV93jeUL1lghv5XbjJvTTW9Itl4';
	
	$client_view = new Google_Client();
	$client_view->setDeveloperKey($DEVELOPER_KEY);
	
	$youtube_view = new Google_YoutubeService($client_view);
	
	try 
	{
		$searchResponse_view = $youtube_view->videos->listVideos('statistics,contentDetails,snippet', array(
		'id' => $_REQUEST['id'],
		));
		
		
		$searchResult_view = $searchResponse_view['items'][0];
		
		$video_view['title'] = $searchResult_view['snippet']['title'];
		$video_view['description'] = $searchResult_view['snippet']['description'];
		$video_view['published'] = date("d.m.Y. H:i:s", strtotime($searchResult_view['snippet']['publishedAt']));
		//$video_view['thumb'] = $searchResult_view['snippet']['thumbnails']['maxres']['url'];
		$video_view['thumb'] = $searchResult_view['snippet']['thumbnails']['standard']['url'];
		$video_view['viewcount'] = $searchResult_view['statistics']['viewCount'];
		$video_view['likecount'] = $searchResult_view['statistics']['likeCount'];
		
		preg_match_all('/(\d+)/',$searchResult_view['contentDetails']['duration'],$parts_view);
		
		if (count($parts_view[0]) > 1)
		{
			$hours_view = floor($parts_view[0][0]/60);
			$minutes_view = $parts_view[0][0]%60;
			$seconds_view = $parts_view[0][1];
		}
		else
		{
			$hours_view = 0;
			$minutes_view = 0;
			$seconds_view = $parts_view[0][0];	
		}
		
		if (strlen($seconds_view) <= 1) {$seconds_view = "0".$seconds_view;}
		
		if ($hours_view != "00") {$time_view = $hours_view.":".$minutes_view.":".$seconds_view;}
		else if ($minute_views != "00") {$time_view = $minutes_view.":".$seconds_view;}
		else {$time_view = "0:".$seconds_view;}
		$video_view['duration'] = $time_view;
	} 
	catch (Google_ServiceException $e) 
	{
		echo htmlspecialchars($e->getMessage());
	}
	catch (Google_Exception $e) 
	{
		echo htmlspecialchars($e->getMessage());
	}
	
	/*
	<meta property='og:title' content='Kanal 6 - Kreativni svijet organizovao radionicu' />
	<meta property='og:url' content='<? echo 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]; ?>' />
	<meta property='og:description' content='Kanal 6 - Kreativni svijet organizovao radionicu. Podijelite ovaj video sa prijateljima na društvenim mrežama. Hvala.' />
	<meta property='og:image' content='http://i.ytimg.com/vi/N7yQPrYdn5g/hqdefault.jpg' />
	<meta property='og:type' content='video.other' />
	*/
	
	echo "<meta property='og:title' content='TNT Radio - ".$video_view['title']."' />
	<meta property='og:url' content='http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."' />
	<meta property='og:description' content='".$video_view['description']."' />
	<meta property='og:image' content='".$video_view['thumb']."' />
	<meta property='og:type' content='video.other' />";
	/*
	<meta property='fb:admins' content='1654943382'/>
	<meta property='fb:admins' content='764677417'/>";
	*/
}
else if ($_REQUEST['page'] == "vijest")
{
	$news = new news('tntradio', 'tr07052014');
	$news->id = $_REQUEST['id'];
	$res = $news->get();
	
	echo "<meta property='og:title' content='".$res["items"][0]["title"]."' />
<meta property='og:site_name' content='tntradio.ba'>
<meta property='og:url' content='http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."' />
<meta property='og:description' content='".$res["items"][0]["intro"]."' />
<meta property='og:image' content='http:".$res["items"][0]["images"][0]["items"][0]["original"]."' />
<meta property='og:type' content='article' />
";
}
else
{
	echo "<meta property='og:image' content='images/pagelogo.php' />
	<meta property='og:type' content='webpage' />";		
}
echo "
	<meta property='fb:app_id' content='627448830660812'/>";
?>