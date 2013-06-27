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
$page_title = "Tournament Pending";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (isset($_GET[change])) {
        switch ($_GET[change]) {
        case "roster":
                $sql[1] = "UPDATE squadmembers SET intourn = 'no' WHERE id = '$_GET[u_id]'";
                $sql[2] = "UPDATE tournaments SET peeps = peeps-1 WHERE status != 'complete'";
                for ($i = 1;$i <= 2; $i++) {
                        $result = @mysql_query($sql[$i],$connection) or die(mysql_error());
                }
                break;
        case "judges":
                $isjudge = array();
                $isjudge = $_POST[is_judge];
                $sql = "UPDATE squadmembers SET rank = 'squad' WHERE rank != 'admin'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                for ($i = 0; $i <= sizeof($isjudge); $i++) {
                        $u_id = $isjudge[$i];
                        $sql = "UPDATE squadmembers SET rank = 'judge' WHERE id = '$u_id' AND rank != 'admin'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                }
                break;
        }
}

$sql = "SELECT status FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[status] == "active") {
                header("Location: ".$admindir."tournament.php");
                exit;
        }
}

$sql = "SELECT * FROM tournaments WHERE status = 'pending'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_name, t_key, password, logs, game, peeps, status
while ($row = mysql_fetch_array($result)) {
        $key = $row[t_key];
        $peeps = $row[peeps];
        $game = $row[game];
        $logs = $row[logs];
}

$sql = "SELECT * FROM tourneystats WHERE t_key = '$key'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_name, t_key, description, teams, award, time, signups, bracket
while ($row = mysql_fetch_array($result)) {
        $name = $row[t_name];
        $description = nl2br($row[description]);
        $award = $row[award];
        $time = $row[time];
}

$sql = "SELECT * FROM games WHERE game = '$game'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, game, key, description, site, rating, banner, tourneys
while ($row = mysql_fetch_array($result)) {
        $banner = $row[banner];
}

if ($peeps == 0) {
        $peeps_msg = "Nobody has signed up yet.";
} elseif ($peeps == 1) {
        $peeps_msg = "There is 1 person signed up for this tourney.";
} else {
        $peeps_msg = "There are $peeps people signed up for this tourney.";
}

if ($peeps < $min_users) {
        $button_msg = "<input type=\"submit\" value=\"Begin Tournament\" name=\"start\" disabled=\"true\">";
} else {
        $button_msg = "<input type=\"submit\" value=\"Begin Tournament\" name=\"start\">";
}

if ($_POST[logs] == "yes") {
$logs_msg = "Logs are enabled";
}
$header = "<script language=\"javascript\">
function DeleteUser(username, u_id)
{
        if (confirm(\"Are you sure you want to remove \"+username+\" from the tournament?\"))
        {
                parent.location='start_tournament.php?change=roster&u_id='+u_id;
        }
}
</script>
";
include($site_dir."top.html");
?>
<p align="center">
<font face="Verdana" size="1" color="#E2C022">
There is a tournament pending...
</font>
</p>

<p align="center">
<font face="Verdana" size="1" color="#E2C022">
<? echo "<img src=\"$banner\" border=\"0\">"; ?>
</font>
</p>

<div align="center">
<table border="0" width="65%" cellspacing="6">
        <tr>
                <td width="100%">
                        <p align="center">
                        <font>
                        <? echo "$name"; ?>
                        </font>
                        </p>
                </td>
        </tr>
        <tr>
                <td width="100%">
                        <p align="center">
                        <font>
                        <? echo "$description"; ?>
                        </font>
                        </p>
                </td>
        </tr>
        <tr>
                <td width="100%">
                        <p align="center">
                        <font>
                        <? echo "$peeps_msg"; ?>
                        </font>
                        </p>
                </td>
        </tr>
        <tr>
                <td width="100%">
                        <table border="0" width="100%" cellspacing="1" cellpadding="0">
                                <tr>
                                        <td width="100%" colspan="2">
                                                <p align="center">
                                                <font>
                                                <u>
                                                Tourney Info
                                                </u>
                                                </font>
                                                </p>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="36%" align="right">
                                                <font>
                                                Award
                                                </font>
                                        </td>
                                        <td width="64%">
                                                <p align="center">
                                                <font>
                                                <?
                                                $sql = "SELECT * FROM images WHERE class = 'award' AND id = '$award'";
                                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                                while ($row = mysql_fetch_array($result)) {
                                                        echo "<img src=\"".$site_dir."awards/"."$row[filename]\" alt=\"$row[name] - $row[misc]\">";
                                                }
                                                ?>
                                                </font>
                                                </p>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="36%" align="right">
                                                <font>
                                                Time
                                                </font>
                                        </td>
                                        <td width="64%">
                                                <p align="center">
                                                <font>
                                                <? echo "$time"; ?> Minutes
                                                </font>
                                                </p>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="100%" colspan="2">
                                                <p align="center">
                                                <font>
                                                <? echo "$logs_msg"; ?>
                                                </font>
                                                </p>
                                        </td>
                                </tr>
                        </table>
                        </center>
                        <br>
                        <center>
                        <form method="POST" action="start_tournament.php?change=judges">
                        <input type="hidden" name="roster_edit" value="TRUE">
                        <table border="0" width="56%" cellspacing="1" cellpadding="0">
                                <tr>
                                        <td width="33%" align="center">
                                                <font>
                                                <b>
                                                Bracketname
                                                </b>
                                                </font>
                                        </td>
                                        <td width="33%" align="center">
                                                <font>
                                                <b>
                                                Judge
                                                </b>
                                                </font>
                                        </td>
                                        <td width="34%" align="center">
                                                <font>
                                                <b>
                                                Delete
                                                </b>
                                                </font>
                                        </td>
                                </tr>
                                <tr height="12px">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>
                                <?
                                $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        $u_id = $row[id];
                                        $uname = $row[username];
                                        echo "
                                <tr>
                                        <td width=\"33%\" align=\"center\">
                                                <font face=\"Verdana\" size=\"1\" color=\"#E2C022\">
                                                $uname
                                                </font>
                                        </td>
                                        <td width=\"33%\" align=\"center\">
                                                <input type=\"checkbox\" name=\"is_judge[]\" value=\"$u_id\">
                                        </td>
                                        <td width=\"34%\" align=\"center\">
                                                <input type=\"button\" value=\"Delete\" onClick=\"DeleteUser('$uname', '$u_id')\">
                                        </td>
                                </tr>
                                ";
                                }
                                ?>
                        </table>
                        <input type="submit" value="Set Judges">
                        </form>
                        </center>
                </td>
        </tr>
        <tr>
                <td width="100%">
                        <center>
                        <br>
                        <? echo "<form method=\"POST\" action=\"del_tourney.php?t_key=$key\">"; ?>
                        <input type="submit" value="Delete Tournament" name="delete">
                        </form>
                        <form method="POST" action="start.php">
                        <input type="hidden" value="<? echo $key; ?>" name="t_key">
                        <? echo "$button_msg"; ?>
                        </form>
                        </center>
                </td>
        </tr>
</table>
</div>
<? include($site_dir."bottom.html"); ?>
