<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "Downloads";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if ($_POST[uploading] == "yes") {
        @move_uploaded_file($_FILES[download][tmp_name],$dl_uploads.$_FILES[download][name]) or die("Couldn't move file");
        $sql = "INSERT INTO downloads VALUES ('', '".$dl_dir.$_FILES[download][name]."', '".$_FILES[download][name]."', '".$_POST[catagory]."', '".$_POST[desc]."', '".$_POST[game]."')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$_SERVER[PHP_SELF]);
        exit;
}

if ($_GET[del]) {
        $sql = "SELECT name FROM downloads WHERE id = '$_GET[del]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                @unlink($dl_dir.$row[name]) or die("Couldn't delete file");
        }

        $sql = "DELETE FROM downloads WHERE id = '$_GET[del]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$_SERVER[PHP_SELF]);
        exit;
}

$count = 0;
$sql = "SELECT * FROM downloads WHERE cat = 'wall'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($count == 3) {
                $wall_block .= "<br>\n";
                $count = 0;
        }
        $wall_block .= "<a href=\"".$row[src]."\"><img width=\"130px\" height=\"100px\" src=\"".$row[src]."\" ALT=\"\"></a>\n";
        if (rank($_SESSION[username]) == "admin") {
                $wall_block .= "<a href=\"http://www.squadbng.com/downloads.php?del=$row[id]\" title=\"Delete this wallpaper?\">del</a>";
        }
        $count++;
}

$count = 0;
$sql = "SELECT * FROM downloads WHERE cat = 'game' ORDER BY misc, description";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($count == 0) {
                $game_block .= "<table border=\"1\" cellpadding=\"3\" cellspacing=\"0\">";
        }
        $game_temp = $row[misc];
        if ($game != $game_temp) {
                $game = $game_temp;
                $game_block .= "<tr><td colspan=\"3\"><center>$row[misc]</center></td></tr>\n";
        }

        $file_size = stat($dl_uploads.$row[name]);
        $size = number_format($file_size[7] / 1024, 2, '.', ',');

        if (rank($_SESSION[username]) == "admin") {
                $delete_link = "--[<a href=\"http://www.squadbng.com/downloads.php?del=$row[id]\" title=\"Delete this download?\">del</a>]";
        }
        $game_block .= "
        \t<tr>
        \t\t<td><center><a href=\"".$row[src]."\">".$row[name]."</a>$delete_link</center></td>
        \t\t<td><center>".$row[description]."</center></td>
        \t\t<td><center>".$size." KB</center></td>
        \t</tr>
         ";

         $count++;

}
if ($count != 0) {
        $game_block .= "</table>";
}

$count = 1;
$sql = "SELECT * FROM downloads WHERE cat = 'misc'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($count == 1) {
                $misc_block .= "<table border=\"1\" cellpadding=\"3\" cellspacing=\"0\">";
        }

        $size = number_format(filesize($dl_uploads.$row[name]) / 1024, 2, '.', ',');
        if (rank($_SESSION[username]) == "admin") {
                $delete_link = "--[<a href=\"http://www.squadbng.com/downloads.php?del=$row[id]\" title=\"Delete this download?\">del</a>]";
        }
        $misc_block .= "
        \t<tr>
        \t\t<td><center><a href=\"".$row[src]."\">".$row[name]."</a>$delete_link</center></td>
        \t\t<td><center>".$row[description]."</center></td>
        \t\t<td><center>".$size." KB</center></td>
        \t</tr>
         ";
         $count++;

}
if ($count != 0) {
        $misc_block .= "</table>";
}

if (rank($_SESSION[username]) == "admin") {

        $sql = "SELECT game FROM games ORDER BY game";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $game_options .= "\t<option>".$row[game]."</option>\n";
        }

        $add_download = "
<center>
<form method=\"POST\" action=\"downloads.php\" enctype=\"multipart/form-data\">
        <input type=\"hidden\" name=\"uploading\" value=\"yes\">
        <table border=\"0\" width=\"435\" cellspacing=\"4\" cellpadding=\"0\">
                <tr>
                        <td width=\"202\" align=\"right\">
                                Select file to upload
                        </td>
                        <td width=\"229\">
                                <input type=\"file\" name=\"download\">
                        </td>
                </tr>
                <tr>
                        <td width=\"202\" align=\"right\">
                                Select catagory for file. Wallpapers must be an image.
                        </td>
                        <td width=\"229\">
                                <select size=\"1\" name=\"catagory\">
                                        <option value=\"null\" selected>Select a catagory</option>
                                        <option value=\"wall\">Wallpaper</option>
                                        <option value=\"game\">Game</option>
                                        <option value=\"misc\">Misc</option>
                                </select>
                        </td>
                </tr>
                <tr>
                        <td width=\"202\" align=\"right\">
                                If catagory is a game, please select the game.
                        </td>
                        <td width=\"229\">
                                <select size=\"1\" name=\"game\">
                                        $game_options
                                </select>
                        </td>
                </tr>
                <tr>
                        <td width=\"202\" align=\"right\">
                                Type a description of the download. (not for wallpapers)
                        </td>
                        <td width=\"229\">
                                <textarea rows=\"5\" name=\"desc\" cols=\"42\"></textarea>
                        </td>
                </tr>
                <tr>
                        <td colspan=\"2\" width=\"433\">
                                <center>
                                <input type=\"submit\" value=\"Submit\">
                                <input type=\"reset\" value=\"Reset\">
                                </center>
                        </td>
                </tr>
        </table>
</form>
</center>
";
} else {
        $add_download = "";
}
$header = "";
include($root."inc/top.html");
?>
<div align="center">
<center>
<table border="0" width="74%" cellspacing="0" cellpadding="0">
        <tr>
                <td width="100%">
                        <center>
                        <b><u>Wallpapers</u></b><br><br>
                        </center>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="100%">
                                                <center>
                                                <? echo $wall_block; ?>
                                                </center>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
</center>
</div>
<div align="center">
<center>
<table border="0" width="74%" cellspacing="0" cellpadding="0">
        <tr>
                <td width="100%">
                        <center>
                        <br><b><u>Game Additions</u></b><br><br>
                        </center>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="100%">
                                                <center>
                                                <? echo $game_block; ?>
                                                </center>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
</center>
</div>
<div align="center">
<center>
<table border="0" width="74%" cellspacing="0" cellpadding="0">
        <tr>
                <td width="100%">
                        <center>
                        <br><b><u>Misc.</u></b><br><br>
                        </center>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                        <td width="100%">
                                                <center>
                                                <? echo $misc_block; ?>
                                                </center>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
</center>
</div>
<br>
<br>
<center><? echo $add_download; ?></center>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
