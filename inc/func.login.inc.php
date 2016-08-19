<?php
if (session_id() == "") {session_start();}
$sid = session_id();
$ref = explode("/", $_SERVER['HTTP_REFERER']);

//DO LOGIN
if (substr($ref[count($ref)-1], 0, 9) == "login.php" and $_REQUEST['username'] != "" and $_REQUEST['password'] != "")
{
	$user = mysql_real_escape_string($_REQUEST['username']);
	$pass = md5(mysql_real_escape_string($_REQUEST['password']));
	
	$res = mysql_query ("SELECT COUNT(id) FROM ".db_base.".users WHERE user = '$user' AND pass = '$pass'", $dblink)
	or die (mysql_error());
	list ($cusr) = mysql_fetch_row($res);

	if ($cusr <= 0)
	{
		header ("location: login.php?error=1");
	}
	else
	{
		mysql_query ("UPDATE ".db_base.".users SET sid = '$sid', lastlogin = NOW() WHERE user = '$user' AND pass = '$pass' LIMIT 1", $dblink)
		or die (mysql_error());
	}
}
else if ($ref[count($ref)-1] == "login.php" and ($_REQUEST['username'] == "" or $_REQUEST['password'] == ""))
{
	header ("location: login.php?error=1");	
}

//CHECK LOGIN
$res = mysql_query ("SELECT id, name FROM ".db_base.".users WHERE sid = '$sid' LIMIT 1", $dblink)
or die ("42: ".mysql_error());

if (mysql_num_rows($res) <= 0)
{
	header ("location: login.php");
}
?>