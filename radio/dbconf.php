<?

$dblink = mysql_connect ("tntradio.ba", "tntradio_player", "?w+87b)_~3uk");

mysql_select_db("tntradio_player");

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

mysql_set_charset('utf8', $dblink);

?>