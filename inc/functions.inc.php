<?php
function getytpagetokens($totalpages, $perpage)
{
	//get existing tokens
	$filename = "cache/yttokens.dat";
	if (file_exists($filename))
	{
		$tokens = explode(PHP_EOL, file_get_contents($filename));
	}
	else
	{
		$tokens = array();	
	}
	$numoftokens = count($tokens);
	
	require_once 'google/src/Google_Client.php';
	require_once 'google/src/contrib/Google_YouTubeService.php';
	$DEVELOPER_KEY = 'AIzaSyCqlTIhcV93jeUL1lghv5XbjJvTTW9Itl4';
	
	$client = new Google_Client();
	$client->setDeveloperKey($DEVELOPER_KEY);
	
	$youtube = new Google_YoutubeService($client);
	
	if ($numoftokens == 0)
	{	
		$nexttoken = 1;
		$newtokens = array();
		$newtoken[0] = "";
		while (!empty($nexttoken))
		{
			try 
			{
				if ($nexttoken == 1)
				{
					$searchResponse = $youtube->search->listSearch('id', array(
					'channelId' => 'UCbdEi6OeBA-xNz8mufpIrIQ',
					'maxResults' => $perpage,
					'order' => 'date',
					));	
				}
				else
				{
					$searchResponse = $youtube->search->listSearch('id', array(
					'channelId' => 'UCbdEi6OeBA-xNz8mufpIrIQ',
					'maxResults' => $perpage,
					'order' => 'date',
					'pageToken' => $nexttoken,
					));
				}
				
				if (isset($searchResponse['nextPageToken'])) 
				{
					$nexttoken = $searchResponse['nextPageToken'];
					$newtokens[] = $nexttoken;
				}
				else
				{
					$nexttoken = NULL;
				}
			} 
			catch (Google_ServiceException $e) 
			{
				echo htmlspecialchars($e->getMessage());
			}
			catch (Google_Exception $e) 
			{
				echo htmlspecialchars($e->getMessage());
			}
		}
	}
	else
	{
		$nexttoken = $tokens[count($tokens)-1];
		$newtokens = $tokens;

		while (count($tokens) >= $totalpages)
		{
			try 
			{
				$searchResponse = $youtube->search->listSearch('id', array(
				'channelId' => 'UCbdEi6OeBA-xNz8mufpIrIQ',
				'maxResults' => $perpage,
				'order' => 'date',
				'pageToken' => $nexttoken,
				));
				
				if (isset($searchResponse['nextPageToken'])) 
				{
					$nexttoken = $searchResponse['nextPageToken'];
					$newtokens[] = $nexttoken;
				}
			} 
			catch (Google_ServiceException $e) 
			{
				echo htmlspecialchars($e->getMessage());
			}
			catch (Google_Exception $e) 
			{
				echo htmlspecialchars($e->getMessage());
			}
		}	
	}
	
	/*echo "<pre>";
	print_r($newtokens);
	echo "</pre>";*/
}

function getdates ($res, $date)
{
	$options = '';
	while (list($d) = mysql_fetch_array($res))	
	{
		if ($d == $date)
		{
			$options .= '<option value="'.$d.'" selected="selected">'.date("d.m.Y. H:i:s", strtotime($d)).'</option>';
		}
		else
		{
			$options .= '<option value="'.$d.'">'.date("d.m.Y. H:i:s", strtotime($d)).'</option>';
		}
	}
	
	return $options;
}
?>