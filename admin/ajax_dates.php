<?
include "conf.inc.php";
include "../inc/functions.inc.php";

$dblink_ajax1 = dbconnect(db_host, db_user, db_psw);
mysql_select_db(db_base, $dblink_ajax1);
mysql_set_charset('utf8', $dblink_ajax1);

$editpage = $_REQUEST['editpage'];

$res = mysql_query ("SELECT datum FROM ".db_base.".sadrzaj WHERE stranica = '$editpage' ORDER BY datum DESC", $dblink_ajax1)
or die();
if (mysql_num_rows($res) <= 0)
{
	echo '<option value="0">Nema kreiranog sadržaja</option>';	
}
else
{
	echo getdates($res, $editdate);
}

dbdisconnect($dblink_ajax1);
?>