<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

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
                        header("Location: ".$admin_dir."bracket.php");
                        exit;
                        break;
                case "teams":
                        header("Location: ".$admin_dir."teams.php");
                        exit;
                        break;
                case "active":
                        $continue = TRUE;
                        break;
        }
}

if (!$continue) {
        header("Location: ".$admin_dir."create_tournament.php");
        exit;
}

$key = get_key();
$award        = get_tourn_var($key, "award");
$time         = get_tourn_var($key, "time");
$signups      = get_tourn_var($key, "signups");
$t_name       = get_tourn_var($key, "name");
$description  = get_tourn_var($key, "description");
$game         = get_tourn_var($key, "game");
$status       = get_tourn_var($key, "status");
$match_type   = get_tourn_var($key, "match_type");
$bracket      = get_tourn_var($key, "bracket");
$ppt          = get_tourn_var($key, "ppt");
$random       = get_tourn_var($key, "random");
$teams        = get_tourn_var($key, "teams");

$sql = "SELECT banner FROM games WHERE game = '$game'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, game, key, description, site, banner, tourneys
while ($row = mysql_fetch_array($result)) {
        $banner = $site_dir.$row[banner];
}

$round = 1;
$sql = "SELECT * FROM matches WHERE t_key = '$key' ORDER BY match_id, box_id ASC";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_key, match_id, contender, score, box_id, round, done
while ($row = mysql_fetch_array($result)) {
        if ($row[box_id] == 1) {
                $p1 = $row[contender];
                $p1score = $row[score];
        } else {
                $p2 = $row[contender];
                $p2score = $row[score];
        
                if ($round < $row[round]) {
                        if ($uneven) {
                        $round_tbl[$round] .= "
                                <tr>
                                        <td colspan=\"3\">
                                        <center>
                                        ".team_name($u_person)." did not play in this round
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
                        $round = $row[round];
                }

                if (!$round_tbl[$round]) {
                $round_tbl[$round] = "
                <div align=\"center\">
                                <center>
                                <table border=\"1\" width=\"75%\">
                                <tr>
                                        <td colspan=\"3\">
                                                <center>Matches - Round $round</center></td>
                                </tr>
                ";
                }
                if ($p1score > $p2score) {
                        $p_1 = "<u><b>".team_name($p1)."</b></u>";
                        $p_2 = team_name($p2);
                } elseif ($p1score < $p2score) {
                        $p_1 = team_name($p1);
                        $p_2 = "<u><b>".team_name($p2)."</b></u>";
                } else {
                        $p_1 = team_name($p1);
                        $p_2 = team_name($p2);
                }
                $done = $row[done];
                if ($done == "YES") {
                        $score = "$p1score - $p2score";
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
                                        <td><center>".$p_1." versus ".$p_2."</center></td><td><center>$score</center></td>
                                        <td>
                                        <center>$done</center></td>
                                        </tr>
                        ";
                }
        }
}

if ($uneven) {
        $round_tbl[$round] .= "
                <tr>
                        <td colspan=\"3\">
                        <center>
                        ".team_name($u_person)." will sit out this round
                        </center>
                        </td>
                </tr>
                ";
}


$sql = "SELECT * FROM matches WHERE contender != 'UNEVEN' AND box_id = '2'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_key, play_1, play_2, p1score, p2score, log, t_round, done
while ($row = mysql_fetch_array($result)) {
        if ($row[done] == "NO") {
                $finish = "";
                break;
        } else {
                $finish = "<input type='submit' name='submit' value='Finish Round'>";
        }
}

$finish_round = "
<input type='hidden' name='action' value='round'>
<input type='hidden' name='round' value='$round'>
$finish
";

if (rank($_SESSION[username]) != "admin") {
        $kill_tourny = "";
} else {
        $kill_tourny = "
        <input type='hidden' name='action' value='delete'>
        <input type='hidden' name='t_name' value='$t_name'>
        <input type='submit' name='submit' value='Kill Tournament'>
        ";
}


$header = "";
include($root."inc/top.html");
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
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
