<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

$id = $_GET[id];

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT * FROM awards WHERE id = '$id'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $s = "SELECT * FROM images WHERE id = '$row[img_id]'";
        $r = @mysql_query($s,$connection) or die(mysql_error());
        while ($row2 = mysql_fetch_array($r)) {
                $image = $site_dir."awards/".$row2[filename];
                $name = $row2[name];
                $award_won = htmlspecialchars(nl2br($row2[misc]));
        }
        $award_info = htmlspecialchars(nl2br($row[notes]));
}

?>
<html>
<head>
<title>Award Information</title>
<style type="text/css">
        font {
                font-size: 9px;
                font-family: Verdana, sans-serif;
        }
</style>
</head>
<? echo "<body background=\"".$img_bluebg."\">"; ?>
<div align="left">
<table border="0" width="350" cellspacing="0" cellpadding="0" height="142">
        <tr>
                <td width="24%" height="66" align="center">
                        <table border="0" width="69%" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="14" height="15"><img border="0" src="<? echo $img_a_tl; ?>"></td>
                                        <td height="15" style="background-image: url('<? echo $img_a_top; ?>'); repeat-x;"></td>
                                        <td width="14" height="15"><img border="0" src="<? echo $img_a_tr; ?>"></td>
                                </tr>
                                <tr>
                                        <td width="14" height="23" style="background-image: url('<? echo $img_a_left; ?>'); repeat-y;"></td>
                                        <td height="23" style="background-image: url('<? echo $img_a_bg; ?>');">
                                                <center>
                                                <img src="<? echo $image; ?>">
                                                </center>
                                        </td>
                                        <td width="14" height="23" style="background-image: url('<? echo $img_a_right; ?>'); repeat-y;"></td>
                                </tr>
                                <tr>
                                        <td width="14"><img border="0" src="<? echo $img_a_bl; ?>" width="14" height="15"></td>
                                        <td height="15" style="background-image: url('<? echo $img_a_bottom; ?>'); repeat-x;">
                                        <td width="14"><img border="0" src="<? echo $img_a_br; ?>" width="14" height="15"></td>
                                </tr>
                        </table>
                </td>
                <td width="76%" height="66">
                        <table border="0" width="69%" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="14" height="15"><img border="0" src="<? echo $img_a_tl; ?>"></td>
                                        <td height="15" width="233" style="background-image: url('<? echo $img_a_top; ?>'); repeat-x;"></td>
                                        <td width="14" height="15"><img border="0" src="<? echo $img_a_tr; ?>"></td>
                                </tr>
                                <tr>
                                        <td width="14" height="23" style="background-image: url('<? echo $img_a_left; ?>'); repeat-y;"></td>
                                        <td width="233" style="background-image: url('<? echo $img_a_bg; ?>');">
                                        <font>
                                        <? echo "<b>".$name."</b> - ".$award_won; ?>
                                        </font>
                                        </td>
                                        <td width="14" height="23" style="background-image: url('<? echo $img_a_right; ?>'); repeat-y;"></td>
                                </tr>
                                <tr>
                                        <td width="14"><img border="0" src="<? echo $img_a_bl; ?>" width="14" height="15"></td>
                                        <td height="15" width="233" style="background-image: url('<? echo $img_a_bottom; ?>'); repeat-x;">
                                        <td width="14"><img border="0" src="<? echo $img_a_br; ?>" width="14" height="15"></td>
                                </tr>
                        </table>
                </td>
        </tr>
        <tr>
                <td colspan="2">
                        <table border="0" width="69%" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="14" height="15"><img border="0" src="<? echo $img_a_tl; ?>"></td>
                                        <td height="15" width="420" style="background-image: url('<? echo $img_a_top; ?>'); repeat-x;"></td>
                                        <td width="14" height="15"><img border="0" src="<? echo $img_a_tr; ?>"></td>
                                </tr>
                                <tr>
                                        <td width="14" height="23" style="background-image: url('<? echo $img_a_left; ?>'); repeat-y;"></td>
                                        <td height="23" style="background-image: url('<? echo $img_a_bg; ?>');">
                                        <font>
                                        <? echo $award_info; ?>
                                        </font>
                                        </td>
                                        <td width="14" height="23" style="background-image: url('<? echo $img_a_right; ?>'); repeat-y;"></td>
                                </tr>
                                <tr>
                                        <td width="14"><img border="0" src="<? echo $img_a_bl; ?>" width="14" height="15"></td>
                                        <td height="15" width="420" style="background-image: url('<? echo $img_a_bottom; ?>'); repeat-x;">
                                        <td width="14"><img border="0" src="<? echo $img_a_br; ?>" width="14" height="15"></td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
</div>
</body>
</html>
