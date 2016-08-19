<?
ob_start();
include "conf.inc.php";
include "../inc/class.pagination.inc.php";
include "../inc/functions.inc.php";

session_start();
$_SESSION['FileBrowserIsAuthorized'] = true;

$dblink_xmltv = dbconnect(db_host_xmltv, db_user_xmltv, db_psw_xmltv);
mysql_select_db(db_base_xmltv, $dblink_xmltv);
mysql_set_charset('utf8', $dblink_xmltv);
$dblink = dbconnect(db_host, db_user, db_psw);
mysql_select_db(db_base, $dblink);
mysql_set_charset('utf8', $dblink);

include "../inc/func.login.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google" content="notranslate" />
<meta http-equiv="Content-Language" content="en" />
<title>TNT Radio</title>
<link href="../css/fonts/leaguegothic.css" rel="stylesheet" type="text/css" />
<link href="../css/blitzer/jquery-ui-1.9.2.custom.css" rel="stylesheet">
<link href="../css/magnific-popup.css" rel="stylesheet" >
<link href="../css/style.css" rel="stylesheet" >
<script src="../js/jquery-1.8.3.js"></script>
<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../js/i18n/jquery.ui.datepicker-bs.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script id="facebook-jssdk" src="//connect.facebook.net/en_GB/all.js#xfbml=1&appId=627448830660812"></script>
<script src="https://apis.google.com/js/platform.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<script>
function goto (url)
{
	window.location = url;	
}

function clock()
{
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth()+1;
	var Y = date.getFullYear();
	var H = date.getHours();
	var i = date.getMinutes();
	var s = date.getSeconds();
	
	if (H < 10)	{H = "0"+H;}
	if (i < 10)	{i = "0"+i;}
	if (s < 10)	{s = "0"+s;}
	
	$('#clock').text(d+"."+m+"."+Y+". - "+H+":"+i+":"+s);
	setTimeout("clock()", 1000);
}

CKEDITOR.stylesSet.add( 'my_styles',
[
	{ name : 'Naslov', element : 'span', attributes : { 'class': 'naslov' } },
	{ name : 'Podnaslov', element : 'span', attributes : { 'class' : 'podnaslov' } }
]);
CKFinder.setupCKEditor( null, 'ckfinder/' );
CKEDITOR.on( 'instanceCreated', function( event ) 
{
	var editor = event.editor,
	element = editor.element;

	editor.on( 'configLoaded', function() 
	{
		editor.config.language = 'hr';
		editor.config.removePlugins = 'colorbutton,find,flash,font,' +
				'forms,newpage,removeformat,' +
				'smiley,templates,stylesheetparser';
		
		editor.config.toolbar = [
		{ name: 'document', groups: [ 'document', 'inlinesave', 'clipboard', 'undo' ], items: [ 'Inlinesave', 'NewPage', '-', 'Cut', 'Copy', 'PasteText', '-', 'Undo', 'Redo' ] },
		{ name: 'links', groups: ['links', 'insert'], items: [ 'Link', 'Unlink', 'Anchor', '-', 'Image' , 'Table', 'HorizontalRule', 'SpecialChar', 'Iframe' ] },
		'/',
		{ name: 'styles', items: [ 'Styles' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'NumberedList', 'BulletedList' ] }
		];
		
		editor.config.stylesSet = 'my_styles';
	});
});

function getdates()
{
	var editpage = $('#edit').val();
	
	$.get( "ajax_dates.php?editpage="+editpage, function( data ) 
	{
	  $("#editdatum").html( data );
	});
}

$(document).ready(function() {
	clock();
});
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><table width="1026" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="250" align="left" valign="top"><img src="../images/header.png" width="1026" height="240" usemap="#Map" border="0" /></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="content_back"><table width="1026" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="23" height="10"><img src="../images/blah.gif" width="1" height="1" /></td>
            <td height="10"><img src="../images/blah.gif" width="1" height="1" /></td>
            <td width="23" height="10"><img src="../images/blah.gif" width="1" height="1" /></td>
            </tr>
          <tr>
            <td width="23"><img src="../images/blah.gif" width="1" height="1" /></td>
            <td><table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="720" align="left" valign="top"><form action="index.php" method="post" enctype="multipart/form-data" name="main_form" id="main_form">
                  <table width="720" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="content">Odaberite stranicu koju želite urediti 
                        <select name="edit" id="edit" onchange="getdates();">
                          <option value="radio" <? if (!isset($_REQUEST['edit']) or $_REQUEST['edit'] == "radio") {echo 'selected="selected"';} ?>>Radio</option>
                          <option value="produkcija" <? if ($_REQUEST['edit'] == "produkcija") {echo 'selected="selected"';} ?>>Produkcija</option>
                          <option value="osvoji" <? if ($_REQUEST['edit'] == "osvoji") {echo 'selected="selected"';} ?>>Osvoji</option>
                          <option value="oglasavanje" <? if ($_REQUEST['edit'] == "oglasavanje") {echo 'selected="selected"';} ?>>Oglašavanje</option>
                          <option value="kontakt" <? if ($_REQUEST['edit'] == "kontakt") {echo 'selected="selected"';} ?>>Kontakt</option>
                        </select>
                        od datuma 
                        <select name="editdatum" id="editdatum">
