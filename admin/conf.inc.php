<?
//////////////////////////////////////////////////////
//  MYSQL	 										//
//////////////////////////////////////////////////////

define(db_host, "tntradio.ba");						// database host
define(db_base, "tntradio_stranica");					// database name
define(db_user, "tntradio_page");					// database user
define(db_psw, "a36dz3h5pfl2");						// database password

define(db_host_xmltv, "tntradio.ba");					// database host
define(db_base_xmltv, "tntradio_player");				// database name
define(db_user_xmltv, "tntradio_player");				// database user
define(db_psw_xmltv, "?w+87b)_~3uk");					// database password

define(apiuser, "tntradio");
define(apipass, "tr04052014");

$days = array("Ponedjeljak", "Utorak", "Srijeda", "Četvrtak", "Petak", "Subota", "Nedjelja");

date_default_timezone_set('Europe/Sarajevo');

function dbconnect($db_host, $db_user, $db_psw)
{
  $dblink = mysql_connect($db_host, $db_user, $db_psw)
    or die("Could not connect to");
  
  //mysql_select_db($db_base)
  //or die("Could not select database");
    
  return $dblink;
}

//Database DISCONNECT
function dbdisconnect($dblink)
{
  mysql_close($dblink);
}

if (function_exists('mysql_set_charset') === false) 
{
   /**
	* Sets the client character set.
	*
	* Note: This function requires MySQL 5.0.7 or later.
	*
	* @see http://www.php.net/mysql-set-charset
	* @param string $charset A valid character set name
	* @param resource $link_identifier The MySQL connection
	* @return TRUE on success or FALSE on failure
	*/
   function mysql_set_charset($charset, $link_identifier = null)
   {
	   if ($link_identifier == null) {
		   return mysql_query('SET CHARACTER SET "'.$charset.'"');
	   } else {
		   return mysql_query('SET CHARACTER SET "'.$charset.'"', $link_identifier);
	   }
   }
}
?>