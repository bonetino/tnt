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

if ($_POST['add'] == "Dodaj" and $_REQUEST['emisija'] != "")
{
	$emisija = $_REQUEST['emisija'];
	$dan = $_REQUEST['dan'];
	$start = $_REQUEST['starth'].":".$_REQUEST['startm'].":00";
	if ($_REQUEST['endh'] == "00" and $_REQUEST['endm'] == "00")
	{
		$end = "23:59:59";
	}
	else
	{
		$end = $_REQUEST['endh'].":".$_REQUEST['endm'].":00";	
	}
	
	$filename = $_FILES['slika']['name'];
	$target = "emisije/".$filename; 
	
	if(!move_uploaded_file($_FILES['slika']['tmp_name'], $target)) 
	{
		echo "Postoji gre&scaron;ka pri uploadu slika!";
	}
	
	mysql_query ("INSERT INTO eter_emisije (naziv, slika, weekday, start, end) VALUES ('$emisija', '$filename', '$dan', '$start', '$end')")
	or die (mysql_error());
	
	header ("location:emisije.php");
}

if ($_REQUEST['action'] == "del")
{
	$id = $_REQUEST['id'];
	mysql_query ("DELETE FROM eter_emisije WHERE id = '$id' LIMIT 1")
	or die (mysql_error());
}
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
        <td height="100" align="center" valign="middle" bgcolor="#FF6633"><strong>Pregled emisija</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="80" align="center" valign="top"><form action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
          Naziv emisije 
          <label for="emisija"></label>
          <input type="text" name="emisija" id="emisija" style="width:250px;" />
          Slika 
          <label for="slika"></label>
          <input type="file" name="slika" id="slika" style="width:250px;" />
          <br />
          <br />
          Dan
<label for="dan"></label>
          <select name="dan" id="dan">
            <option value="1">Ponedjeljak</option>
            <option value="2">Utorak</option>
            <option value="3">Srijeda</option>
            <option value="4">Četvrtak</option>
            <option value="5">Petak</option>
            <option value="6">Subota</option>
            <option value="0">Nedjelja</option>
          </select>
          Početak 
          <label for="textfield2"></label>
          <select name="starth" id="starth">
          <?php
          for ($i=0; $i<24; $i++)
		  {
			  if ($i<10) {$i = "0".$i;}
			  echo "<option value=\"$i\">$i</option>";  
		  }
		  ?>
          </select>
          <select name="startm" id="startm">
          <?php
          for ($i=0; $i<60; $i++)
		  {
			  if ($i<10) {$i = "0".$i;}
			  echo "<option value=\"$i\">$i</option>";  
		  }
		  ?>
          </select> 
          Kraj
          <select name="endh" id="endh">
          <?php
          for ($i=0; $i<24; $i++)
		  {
			  if ($i<10) {$i = "0".$i;}
			  echo "<option value=\"$i\">$i</option>";  
		  }
		  ?>
          </select>
          <select name="endm" id="endm">
          <?php
          for ($i=0; $i<60; $i++)
		  {
			  if ($i<10) {$i = "0".$i;}
			  echo "<option value=\"$i\">$i</option>";  
		  }
		  ?>
          </select>
           &nbsp;
           <input type="submit" name="add" id="add" value="Dodaj" />
           <br />
        </form></td>
      </tr>
      <tr>
        <td align="left" valign="top">
<?php
$weekday = array("Nedjelja", "Ponedjeljak", "Utorak", "Srijeda", "Četvrtak", "Petak", "Subota");
$res = mysql_query ("SELECT id, naziv, start, end, weekday FROM eter_emisije ORDER BY weekday, start ASC")
or die (mysql_error());

$w = "";
$i = 1;
while (list ($id, $naziv, $start, $end, $day) = mysql_fetch_array($res))
{
	if ($w != $day)	
	{
		$i=1;
		$w = $day;
		echo "<br /><strong>".$weekday[$w]."</strong><br />";	
		echo "<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td width=\"50\" height=\"25\" align=\"left\" valign=\"middle\" bgcolor=\"#FF6633\"><strong>&nbsp;#</strong></td>
            <td width=\"100\" height=\"25\" align=\"left\" valign=\"middle\" bgcolor=\"#FF6633\"><strong>Početak</strong></td>
            <td width=\"100\" height=\"25\" align=\"left\" valign=\"middle\" bgcolor=\"#FF6633\"><strong>Kraj</strong></td>
            <td height=\"25\" align=\"left\" valign=\"middle\" bgcolor=\"#FF6633\"><strong>Emisija</strong></td>
			<td width=\"80\" height=\"25\" align=\"right\" valign=\"middle\" bgcolor=\"#FF6633\"><strong>Opcije&nbsp;</strong></td>
          </tr></table";
	}
	
	echo "<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		<tr>
            <td width=\"50\" height=\"25\" align=\"left\" valign=\"middle\">&nbsp;$i</td>
            <td width=\"100\" height=\"25\" align=\"left\" valign=\"middle\">".date("H:i", strtotime($start))."</td>
            <td width=\"100\" height=\"25\" align=\"left\" valign=\"middle\">".date("H:i", strtotime($end))."</td>
            <td height=\"25\" align=\"left\" valign=\"middle\">$naziv</td>
			<td width=\"80\" height=\"25\" align=\"right\" valign=\"middle\"><a href=\"emisije.php?action=del&id=$id\">Obriši</a>&nbsp;</td>
          </tr>
		  </table>";
	
	$i++;
}
?>        

          
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