<?
$editpage = $_REQUEST['edit'];
$editdate = $_REQUEST['editdatum'];

if (!isset($_REQUEST['edit']))
{
	$editpage = 'kanal6';
}
else
{
	$editpage = $_REQUEST['edit'];	
}


$res = mysql_query ("SELECT datum FROM ".db_base.".sadrzaj WHERE stranica = '$editpage' ORDER BY datum DESC", $dblink)
or die();
if (mysql_num_rows($res) <= 0)
{
	echo '<option value="0">Nema kreiranog sadržaja</option>';	
}
else
{
	echo getdates($res, $editdate);
}
?>                        
                        </select>
                        <input type="submit" name="doedit" id="doedit" value="Uredi" /></td>
                    </tr>
                    <tr>
                      <td height="10"><img src="../images/blah.gif" alt="" width="1" height="1" /></td>
                    </tr>
                  </table>
<?
if ($_POST['doedit'])
{
	$where = "";
	if (isset($_REQUEST['editdatum']) and $_REQUEST['editdatum'] != 0)
	{
		$where = "AND datum = '".$_REQUEST['editdatum']."'";	
	}
	
	$res = mysql_query ("SELECT sadrzaj, datum FROM ".db_base.".sadrzaj WHERE stranica = '".$_REQUEST['edit']."' $where ORDER BY datum DESC LIMIT 1", $dblink)	
	or die(mysql_error());
	if (mysql_num_rows($res) <= 0)
	{
		echo '<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td class="content">
				  	<div id="'.$_REQUEST['edit'].'" class="editor" contenteditable="true">&nbsp;</div>
				  </td>
				</tr>
			  </table>';	
	}
	else
	{
		list ($sadrzaj, $datum) = mysql_fetch_row($res);
		echo '<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td class="content">
				  	<div id="'.$_REQUEST['edit'].'" class="editor" contenteditable="true">'.$sadrzaj.'</div>
				  </td>
				</tr>
			  </table>';		
	}
}
?>                  
                </form></td>
                <td width="10" align="left" valign="top"><img src="../images/blah.gif" alt="" width="1" height="1" /></td>
                <td width="250" align="left" valign="top"><? include "../mod_margina.php"; ?></td>
                </tr>
              </table></td>
            <td width="23"><img src="../images/blah.gif" width="1" height="1" /></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="39" align="left" valign="top"><img src="../images/content_footer.png" width="1026" height="39" /></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="1026" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="23" height="25" align="left" valign="middle">&nbsp;</td>
            <td height="25" align="left" valign="middle">&nbsp;</td>
            <td height="25" align="right" valign="middle">copyright &copy; Kanal 6, 2014.</td>
            <td width="23" height="25" align="left" valign="middle">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="popup">&nbsp;</div>
<map name="Map" id="Map">
  <area shape="poly" coords="814,6,819,6,822,11,824,20,824,30,824,40,823,45,855,42,854,33,851,23,848,15,844,8,838,2,831,1,823,1" href="http://www.facebook.com/pages/Kanal-6/311198915666229" target="new" alt="Facebook" />
  <area shape="poly" coords="859,6,864,6,867,11,868,18,869,27,868,35,868,45,899,42,899,34,896,25,893,15,888,8,883,3,874,1,867,1" href="http://twitter.com/Kanal6HD" target="new" alt="Twitter" />
  <area shape="poly" coords="902,6,906,7,910,11,911,18,912,27,911,37,911,45,943,42,942,34,940,23,935,13,929,5,921,1,912,1,907,2" href="http://www.youtube.com/user/Kanal6HD" target="new" alt="YouTube" />
</map>
</body>
</html>
<?
dbdisconnect($dblink);
dbdisconnect($dblink_xmltv);
ob_end_flush();
?>