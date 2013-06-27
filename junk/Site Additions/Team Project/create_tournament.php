<?
session_start();

include("vars.php");
include("functions.php");
include("images.php");

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

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT status FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[status] == "active") {
                header("Location: ".$admindir."tournament.php");
                exit;
        } elseif ($row[status] == "pending") {
                header("Location: ".$admindir."start_tournament.php");
                exit;
        }
}

if (isset($_POST[c])) {
        $u_name = $_POST[name];
        $u_time = $_POST[time];
        $u_award = $_POST[award];
        $u_logs = $_POST[logs];
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
        $u_pass = $_POST[password];
        $u_status = "pending";
        $u_game = $_POST[game];
        $u_signups = "ON";
        if (!file_exists($uploaddir."tournaments/")) {
                mkdir($uploaddir."tournaments/", 0777);
        }
        if (!file_exists($uploaddir."tournaments/".str_replace(" ","_",$u_game))) {
                mkdir($uploaddir."tournaments/".strtolower(str_replace(" ","_",$u_game)), 0777);
        }
        $u_details = trim($_POST[details]);

        $sql = "SELECT * FROM tournaments WHERE game = '$u_game'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $check = 0;
        $check = mysql_num_rows($result);
        $game_num = $check + 1;
        $u_k = str_replace(" ","",strtolower($u_game));
        $u_key = $u_k.$game_num;
                                            //  id, t_name, t_key, logs, game, peeps, status
        $sql = "INSERT INTO tournaments VALUES ('', '$u_name', '$u_key', '$u_logs', '$u_game', 0, '$u_status')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
                                             //  id, t_name, t_key, description, award, time, teams, random, ppt, signups
        $sql = "INSERT INTO tourneystats VALUES ('', '$u_name', '$u_key', '$u_details', '$u_award', '$u_time', '$u_teams', '$u_random', '$u_ppt', '$u_signups')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        
        header("Location: ".$admindir."start_tournament.php");
        exit;
}

$header = "";
include($site_dir."top.html");
?>
<p align="center">
<font>
Create Tournament<br>
<div align="center">
<form method="post" action="<? echo $_SERVER[PHP_SELF]; ?>">
<input type="hidden" name="c" value="pending">
<table border="0" width="454px" cellspacing="3">
        <tr>
                <td width="50%" align="right">
                        <font>
                        Enter a spiffy name for the tournament:
                </td>
                <td width="50%" colspan="4">
                        <input type="text" name="name" size="28">
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        <font>
                        What game will this tournament take place on?:
                </td>
                <td width="50%" colspan="4">
                        <select size="1" name="game">
                        <?
                        $sql = "SELECT * FROM games";
                        $result = mysql_query($sql,$connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                echo "<option value=\"$row[key]\">$row[game]</option>\n";
                        }
                        ?>
                        </select>
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        <font>
                        If there is a time limit for matches, enter it here:
                        </font>
                </td>
                <td width="50%" colspan="4">
                        <font>
                        <input type="text" name="time" size="7"> Minutes
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        <font>
                        Select an award to give the winner:
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
                        Will it use logs?:
                </td>
                <td width="13%">
                        <font>
                        Yes
                </td>
                <td width="13%">
                        <input type="radio" value="TRUE" name="logs">
                </td>
                <td width="12%">
                        <font>
                        No
                </td>
                <td width="12%">
                        <input type="radio" value="FALSE" checked name="logs">
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        Teams or single battle?:
                </td>
                <td width="13%">

                        Teams
                </td>
                <td width="13%">
                        <input type="radio" name="teams" value="yes">
                </td>
                <td width="12%">
                        Single
                </td>

                <td width="12%">
                        <input type="radio" name="teams" value="no" checked>
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        Randomized or manual?:
                </td>
                <td width="13%">

                        Random
                </td>
                <td width="13%">
                        <input type="radio" name="random" value="yes">
                </td>
                <td width="12%">
                        Manual
                </td>

                <td width="12%">
                        <input type="radio" name="random" value="no" checked>
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        Enter players per team:
                </td>
                <td width="50%" colspan="4">
                        <input type="text" name="ppt" size="3">
                </td>
        </tr>
        <tr>
                <td width="50%" align="right">
                        <font>
                        Type in a description for the tournament, such as any special info or match styles. This is optional:
                </td>
                <td width="50%" colspan="4">
                        <textarea rows="4" name="details" cols="24">
                        </textarea>
                </td>
        </tr>
        <tr>
                <td width="100%" colspan="5">
                        <p align="center">
                        <input type="submit" value="Create Tournament" name="B1">
                        <input type="reset" value="Start Over" name="B2">
                </td>
        </tr>
</table>
</form>
</font>
</div>

<? include($site_dir."bottom.html"); ?>
