<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = rank($_SESSION[username]);
$page_title = "Create a Tournament";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT status, t_key FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        switch ($row[status]) {
                case "pending":
                        header("Location: ".$admin_dir."start_tournament.php");
                        exit;
                break;
                case "bracket":
                        header("Location: ".$admin_dir."start.php");
                        exit;
                break;
                case "teams":
                        header("Location: ".$admin_dir."teams.php");
                        exit;
                break;
                case "active":
                        header("Location: ".$admin_dir."tournament.php");
                        exit;
                break;
                case "finished":
                break;
                default:
                break;
        }
}

if (isset($_POST[c])) {
        $u_name = $_POST[name];
        $u_game = $_POST[game];
        $u_matchtype = $_POST[match_type];
        switch ($u_matchtype) {
        case "time":
                $u_mtype = "time";
                $u_time = $_POST[time];
                break;
        case "elim":
                $u_mtype = "elim";
                $u_time = 0;
                break;
        }
        $u_awardtype = $_POST[award_type];
        switch ($u_awardtype) {
        case "none":
                $u_award = "";
                break;
        case "trophy":
                $u_award = $_POST[award];
                break;
        case "custom":
                $u_award = $_POST[custom];
                break;
        }
        if ($_POST[teams] == "yes") {
                $u_teams = "yes";
                if ($_POST[random] == "yes") {
                        $u_random = "yes";
                        $u_ppt = $_POST[ppt];
                        if ($u_ppt <= 0) {
                                $u_ppt = 2;
                        }
                } else {
                        $u_random = "no";
                        $u_ppt = 0;
                }
        } else {
                $u_teams = "no";
                $u_random = "no";
                $u_ppt = 0;
        }
        $u_bracket = $_POST[bracket_structure];
        $u_status = "pending";
        $u_signups = "ON";
        
        if (!file_exists($uploaddir."tournaments/")) {
                mkdir($uploaddir."tournaments/", 0777) or die("Couldn't make tournament directory");
        }
        if (!file_exists($uploaddir."tournaments/".strtolower($u_game))) {
                mkdir($uploaddir."tournaments/".strtolower($u_game), 0777) or die("Couldn't make tournament game directory");
        }
        $u_details = trim($_POST[details]);

        $sql = "SELECT * FROM tournaments WHERE game = '$u_game'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $check = 0;
        $check = mysql_num_rows($result);
        $game_num = $check + 1;
        $u_k = str_replace(" ","",strtolower($u_game));
        $u_key = $u_k.$game_num;
                                            //  id, t_key, t_name, description, game, status
        $sql = "INSERT INTO tournaments VALUES ('', '$u_key', '$u_name', '$u_details', '$u_game', '$u_status')";
        @mysql_query($sql,$connection) or die(mysql_error());
                                             //  id, t_key, award, time, signups
        $sql = "INSERT INTO t_stats VALUES ('', '$u_key', '$u_award', '$u_time', '$u_signups')";
        @mysql_query($sql,$connection) or die(mysql_error());
                                             // id, t_key, teams, random, ppt, bracket, match_type
        $sql = "INSERT INTO t_options VALUES ('', '$u_key', '$u_teams', '$u_random', '$u_ppt', '$u_bracket', '$u_mtype')";
        @mysql_query($sql,$connection) or die(mysql_error());
        
        header("Location: ".$admin_dir."start_tournament.php");
        exit;
}

$header = "

";
include($root."inc/top.html");
?>
<script language="javascript">

function obj(id) {
	if (document.getElementById) { return document.getElementById(id); }
	if (document.all) { return document.all[id]; }
	if (document.layers) { return document.layers[id]; }	
	return null;	
}

function hideDiv(id) {

	var div = obj(id);
	
	div.style.visibility = "hidden";
	
}

function showDiv(id) {

	var div = obj(id);
	
	div.style.visibility = "visible";
	
}

</script>
<p align="center">
<font>Create Tournament</font><br>

