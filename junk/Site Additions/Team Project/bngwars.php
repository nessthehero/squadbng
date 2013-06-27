<?
session_start();

include("vars.php");
include("functions.php");
include("images.php");

check_login();

$page_topimg = "bngwars";
$level = "squad";
$page_title = "Welcome to BnG Wars!";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$tourn_is_active = FALSE;

$sql = "SELECT status FROM tournaments";
$result = mysql_query($sql,$connection) or die(mysql_error());
if (mysql_num_rows($result) == 0) {
        $no_tourneys = TRUE;
}

if ((tourny_status("active")) || (tourny_status("pending"))) {
        $sql = "SELECT * FROM tournaments WHERE status = 'pending' OR status = 'active'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $name = $row[t_name];
                $key = $row[t_key];
                $logs = $row[logs];
                $game = $row[game];
                $peeps = $row[peeps];
        }
        if ($logs === "TRUE") {
                $span = 4;
        } else {
                $span = 3;
        }
        $sql = "SELECT banner FROM games WHERE game = '$game'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        // id, game, key, description, site, rating, banner, tourneys
        while ($row = mysql_fetch_array($result)) {
                $banner = $row[banner];
        }
        $sql = "SELECT * FROM tourneystats WHERE t_key = '$key'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $description = nl2br(trim(stripslashes($row[description])));
                $award = $row[award];
                $time = $row[time];
                $signups = $row[signups];
        }
        
        $time = (0) ? "No time limit" : $time." minutes";
        
        $sql = "SELECT * FROM images WHERE class = 'award' AND id = '$award'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $award_filename = $row[filename];
                $award_name = $row[name];
                $award_description = $row[misc];
        }
        $sql = "SELECT * FROM matches WHERE t_key = '$key'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        // id, t_key, play_1, play_2, p1score, p2score, log, t_round, done
        while ($row = mysql_fetch_array($result)) {
                if ($round < $row[t_round]) {
                if ($uneven) {
                $round_tbl[$round] .= "
                        <tr>
                                <td colspan=\"$span\"><center>$u_person did not play in this round</center></td>
                        </tr>
                        ";
                        $uneven = FALSE;
                }
                $round_tbl[$round] .= "
                </table>
                </center>
                <br>
                ";
                $round = $row[t_round];
                }
                if (!$round_tbl[$round]) {
                $round_tbl[$round] = "
                <center>
                          <table border=\"1\" class=\"roster\">
                            <tr><td colspan=\"$span\"><center>Matches - Round $round</center></td></tr>
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
                if ($logs === "TRUE") {
                        if ($done == "YES") {
                                $log = $row[log];
                                $log_location = $site_dir."tournaments/".$game."/".strtolower(str_replace(" ","_",$name))."/logs/".$log;
                                $log_msg = "<td><a href=\"$log_location\">LOG</a></td>";
                        } else {
                                $log_msg = "<td>LOG</td>";
                        }
                }
                if ($done == "YES") {
                        $score = "$p1s - $p2s";
                        $done = "<font color=\"#33CC33\"><b>DONE</b></font>";
                } else {
                        $score = "0 - 0";
                        $done = "<font color=\"#FF0000\"><b>ACTIVE</b></font>";
                }
                if ($p2 === "UNEVEN") {
                        $uneven = TRUE;
                        $u_person = $p1;
                } else {
                        $round_tbl[$round] .= "
                            <tr><td><center>$p1 versus $p2</center></td><td><center>$score</center></td><td><center>$done</center></td>$log_msg</tr>
                        ";
                }
        }
        if ($uneven) {
                $round_tbl[$round] .= "
                        <tr>
                                <td colspan=\"$span\"><center>$u_person will sit out this round</center></td>
                        </tr>
                        ";
        }
        if ($round_tbl[$round] != "") {
                for ($i = 1; $i <= $round; $i++) {
                        $roster_rounds .= $round_tbl[$i];
                }
        }
        if ($signups == "ON") {
                $roster_rounds = "<u>Roster</u><br>";
                if (!$_SESSION[username]) {
                        $sign_up = "<input type=\"submit\" value=\"You are not logged in.\" disabled=\"true\">";
                } else {
                        if (banned("$_SESSION[username]")) {
                                $sign_up = "<input type=\"submit\" value=\"You are banned from this tourney\" disabled=\"true\">";
                        }
                        $sign_up = "<input type=\"submit\" value=\"Sign up while you still can!\">";
                }
                $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes' ORDER BY bracketname";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        if (isset($roster_rounds)) {
                                $roster_rounds .= "<br>\n";
                        }
                        $roster_rounds .= "<b>$row[bracketname]</b>";
                }
        } else {
                $sign_up = "";
        }
        $sql = "SELECT * FROM rules WHERE game = '$game'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        $inc = 1;
        while ($row = mysql_fetch_array($result)) {
                $rule = nl2br($row[rule]);
                $rules .= "
                <tr>
                <td width=\"489px\">
                <table width=\"75%\"><tr><td>
                <font face=\"verdana\" size=\"1\"><p style=\"text-indent: 30\">$inc. $rule</p></font>
                </td></tr></table>
                </td>
                </tr>
                ";
                $inc++;
        }
        $page = "
                  <p align=\"center\"><font face=\"Verdana\" size=\"5\">BnG Wars</font></p>
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">Welcome to BnG
                  Wars</font></p>
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">$name<br><br>
                  <img src='$banner'></font></p>
                  <div align=\"center\" height=\"auto\">
                    <table border=\"0\" width=\"50%\">
                      <tr>
                        <td colspan=\"2\" height=\"21\">
                          <p align=\"center\"><font face=\"Verdana\" size=\"1\">$description</font>
                          </td>
                      </tr>
                      <tr>
                        <td height=\"1\" align=\"right\"><font face=\"Verdana\" size=\"1\">Match Time
                          limit:</font></td>
                        <td height=\"1\">
                          <p align=\"center\"><font face=\"Verdana\" size=\"1\">$time</font></td>
                      </tr>
                      <tr>
                        <td height=\"1\" align=\"right\"><font face=\"Verdana\" size=\"1\">Award:</font></td>
                        <td height=\"1\">
                          <p align=\"center\"><font face=\"Verdana\" size=\"1\">
                          <img src=\"".$site_dir."awards/"."$award_filename\" alt=\"$award_name - $award_description\">
                          </font></td>
                      </tr>
                    </table>
                  </div>
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">
                  <form method=\"post\" action=\"signup.php\">
                  $sign_up
                  </form>
                  </font></p>
                  <center>
                  $roster_rounds
                  </table>
                  </font>
                  </center></font></p>
                  <div align=\"center\">
                  <table border=\"0\" width=\"497px\">
                    <tr>
                      <td width=\"489px\">
                        <p align=\"center\"><u><font face=\"Verdana\" size=\"1\">Rules of Conduct</font></u></p>
                      </td>
                    </tr>
                      $rules
                  </table>
                  </div>
        ";
}else {
        $page = "
                  <p align=\"center\"><font face=\"Verdana\" size=\"5\">BnG Wars</font></p>
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">Welcome to BnG
                  Wars</font></p>
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">Currently
                  there are no tournaments active.</font></p>
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">You may go to
                  our forums to vote on the next tournament or to help in it's<br>
                  planning. We appreciate your patience.
                  </font>
                  ";
        if (!$no_tourneys) {
                $high_id = highest_id("tourneystats");
                $sql = "SELECT * FROM tourneystats WHERE id = '$high_id'";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $l_name = $row[t_name];
                        $l_award = $row[award];
                        $l_key = $row[t_key];
                }
                $sql = "SELECT * FROM tournaments WHERE id = '$high_id'";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $l_peeps = $row[peeps];
                        $l_game = ucfirst(str_replace("_"," ",$row[game]));
                }
                $sql = "SELECT * FROM matches WHERE t_key = '$l_key' ORDER BY id DESC";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                $row = mysql_fetch_array($result);
                $p1s = $row[p1score];
                $p2s = $row[p2score];
                $p1 = $row[play_1];
                $p2 = $row[play_2];
                if ($p1s > $p2s) {
                        $l_winner = $p1;
                } else {
                        $l_winner = $p2;
                }

                $page .= "
                  <hr width=\"55%\">
                  <p align=\"center\"><font face=\"Verdana\" size=\"1\">Previous Tournament</font></p>
                    <center>
                    <table border=\"0\" width=\"64%\">
                      <tr>
                        <td width=\"35%\" align=\"right\"><font face=\"Verdana\" size=\"1\">Name:</font></td>
                        <td width=\"65%\" align=\"center\"><font face=\"Verdana\" size=\"1\">$l_name</font></td>
                      </tr>
                      <tr>
                        <td width=\"35%\" align=\"right\"><font face=\"Verdana\" size=\"1\">Game:</font></td>
                        <td width=\"65%\" align=\"center\"><font face=\"Verdana\" size=\"1\">$l_game</font></td>
                      </tr>
                      <tr>
                        <td width=\"35%\" align=\"right\"><font face=\"Verdana\" size=\"1\">Participants:</font></td>
                        <td width=\"65%\" align=\"center\"><font face=\"Verdana\" size=\"1\">$l_peeps</font></td>
                      </tr>
                      <tr>
                        <td width=\"35%\" align=\"right\"><font face=\"Verdana\" size=\"1\">Award:</font></td>
                        <td width=\"65%\" align=\"center\"><font face=\"Verdana\" size=\"1\">$l_award</font></td>
                      </tr>
                      <tr>
                        <td width=\"35%\" align=\"right\"><font face=\"Verdana\" size=\"1\">Winner:</font></td>
                        <td width=\"65%\" align=\"center\"><font face=\"Verdana\" size=\"1\">$l_winner</font></td>
                      </tr>
                      <tr>
                        <td width=\"100%\" colspan=\"2\">
                          <p align=\"center\"><font face=\"Verdana\" size=\"1\">Log archive coming soon.</font></td>
                      </tr>
                    </table>
                    </center>
        ";
}
}
$header = "
<style type=\"text/css\">
table.roster {
        height: auto;
        width: auto;
        padding: 2px 2px 2px 2px;
}
</style>
";
include($site_dir."top.html");
echo $page;
include($site_dir."bottom.html");
?>
