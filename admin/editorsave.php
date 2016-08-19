<?
include "conf.inc.php";

$dblink = dbconnect(db_host, db_user, db_psw);
mysql_select_db(db_base, $dblink);
mysql_set_charset('utf8', $dblink);

$pid = $_POST['editorid'];
$data = $_POST['editabledata'];

$end_fix = "<br />\n&nbsp;";

if (substr($data, -13) == $end_fix)
{
	$data = substr($data, 0, -13);	
}

mysql_query ("INSERT INTO sadrzaj (stranica, sadrzaj, datum) VALUES ('$pid', '$data', NOW())")
or die();

dbdisconnect($dblink);
?>