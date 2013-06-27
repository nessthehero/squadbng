<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "bngwars";
$level = "squad";
$page_title = "Welcome to BnG Wars!";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$t = FALSE;
$sql = "SELECT status FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[status] != "finished") {
                $t = TRUE;
        }
}

if ($t) {

        $key = get_key();
        $award        = get_tourn_var($key, "award");
        $time         = get_tourn_var($key, "time");
        $signups      = get_tourn_var($key, "signups");
        $t_name       = get_tourn_var($key, "name");
        $description  = nl2br(trim(stripslashes(get_tourn_var($key, "description"))));
        $game         = get_tourn_var($key, "game");
        $status       = get_tourn_var($key, "status");
        $match_type   = get_tourn_var($key, "match_type");
        $bracket      = get_tourn_var($key, "bracket");
        $ppt          = get_tourn_var($key, "ppt");
        $random       = get_tourn_var($key, "random");
        $teams        = get_tourn_var($key, "teams");

        $sql = "SELECT banner FROM games WHERE g_key = '$game'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        // id, game, key, description, site, rating, banner, tourneys
        while ($row = mysql_fetch_array($result)) {
                $banner = $row[banner];
        }

        $time == 0 ? "No time limit" : $time." minutes";

        if (is_numeric($award)) {
                $sql = "SELECT * FROM images WHERE class = 'award' AND id = '$award'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $award_filename = $row[filename];
                        $award_name = $row[name];
                        $award_description = $row[misc];
                }

                $award_disp = "<img src=\"".$site_dir."awards/"."$award_filename\" alt=\"$award_name - $award_description\">";
        } else {
                $award_disp = nl2br($award);
        }

        switch ($match_type) {
                case "time":
                        $time_msg = "Timed matches with a length of $time minutes";
                        break;
                case "elim":
                        $time_msg = "All matches are based on elimination. See description for kill limit";
                        break;
        }

        switch ($bracket) {
                case "yes":
                        $match_msg = "Matches are on a structured bracket.";
                        break;
                case "no":
                        $match_msg = "Matches are randomized every round.";
                        break;
        }

        if (peeps() == 0) {
                $peeps_msg = "Nobody has signed up yet.";
        } elseif (peeps() == 1) {
                $peeps_msg = "There is 1 person signed up for this tourney.";
        } else {
                $peeps_msg = "There are ".peeps()." people signed up for this tourney.";
        }

        if (logs(preg_replace("/[0-9]/", "", $key)) == "yes") {
                $logs = TRUE;
                $sql = "SELECT * FROM logs WHERE t_key = '$key'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $log_location = $row[location];
                }
                $sql = "SELECT method_name FROM games WHERE game = '$game'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $log_name = strtoupper($row[method_name]);
                }
        }


        $sql = "SELECT * FROM rules WHERE game = '$game'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        $inc = 1;
        while ($row = mysql_fetch_array($result)) {
                $rule = nl2br($row[rule]);
                $rules .= "
                        <table width=\"100%\">
                                <tr>
                                        <td>
                                                <center>
                                                [$inc]
                                                </center>
                                        </td>
                                        <td>
                                        </td>
                                </tr>
                                </tr>
                                        <td>
                                        </td>
                                        <td>
                                                <font>
                                                <p style=\"text-indent: 30\" align=\"left\">
                                                $rule
                                                </p>
                                                </font>
                                        </td>
                                </tr>
                        </table>
                ";
                $inc++;
        }
        if (mysql_num_rows($result) == 0) {

                $rules = "<br><br><center><font> There are no rules for this game </font></center>";

        }


        $status = "";

        $sql = "SELECT status FROM tournaments WHERE status != 'finished'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $status = $row[status];
        }

        $round_roster = "";

        switch ($status) {
                case "pending":
                                                 
                        if ($signups == "ON") {
                                $the_button = "<a href=\"signup.php\">[Click here to Sign Up!]</a>";
                        }
                
                        $the_roster = "
                        <br><br>
                        <table class=\"ranktable\" width=\"100px\">
                                <tr>
                                        <td align=\"center\">
                                                <u>Roster</u>
                                        </td>
                                </tr>
                        ";
                
                        $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
                        $result = @mysql_query($sql, $connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                $class = $row[rank];
                                $the_roster .= "
                                <tr>
                                        <td class=\"$class\" align=\"center\">
                                                ".$row[username]."
                                        </td>
                                <tr>
                                ";
                        }
                        
                        $the_roster .= "
                        </table>
                        ";

                        $show_t_info = TRUE;
                
                       break;
                case "bracket":
        
                        $sql = "SELECT * FROM matches WHERE t_key = '$key' ORDER BY match_id, box_id";
                        //id, t_key, match_id, contender, score, box_id, round, done
                        $result = @mysql_query($sql, $connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                if ($row[box_id] == 1) {
                                        $p1 = team_name($row[contender]);
                                } else {
                                        $p2 = team_name($row[contender]);
                                        if ($p2 != "UNEVEN") {
                                                $b_buttons .= "<button disabled=\"true\"><b>$p1</b> vs <b>$p2</b></button><br><br>\n";
                                        } else {
                                                $b_buttons .= "<button disabled=\"true\"><b>$p1</b> will sit out this round.</button><br><br>\n";
                                        }
                                }
                        
                
                        }

                        $round_roster = "
                        <br>
                        <center>
                        <u>Current Bracket</u><br><br>
                        <form>
                        $b_buttons
                        </form>
                        </center>
                        ";

                        $show_t_info = FALSE;

                case "teams":

                        $team_table = "
                        <hr>
                        <div align=\"center\">
                        <table border=\"0\" width=\"100%\">";

                        $sql = "SELECT * FROM teams WHERE t_key = '$key'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {

                                if (even($row[team_id])) {
                                
                                        $i = 2;

                                } else {
                                
                                        $i = 1;
                                        $team_table .= "</tr>";
                                        $team_table .= "<tr>";
                                }


                                $id[$i] = $row[team_id];
                                $name[$i] = $row[name];
                                
                                $team_table .= "
                                <td>
                                <center>
                                <u><h3>".$name[$i]."</h3></u>
                                ";
                                $sql_2 = "SELECT * FROM teammates WHERE team_id = '".$id[$i]."' AND t_key = '$key'";
                                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                                while ($row_2 = mysql_fetch_array($result_2)) {

                                        $team_table .= get_user_from_id($row_2[user_id])."<br>\n";

                                }

                                $team_table .= "
                                </center>
                                </td>
                                ";

                        }
                
                        $team_table .= "</tr>";

                        $team_table .= "</table>";
                        $round_roster .= $team_table;
        
                        $show_t_info = FALSE;
        
                        break;
                case "active":
        
                        logs(preg_replace("/[0-9]/", "", $key)) == "yes" ? $span = 4 : $span = 3;
        
                        $sql = "SELECT * FROM matches WHERE t_key = '$key' ORDER BY match_id, box_id";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        //id, t_key, match_id, contender, score, box_id, round, done
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
                                                                <td colspan=\"$span\">
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
                                                        <table border=\"1\" width=\"100%\">
                                                        <tr>
                                                                <td colspan=\"$span\">
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
                                        $done_c = $row[done];
                                        if ($done_c == "YES") {
                                                $score = "$p1score - $p2score";
                                                $done = "<font face=\"Verdana\" size=\"1\" color=\"#33CC33\"><b>DONE</b></font>";
                                        } else {
                                                $score = "0 - 0";
                                                $done = "<font face=\"Verdana\" size=\"1\" color=\"#FF0000\"><b>ACTIVE</b></font>";
                                        }
                                        if ($logs === TRUE) {
                                                $sql_2 = "SELECT * FROM logs WHERE t_key = '$key' AND match_id = '$row[match_id]'";
                                                $result_2 = mysql_query($sql_2, $connection) or die(mysql_error());
                                                while ($row_2 = mysql_fetch_array($result_2)) {
                                                        $log_location = $site_dir.$row_2[location];
                                                }
                                                if ($done_c == "YES") {
                                                        $log_msg = "<td><a href=\"$log_location\">$log_name</a></td>";
                                                } else {
                                                        $log_msg = "<td>$log_name</td>";
                                                }
                                        }
                                        if ($p2 === "UNEVEN") {
                                                $uneven = TRUE;
                                                $u_person = $p1;
                                        } else {
                                                $round_tbl[$round] .= "
                                                                <tr>
                                                                <td><center>".$p_1." versus ".$p_2."</center></td><td><center>$score</center></td>
                                                                <td><center>$done</center></td>
                                                                $log_msg
                                                                </tr>
                                                ";
                                        }
                                }
                        }

                        if ($uneven) {
                                $round_tbl[$round] .= "
                                        <tr>
                                                <td colspan=\"$span\">
                                                <center>
                                                ".team_name($u_person)." will sit out this round
                                                </center>
                                                </td>
                                        </tr>
                                        ";
                        }
                        $round_tbl[$round] .= "
                                </table>
                                </center>
                                <br>
                                ";
                        if ($round_tbl[$round] != "") {
                                for ($i = 1; $i <= $round; $i++) {
                                        $rounds .= $round_tbl[$i];
                                }
                        }

                        $round_roster = $rounds;

                        $show_t_info = FALSE;

                        break;
                default:
                        break;
        }

        if ($show_t_info) {
                                $round_roster = "
                                <table border=\"0\" width=\"100%\" cellspacing=\"4\" cellpadding=\"0\">
                                        <tr>
                                                <td width=\"100%\">
                                                        <center>
                                                        <font>
                                                        <u>
                                                        Tourney Info
                                                        </u>
                                                        </font>
                                                        </center>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"100%\" align=\"right\">
                                                        <table border=\"0\" width=\"100%\" id=\"table1\" cellspacing=\"0\" cellpadding=\"0\">
                                                                <tr>
                                                                        <td>
                                                                                <font>
                                                                                <center>
                                                                                <u>
                                                                                Award
                                                                                </u>
                                                                                </center>
                                                                                </font>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td>
                                                                                <font>
                                                                                <center>
                                                                                $award_disp
                                                                                </center>
                                                                                </font>
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"100%\">
                                                        <center>
                                                        <font>
                                                        $time_msg
                                                        </font>
                                                        </center>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"100%\">
                                                        <center>
                                                        <font>
                                                        $match_msg
                                                        </font>
                                                        </center>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"100%\">
                                                        <center>
                                                        <font>
                                                        $peeps_msg
                                                        </font>
                                                        </center>
                                                </td>
                                        </tr>
                                </table>
                                </center>
                                <br>
                                <center>
                                $the_button<br>
                                $the_roster
                                <table>
                                        <tr>
                                                <td class=\"squad\">
                                                        Squadmember
                                                </td>
                                                <td class=\"judge\">
                                                        Judge
                                                </td>
                                                <td class=\"admin\">
                                                        Administrator
                                                </td>
                                        </tr>
                                </table>
                                </center>
                ";
        }

        $page = "