<div align="center">
<form method="post" action="/admin/create_tournament.php" name="creation">
        <input type="hidden" name="c" value="pending">
        <table border="0" width="454px" cellspacing="3">
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Enter a spiffy name for the tournament:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <input type="text" name="name" size="28">
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                What game will this tournament take place on?:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <select size="1" name="game">
                                <?
                                        $sql = "SELECT * FROM games";
                                        $result = mysql_query($sql,$connection) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                                echo "
                                                <option value=\"$row[g_key]\">$row[game]</option>\n";
                                        }
                                ?>
                                </select>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Timed matches or elimination?
                                </font>
                        </td>
                        <td width="13%">
                                <center>
                                <font>
                                Timed
                                </font>
                                </center>
                        </td>
                        <td width="13%">
                                <center>
                                <input type="radio" name="match_type" value="time" checked onclick="showDiv(timed);">
                                </center>
                        </td>
                        <td width="12%">
                                <font>
                                Elimination
                                </font>
                        </td>
                        <td width="12%">
                                <center>
                                <input type="radio" name="match_type" value="elim" onclick="hideDiv(timed);">
                                </center>
                        </td>
                </tr>
				<div id="timed" style="visibility: hidden;">
                <tr>
                        <td width="50%" align="right">
                                <font>
                                If there is a time limit for matches, enter it here:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <font>
                                <input type="text" name="time" size="7"> Minutes
                                </font>
                        </td>
                </tr>
				</div>
                <tr>
                        <td width="50%" align="right" rowspan="3">
                                <font>
                                What type of award will be given?
                                </font>
                        </td>
                        <td width="25%" colspan="2">
                                <input type="radio" name="award_type" value="none" checked>
                        </td>
                        <td width="25%" colspan="2">
                                <font>
                                No award given
                                </font>
                        </td>
                </tr>
                <tr>
                        <td width="25%" colspan="2">
                                <input type="radio" name="award_type" value="trophy">
                        </td>
                        <td width="25%" colspan="2">
                                <font>
                                Trophy in Profile
                                </font>
                        </td>
                </tr>
                <tr>
                        <td width="25%" colspan="2">
                                <input type="radio" name="award_type" value="custom">
                        </td>
                        <td width="25%" colspan="2">
                                <font>
                                Custom award
                                </font>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Describe the custom award:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <textarea rows="4" name="custom" cols="24"></textarea>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Select a trophy to give the winner:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <select size="1" name="award">
                                <?
                                        $sql = "SELECT * FROM images WHERE class = 'award' AND misc_2 = '1'";
                                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                                echo "<option value=\"$row[id]\">$row[name]</option>\n";
                                        }
                                        if (mysql_num_rows($result) == 0) {
                                                echo "<option>There are no trophies uploaded.</option>\n";
                                        }
                                ?>
                                </select>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Teams or single battle?:
                                </font>
                        </td>
                        <td width="13%">
                                <font>
                                Teams
                                </font>
                        </td>
                        <td width="13%">
                                <input type="radio" name="teams" value="yes">
                        </td>
                        <td width="12%">
                                <font>
                                Single
                                </font>
                        </td>
                        <td width="12%">
                                <input type="radio" name="teams" value="no" checked>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Structured bracket or Randomized matches?
                                </font>
                        </td>
                        <td width="13%">
                                <font>
                                Structure
                                </font>
                        </td>
                        <td width="13%">
                                <input type="radio" name="bracket_structure" value="yes">
                        </td>
                        <td width="12%">
                                <font>
                                Random
                                </font>
                        </td>
                        <td width="12%">
                                <input type="radio" name="bracket_structure" value="no" checked>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Randomized teams or manual selection?:
                                </font>
                        </td>
                        <td width="13%">
                                <font>
                                Random
                                </font>
                        </td>
                        <td width="13%">
                                <input type="radio" name="random" value="yes">
                        </td>
                        <td width="12%">
                                <font>
                                Manual
                                </font>
                        </td>
                        <td width="12%">
                                <input type="radio" name="random" value="no" checked>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Enter players per team:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <input type="text" name="ppt" size="3">
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font>
                                Type in a description for the tournament, such as any special info or match styles. This is optional:
                                </font>
                        </td>
                        <td width="50%" colspan="4">
                                <textarea rows="12" name="details" cols="29"></textarea>
                        </td>
                </tr>
                <tr>
                        <td width="100%" colspan="5">
                                <center>
                                <br><br>
                                <input type="submit" value="Create Tournament"><input type="reset" value="Start Over">
                                </center>
                        </td>
                </tr>
        </table>
</form>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
