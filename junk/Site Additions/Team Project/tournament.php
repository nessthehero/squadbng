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
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = rank($_SESSION[username]);
$page_title = "Tournament Status and Control Panel";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT status FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[status] == "active") {
                $continue = TRUE;
        }
        if ($row[status] == "pending") {
                header("Location: ".$admindir."start_tournament.php");
                exit;
        }
}
if (!$continue) {
header("Location: ".$admin_dir."create_tournament.php");
exit;
}
$sql = "SELECT * FROM tournaments WHERE status = 'active'";
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
        $t_name = $row[t_name];
        $description = $row[description];
        $award = $row[award];
        $time = $row[time];
}
$sql = "SELECT banner FROM games WHERE game = '$game'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, game, key, description, site, rating, banner, tourneys
while ($row = mysql_fetch_array($result)) {
        $banner = $row[banner];
}
$round = 1;
$sql = "SELECT * FROM matches WHERE t_key = '$key'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_key, play_1, play_2, p1score, p2score, log, t_round, done
while ($row = mysql_fetch_array($result)) {
        if ($round < $row[t_round]) {
        if ($uneven) {
        $round_tbl[$round] .= "
                <tr>
                        <td colspan=\"3\">
                        <center>
                        $u_person did not play in this round
                        </center>
                        </td>
                </tr>
                ";
                $uneven = FALSE;
        }
        $round_tbl[$round] .= "
        </table>
        </center>
        </div>
        <br>
        ";
        $round = $row[t_round];
        }

        if (!$round_tbl[$round]) {
        $round_tbl[$round] = "
        <div align=\"center\">
                  <center>
                  <table border=\"1\" width=\"50%\">
                    <tr>
                      <td colspan=\"3\">
                        <center>Matches - Round $round</center></td>
                    </tr>
        ";
        }
        $p1s = $row[p1score];
        $p2s = $row[p2score];
        if ($p1s > $p2s) {
                $p1 = "<u><b>".$row[play_1]."</b></u>";
                $p2 = $row[play_2];
        } elseif ($p1s < $p2s) {
                $p1 = $row[play_1];
                $p2 = "<u><b>".$row[play_2]."</b></u>";
        } else {
                $p1 = $row[play_1];
                $p2 = $row[play_2];
        }
        $done = $row[done];
        if ($done == "YES") {
                $score = "$p1s - $p2s";
                $done = "<font face=\"Verdana\" size=\"1\" color=\"#33CC33\"><b>DONE</b></font>";
        } else {
                $score = "0 - 0";
                $done = "<font face=\"Verdana\" size=\"1\" color=\"#FF0000\"><b>ACTIVE</b></font>";
        }
        if ($p2 === "UNEVEN") {
                $uneven = TRUE;
                $u_person = $p1;
        } else {
                $round_tbl[$round] .= "
                            <tr>
                              <td><center>$p1 versus $p2</center></td><td><center>$score</center></td>
                              <td>
                                <center>$done</center></td>
                            </tr>
                ";
        }
}
if ($uneven) {
        $round_tbl[$round] .= "
                <tr>
                        <td colspan=\"3\">
                        <center>
                        $u_person will sit out this round
                        </center>
                        </td>
                </tr>
                ";
}
$finish = "<input type='submit' name='submit' value='Finish Round'>";

$sql = "SELECT * FROM matches";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_key, play_1, play_2, p1score, p2score, log, t_round, done
while ($row = mysql_fetch_array($result)) {
if ($row[done] == "NO") {
        $finish = "";
}
}

$finish_round = "
<input type='hidden' name='action' value='round'>
<input type='hidden' name='round' value='$round'>
<input type='hidden' name='t_key' value='$key'>
$finish
";

if (rank($_SESSION[username]) != "admin") {
        $kill_tourny = "";
} else {
        $kill_tourny = "
        <input type='hidden' name='action' value='delete'>
        <input type='hidden' name='t_key' value='$key'>
        <input type='hidden' name='t_name' value='$t_name'>
        <input type='submit' name='submit' value='Kill Tournament'>
        ";
}


$header = "";
include($site_dir."top.html");
?>
<center>
                <h3><? echo "$t_name"; ?></h3>
                <p><img src="<? echo $banner; ?>"></p>
                Participants: <? echo "$peeps"; ?><br><br>

                <?
                $i = 1;
                while ($i <= $round) {
                echo $round_tbl[$i];
                $i++;
                }
                ?>
                </table>
                <br>
                <form method="POST" action="t_action.php">
                  <? echo $finish_round; ?>
                </form>

                <form method="POST" action="t_action.php">
                  <? echo $kill_tourny; ?>
                </form>

</center>
<? include($site_dir."bottom.html"); ?>