<center>
<font>
There is a tournament pending...
</font>
</center>

<br>

<center>
<img src=\"".$site_dir."$banner\" border=\"0\" ALT=\"\">
</center>

<br>

<div align=\"center\">
        <table border=\"0\" width=\"65%\" cellspacing=\"6\">
                <tr>
                        <td width=\"100%\">
                                <center>
								<h2>                                                                
                                <b>$t_name</b>                                
                                </h2>
								</center>
                        </td>
                </tr>
                <tr>
                        <td width=\"100%\">
                                <center>
                                <font>
                                $description
                                </font>
                                </center>
                        </td>
                </tr>
                <tr>
                        <td width=\"100%\">
                                $round_roster
                                <hr>
                        </td>
                </tr>
                <tr>
                        <td width=\"100%\">
                                <center>
                                <u>Game Rules</u>
                                $rules
                                </center>
                        </td>
                </tr>
        </table>
</div>
";
        
} else {

        $page = "
        <center>
        <strong>Welcome to BnG Wars</strong><br><br>
        <font>
        Currently there are no tournaments active.<br><br>
        You may go to our forums to vote on the next tournament or to help in it's planning.
        <br><br>
        We appreciate your patience.
        </font>
        </center>
        ";


}

$header = "
<style type=\"text/css\">
.admin {
        border-left: 1px solid #FF0000;
        border-top: 1px solid #FF0000;
        border-right: 1px solid #FF0000;
        border-bottom: 1px solid #FF0000;
        background-color: #660000;
}
.judge {
        border-left: 1px solid #00FF00;
        border-top: 1px solid #00FF00;
        border-right: 1px solid #00FF00;
        border-bottom: 1px solid #00FF00;
        background-color: #006600;
}
.squad {
        border-left: 1px solid #0000FF;
        border-top: 1px solid #0000FF;
        border-right: 1px solid #0000FF;
        border-bottom: 1px solid #0000FF;
        background-color: #000066;
}
.ranktable {
        border-right: 1px solid #0000FF;
        border-bottom: 1px solid #0000FF;
        border-left: 1px solid #0000FF;
        border-top: 1px solid #0000FF;
        background-color: #000066
}
</style>
";
include($root."inc/top.html");
echo $page;
$w3c = FALSE;
include($root."inc/bottom.html");
?>
