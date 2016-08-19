<?php

ob_start();



//User Authentication

function find_manager($username, $password)

{

// check for username/password

  if ($username == "admin" and $password == "jasamja")

    return true;

  else

    return false;

} 



header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

header("Cache-Control: no-store, no-cache, must-revalidate");

header("Cache-Control: post-check=0, pre-check=0", false);

header("Pragma: no-cache");



// authenticate

session_start();



if (!isset($_SERVER['PHP_AUTH_USER']) || ($_POST['SeenBefore'] == 1 && $_POST['OldAuth'] == $_SERVER['PHP_AUTH_USER']))

{

    header('WWW-Authenticate: Basic realm="Unesite Vaše korisničko ime i lozinku"');

    header('HTTP/1.0 401 Nije dopušteno');

    echo "Morate unijeti valjano korisničko ime i lozinku da bi ste pristupili sistemu.\n";

    exit;

} 



if (find_manager($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) == false )

{

    echo "<form action='{$_SERVER['PHP_SELF']}' METHOD='post'>\n";

    echo "<input type='hidden' name='SeenBefore' value='1' />\n";

    echo "<input type='hidden' name='OldAuth' value='{$_SERVER['PHP_AUTH_USER']}' />\n";

    echo "<input type='submit' value='Pokusaj ponovo' />\n";

    echo "</form></p>\n";

    exit;

}



include "dbconf.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Radio TNT :: Emisije</title>

<style type="text/css">

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

body,td,th {

	font-size: 12px;

	font-family: Tahoma, Geneva, sans-serif;

}

</style>

</head>



<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td align="center" valign="top"><table width="800" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td height="100" align="center" valign="middle" bgcolor="#FF6633"><strong>Pregled ocjena</strong></td>

      </tr>

      <tr>

        <td align="left" valign="top">&nbsp;</td>

      </tr>

      <tr>

        <td align="left" valign="top">
        
        <table width="800" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="50" height="25" align="left" valign="middle" bgcolor="#FF6633"><strong>&nbsp;#</strong></td>

            <td height="25" align="left" valign="middle" bgcolor="#FF6633"><strong>Pjesma</strong></td>

            <td width="100" height="25" align="left" valign="middle" bgcolor="#FF6633"><strong>Broj glasova</strong></td>
            
            <td width="100" height="25" align="right" valign="middle" bgcolor="#FF6633"><strong>Ocjena</strong>&nbsp;</td>

         </tr>

<?php

$res = mysql_query ("SELECT id, songid, ocjena FROM eter_ocjena ORDER BY songid ASC")
or die (mysql_error());

$pjesme = array();
while (list ($id, $songid, $ocjena) = mysql_fetch_array($res))
{
	if ($songid != "")
	{
		$pjesme[$songid][] = $ocjena;
	}
}

$ocjene = array();
foreach(array_keys($pjesme) as $item)
{
	$t = 0;
	for ($i=0; $i<count($pjesme[$item]); $i++)
	{
		$t = $t+$pjesme[$item][$i];
	}
	$ocjene[$item]["prosjek"] = number_format($t/count($pjesme[$item]), 2, ",", "");
	$ocjene[$item]["ocjena"] = count($pjesme[$item]);
	$ocjene[$item]["izvodjac"] = ucwords(str_replace("_", " ", $item));
}
rsort($ocjene);

for ($i=0; $i<count($ocjene); $i++)
{
	echo "<tr>

            <td width=\"50\" height=\"25\" align=\"left\" valign=\"middle\">".($i + 1)."</td>

            <td height=\"25\" align=\left\" valign=\"middle\">".$ocjene[$i]["izvodjac"]."</td>

            <td width=\"100\" height=\"25\" align=\left\" valign=\"middle\">".$ocjene[$i]["ocjena"]."</td>
            
            <td width=\"100\" height=\"25\" align=\"right\" valign=\"middle\">".$ocjene[$i]["prosjek"]."&nbsp;</td>

         </tr>";
}

/*echo "<pre>";
print_r ($ocjene);
echo "</pre>";*/
?>        
</table>          

        </td>

      </tr>

    </table></td>

  </tr>

</table>

</body>

</html>

<?php

mysql_close($dblink);

ob_end_flush();

?>