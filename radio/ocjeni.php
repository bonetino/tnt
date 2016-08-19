<?
error_reporting(-1);
include "dbconf.php";

if (session_id() == "")
{
	session_start();
}

$sid = session_id();

$songid = $_POST['songid'];
$ocjena = $_POST['ocjena'];

mysql_query ("INSERT INTO eter_ocjena (songid, ocjena, sid) VALUES ('$songid', '$ocjena', '$sid')")
or die ();

$res = mysql_query ("SELECT COUNT(songid) FROM eter_ocjena WHERE songid = '$songid' AND sid = '$sid'")
or die ();
list ($total) = mysql_fetch_row($res);

if ($total > 1)
{
	$rem = $total - 1;
	mysql_query ("DELETE FROM eter_ocjena WHERE songid = '$songid' AND sid = '$sid' LIMIT $rem")	
	or die ();
}

mysql_close($dblink);
?>