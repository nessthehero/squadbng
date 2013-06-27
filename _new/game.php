<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "View the Squad's games";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if ((isset($_POST[g_id])) || (isset($_GET[g_id]))) {
        if (isset($_GET[actionification])) {
                if (!$_SESSION[username]) {
                        header("Location: ".$site_dir."game.php");
                        exit;
                }
                if (rank($_SESSION[username]) != "admin") {
                        header("Location: ".$site_dir."game.php");
                        exit;
                }
                switch ($_GET[actionification]) {
                case "edit":
                        header("Location: ".$admin_dir."games.php?edit_id=".$_GET[g_id]);
                        exit;
                case "del":
                        $sql = "DELETE FROM games WHERE id = '$_GET[g_id]'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        header("Location: ".$site_dir."game.php");
                }
        }
        //id, game, key, description, rec_method, method_name, site, banner, tourneys
        $sql = "SELECT * FROM games WHERE id = '$_POST[g_id]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                header("Location: ".$site_dir."game.php");
                exit;
        }
        while($row = mysql_fetch_array($result)) {
        
        $banner = $site_dir.$row[banner];
        $website = $row[site];
        $description = nl2br($row[description]);
        if (($row[rec_method] != null) && ($row[method_name] != null)) {
                switch ($row[rec_method]) {
                case "none":
                        $rec_method = "but does not have an available match recording method.";
                        $rec_notes = "";
                        break;
                case "log":
                        $rec_method = "and uses ".$row[method_name]."s as a match recording method.";
                        $rec_notes = "They can be viewed in a text editor.<br>";
                        break;
                case "game_file":
                        $rec_method = "and uses ".$row[method_name]."s as a match recording method.";
                        $rec_notes = "They require the game to view them.<br>";
                        break;
                case "file":
                        $rec_method = "and uses ".$row[method_name]."s as a match recording method.";
                        $rec_notes = "They can be viewed using a compatable program.<br>";
                        break;
                case "sound":
                        $rec_method = "and uses ".$row[method_name]."s as a match recording method.";
                        $rec_notes = "They can be played in any media player.<br>";
                        break;
                }
                $row[tourneys] != 1 ? $tourn_plural = "tournaments" : $tourn_plural = "tournament";
                $tournaments = "This game has had $row[tourneys] $tourn_plural fought on its battlegrounds.";
                $tournament_notes = "<br>
                This game is tournament capable $rec_method<br>
                $rec_notes<br>
                        
                $tournaments";
        } else {
                $tournament_notes = "<br>This game is considered incapable of hosting tournaments.";
        }
        }
        $page = "
<p align=\"center\">
<img border=\"0\" src=\"$banner\" width=\"345\" height=\"145\"></p>
<p align=\"center\"><a href=\"$website\">$website</a></p>
<div align=\"center\">
        <table border=\"0\" width=\"54%\" id=\"table1\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                        <td>
                        <p align=\"center\">$description</td>
                </tr>
        </table>
</div>
<center>
$tournament_notes<br><br>
";

$highest_game = highest_id("games");
$up = $_POST[g_id] + 1;
$down = $_POST[g_id] - 1;
if ($_POST[g_id] == 1) {
        $game_prev = "";
        $game_next = "<form method=\"post\" action=\"game.php\"><input type=\"hidden\" name=\"g_id\" value=\"$up\"><input type=\"submit\" value=\"Next Game\"></form>";
} elseif ($_POST[g_id] == $highest_game) {
        $game_prev = "<form method=\"post\" action=\"game.php\"><input type=\"hidden\" name=\"g_id\" value=\"$down\"><input type=\"submit\" value=\"Previous Game\"></form>";
        $game_next = "";
} else {
        $game_prev = "<form method=\"post\" action=\"game.php\"><input type=\"hidden\" name=\"g_id\" value=\"$down\"><input type=\"submit\" value=\"Previous Game\"></form>";
        $game_next = "<form method=\"post\" action=\"game.php\"><input type=\"hidden\" name=\"g_id\" value=\"$up\"><input type=\"submit\" value=\"Next Game\"></form>";
}

$page .= "
<table border=\"0\" width=\"90%\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
                <td width=\"174\" align=\"center\"><center>$game_prev</center></td>
                <td width=\"100%\">
                <div align=\"center\">";
                if (rank($_SESSION[username]) == "admin") {
                $page .= "
                        <table border=\"0\" width=\"70%\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                        <td>
                                        <center>
                                        <a href=\"".$admin_dir."games.php?edit_id=".$_POST[g_id]."\"><img src=\"".$img_editgame."\"></a><br><br>
                                        <a href=\"javascript:CheckDelete()\"><img src=\"".$img_delgame."\"></a>
                                        </center></td>
                                </tr>
                        </table>";
                }
                $page .= "
                </div>
                </td>
                <td align=\"center\"><center>
                $game_next
                </center></td>
        </tr>
</table>
        ";
} else {
        $games = array();
        $sql = "SELECT * FROM games";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $games[] = "<option value=\"$row[id]\">$row[game]</option>";
        }
        $page = "
<center><font>
Select a game:
<form method=\"post\" action=\"\">
<select size=\"1\" name=\"g_id\">
        ";
        for ($i = 0; $i <= (sizeof($games) - 1); $i++) {
                $page .= $games[$i];
        }
        $page .= "
</select><br><br>
<input type=\"submit\" value=\"Show me this game!\">
</form>
</font></center>
        ";
}

$header = "
<script language=\"javascript\">
function CheckDelete(game_id) {
        if (confirm('Are you certain you want to delete this game?')) {
                window.location = '".$site_dir."game.php?g_id=' + game_id + '&actionification=del'
        }
        else {
        
        }
}
</script>
";
include($root."inc/top.html");
echo $page;
$w3c = FALSE;
include($root."inc/bottom.html");
?>
