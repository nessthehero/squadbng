<?
session_start();

include("vars.php");
include("functions.php");
include("images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "Archived site content";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$page = "
            <div align=\"center\">
              <center>
              <table border=\"0\" width=\"54%\">
                <tr>
                  <td width=\"100%\">
                    <center>
                    <a href=\"".$site_dir."archive.php?cat=news\"><img border=\"0\" src=\"".$site_dir."CSS/archiveNEWS.png\"></a><br>
                    <a href=\"".$site_dir."archive.php?cat=tournaments\"><img border=\"0\" src=\"".$site_dir."CSS/archiveTOURNAMENTS.png\"></a><br>
                    <a href=\"".$site_dir."archive.php?cat=matches\"><img border=\"0\" src=\"".$site_dir."CSS/archiveMATCHES.png\"></a><br>
                    <a href=\"".$site_dir."archive.php?cat=games\"><img border=\"0\" src=\"".$site_dir."CSS/archiveGAMES.png\"></a>
                    </center>
                  </td>
                </tr>
              </table>
              </center>
            </div>
";

if (isset($_GET[error])) {

}

if (isset($_GET[cat])) {
        $cat = $_GET[cat];
        if ($cat == "news") {
                if (isset($_GET[month])) {
                        $month = $_GET[month];
                        $year = $_GET[year];
                        $poster = $_GET[poster];
                        if ($month != "ANY") {
                                if ($s_count == 0) {
                                        $select .= "WHERE ";
                                }
                                $select = "month = '$month'";
                                $s_count++;
                        }
                        if ($year != "ANY") {
                                if ($s_count == 0) {
                                        $select .= "WHERE ";
                                }
                                if ($s_count > 0) {
                                        $select .= " AND ";
                                }
                                $select .= "year = '$year'";
                                $s_count++;
                        }
                        if ($poster != "ANY") {
                                if ($s_count == 0) {
                                        $select .= "WHERE ";
                                }
                                if ($s_count > 0) {
                                        $select .= " AND ";
                                }
                                $select = "poster = '$poster'";
                                $s_count++;
                        }
                        $sql = "SELECT * FROM news ".$select." ORDER BY id";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                $poster = $row[poster];
                                $avatar = $row[avatar];
                                $post = nl2br(trim(stripslashes($row[post])));
                                $title = trim(stripslashes($row[title]));
                                $date = $row[timestamp];
                                        $format_date = explode(" ", $date);
                                        $form_date = explode("-", $format_date[0]);
                                        $form_time = explode(":", $format_date[1]);
                                $date = date("F jS, Y - g:i:s A", mktime($form_time[0], $form_time[1], $form_time[2], $form_date[1], $form_date[2], $form_date[0]));
                                $page .= "
        <div align=\"center\">
        <center>
        <table width=\"100%\">
                <tr>
                        <td width=\"52\"><img src=\"".$site_dir."$avatar\" height=50 width=50 ALT=\"$poster\"></td>
                        <td class=\"news\" height=\"51px\" align=\"center\">
                                <p align=\"center\">
                                <font class=\"newsheaders\">
                                $date<br>
                                $title
                                </font>
                                </p>
                        </td>
                </tr>
                <tr>
                        <td colspan=\"2\">
                                <div align=\"center\">
                                <table border=\"0\">
                                        <tr>
                                                <td width=\"100%\">
                                                        <p align=\"left\">
                                                        <font style=\"text-indent: 30; line-height: 150%\">
                                                        $post
                                                        </font>
                                                        </p>
                                                </td>
                                        </tr>
                                </table>
                                </div>
                        </td>
                </tr>
                <tr>
                        <td colspan=\"2\" height=\"25\"></td>
                </tr>
        </table>
        </center>
        </div>
        ";
                        }
                } else {
                        header("Location: ".$site_dir."archive.php?cat=news");
                        exit;
                }
                $sql = "SELECT month FROM news";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $month_select .= "<option>$row[month]</option>";
                }
                $sql = "SELECT year FROM news";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $year_select .= "<option>$row[year]</option>";
                }
                $sql = "SELECT poster FROM news";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $poster_select .= "<option>$row[poster]</option>";
                }
                
                $page = "
                                        <center>
                          <img border=\"0\" src=\"".$site_dir."CSS/archiveNEWS.png\" width=\"268\" height=\"59\">
                                        </center>

                <hr width=\"55%\">
                  <div align=\"center\">
                    <center>
                    <table border=\"0\" width=\"48%\">
                      <tr>
                        <td width=\"100%\">
                          <form method=\"GET\" action=\"archive.php\">
                          <input type=\"hidden\" name=\"cat\" value=\"news\">
                            <p align=\"center\"><font>
                                                                View old News Posts<br><br>

                                                                In: <select size=\"1\" name=\"month\">
                                                                  <option selected value=\"ANY\">Any month</option>
                                                                  $month_select
                                                                        </select><br>
                                                                                <br>
                                                                Of what year:<select size=\"1\" name=\"year\">
                                                                  <option selected value=\"ANY\">Any year</option>
                                                                  $year_select
                                                                </select><br>
                                                                <br>
                                                                Poster: <select size=\"1\" name=\"poster\">
                                                                  <option selected value=\"ANY\">Anyone</option>
                                                                  $poster_select
                                                                </select><br>
                                                                <br>
                                                                <input type=\"submit\" value=\"-- Go! --\"></font></p>
                          </form>
                        </td>
                      </tr>
                    </table>
                    </center>
                  </div>
                ";
        } elseif ($cat == "tournaments") {
                if (isset($_GET[key])) {
$sql = "SELECT * FROM tournaments WHERE key = '$_GET[key]'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
// id, t_name, t_key, password, logs, game, peeps, status
while ($row = mysql_fetch_array($result)) {
        $key = $row[t_key];
        $peeps = $row[peeps];
        $game = $row[game];
        $logs = $row[logs];
}
$sql = "SELECT * FROM tourneystats WHERE t_key = '$key]'";
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

$count = 1;
while ($count <= $round) {
        $all_rounds .= $round_tbl[$round];
}
                        $page = "
                  <center>
                  <font>$name</font><br><br>
                  <img src='$banner'>
                  </center>
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
                  <center>
                  $all_rounds
                  </table>
                  </font>
                  </center></font></p>
                        ";
                } else {
                        header("Location: ".$site_dir."archive.php?cat=tournaments");
                        exit;
                }
                $sql = "SELECT t_name FROM tournaments";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        if (!isset($tourney)) {
                                $tourney = $row[t_name];
                                $tourney_select .= "<option value=\"$row[t_key]\">$tourney</option>";
                        }
                        if ($tourney != $row[t_name]) {
                                $tourney = $row[t_name];
                                $tourney_select .= "<option value=\"$row[t_key]\">$tourney</option>";
                        }
                }
                $page = "
                <p align=\"center\">
                  <img border=\"0\" src=\"".$site_dir."CSS/archiveTOURNAMENTS.png\" width=\"274\" height=\"57\">

                <hr width=\"55%\">
                  <div align=\"center\">
                    <center>
                    <table border=\"0\" width=\"48%\">
                      <tr>
                        <td width=\"100%\">
                          <form method=\"GET\" action=\"archive.php\">
                          <input type=\"hidden\" name=\"cat\" value=\"tournaments\">
                            <p align=\"center\">
                            Select a Tournament
                            <br>
                            <br>
                            <select size=\"1\" name=\"key\">
                            $tourney_select
                            </select>
                            <br>
                            <br>
                            <input type=\"submit\" value=\"-- Go! --\">
                            </p>
                          </form>
                        </td>
                      </tr>
                    </table>
                    </center>
                  </div>
                ";
        } elseif ($cat == "matches") {
                if (isset($_GET[first_player])) {
                        $sql[1] = "SELECT * FROM MATCHES WHERE contender = '$_GET[first_player]'";
                        if ($_GET[second_player]) {
                                $sql[2] = "SELECT * FROM MATCHES WHERE contender = '$_GET[second_player]'";
                                $sql[1] .= " AND box_id = '1'";
                                $sql[2] .= " AND box_id = '2'";
                        }
                        if ($_GET[tournament] != "ANY") {
                                $sql[1] .= " AND t_key = '$_GET[tournament]'";
                                $sql[2] .= " AND t_key = '$_GET[tournament]'";
                        }
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                if ($first != TRUE) {
                                        $match_first_table = "<table width=\"auto\"><tr><td colspan=\"\"><center>First player matches</center></td></tr>";
                                        $first = TRUE;
                                }
                        }
                        
                        $sql[1] = "SELECT * FROM MATCHES WHERE contender = '$_GET[first_player]'";
                        if ($_GET[second_player]) {
                                $sql[2] = "SELECT * FROM MATCHES WHERE contender = '$_GET[second_player]'";
                                $sql[1] .= " AND box_id = '2'";
                                $sql[2] .= " AND box_id = '1'";
                        }
                        if ($_GET[tournament] != "ANY") {
                                $sql[1] .= " AND t_key = '$_GET[tournament]'";
                                $sql[2] .= " AND t_key = '$_GET[tournament]'";
                        }
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                if ($first != TRUE) {
                                        $match_sec_table = "<table width=\"auto\"><tr><td colspan=\"\"><center>First player matches</center></td></tr>";
                                }
                        }
                        
                } else {
                        header("Location: ".$site_dir."archive.php?cat=matches");
                        exit;
                }
                $sql = "SELECT * FROM tournaments";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $tourney_select .= "<option value=\"$row[t_key]\">$row[t_name]</option>";
                }
                $page = "
                <p align=\"center\">
                  <img border=\"0\" src=\"".$site_dir."CSS/archiveMATCHES.png\" width=\"179\" height=\"56\">

                <hr width=\"55%\">
                  <div align=\"center\">
                    <center>
                    <table border=\"0\" width=\"54%\">
                      <tr>
                        <td width=\"100%\">
                          <form method=\"GET\" action=\"archive.php\">
                          <input type=\"hidden\" name=\"cat\" value=\"matches\">
                            <p align=\"center\">
                            <font>Bring up a tournament match
                            <br>
                            <br>
                            Order of names does not matter. The script will pull
                            up all matches with the first combatant's name in
                            it. Use the second text box for more accurate
                            searches.<br>
                            <br>
                            First Combatant: <input type=\"text\" name=\"first_player\" size=\"20\"><br>
                            *Second Combatant: <input type=\"text\" name=\"second_player\" size=\"20\"><br>
                            <br>
                            Tournament:
                            <select size=\"1\" name=\"tournament\">
                            <option value=\"ANY\">Any Tournament</option>
                            $tourney_select
                            </select><br>
                            <br>
                            <br>
                            <input type=\"submit\" value=\"-- Go! --\">
                            <br>
                            <br>
                            * Optional
                            </p>
                          </form>
                        </td>
                      </tr>
                    </table>
                    </center>
                  </div>
                ";
        } elseif ($cat == "games") {
                if (isset($_GET[game])) {
                        $sql = "SELECT * FROM games WHERE game = '$_GET[game]'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                $banner = $site_dir.$row[banner];
                                $description = $row[description];
                                $link = $row[site];
                                $num = $row[tourneys];
                        }
                        $page = "
                        <center>        
                        banner<br><br>
                        Find this game here<br><br>
                        description<br><br>
                        This game has been used in number
                        tournament(s)
                        </center>
                        ";
                } else {
                        header("Location: ".$site_dir."archive.php?cat=games");
                        exit;
                }
                $sql = "SELECT * FROM games";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $games_we_play .= "<a href=\"".$site_dir."archive.php?cat=games&game=".$row[game]."\"><img src=\"".$site_dir.$row[banner]."\"></a><br>\n";
                }

                $page = "
                <p align=\"center\">

                  <img border=\"0\" src=\"".$site_dir."CSS/archiveGAMES.png\" width=\"136\" height=\"50\">
                <hr>
                  <div align=\"center\">
                    <center>
                    <table cellspacing=\"0\" cellpadding=\"0\">
                      <tr>
                        <td width=\"100%\" align=\"center\">
                        <center>
                        $games_we_play
                        </center>
                        </td>
                      </tr>
                    </table>
                    </center>
                  </div>
                ";
        } else {
                header("Location: ".$site_dir."archive.php");
                exit;
        }
}
?>
<html>
<head>
<title>
Squad BnG - <? echo $page_title; ?>
</title>
</head>
<body background="<? echo $img_BG; ?>" link="#FFFFFF" vlink="#E2C022" alink="#4A92CD" text="#E0B95B">

<center>
<font color="#E0B95B" size="1" face="Verdana">

<div align="center"><center>

<table border="0" width="548" bgcolor="#000000" height="98">
    <tr>
        <td valign="top" width="103" height="90"><table
        border="0" cellpadding="0" cellspacing="0" width="100%"
        height="1">
        <td height="72"><img border="0" src="<? echo $img_logo; ?>">
            <tr>
                <td width="100%" height="3"><img border="0" src="<? echo $img_menuTOP; ?>"></td>
                                </tr>
                                <tr>
                                        <td width="100%" background="<? echo $img_menuBG; ?>" height="1">
                                                <p align="center">
                                                <? echo buttons($level); ?>
                                                </p>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="100%" height="1"><img border="0" src="<? echo $img_menuBOTTOM; ?>"></td>
                                </tr>
</table>
        </td>
        <td width="681" height="94"><div align="center"><center><table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="100%"><img border="0" src="<? echo $img_TOP[$page_topimg]; ?>"></td>
            </tr>
            <tr>
                <td width="100%" background="<? echo $img_tableBG; ?>">
                <? echo $page; ?>
                </td>
            </tr>
            <tr>
                <td width="100%"><img src="<? echo $img_tableBOTTOM; ?>"></td>
            </tr>
        </table>
          </div></td>
    </tr>
</table>
  </div>

<font color="#E0B95B" size="1" face="Verdana">


<hr width="33%">
<div align="center"><center>

<table border="0">
   <tr>
        <td width="600" border="0">
        <p align="center">
        <font face="Verdana" size="1" color="#E0B95B">
        BnG Squad was created by <a href="mailto:nessthehero@boundforearth.com">NessTheHero</a>, <a href="mailto:GB330033@houston.rr.com">GB330033</a>, and contributed
        help from others. Everything in this site is fan-made. &quot;BnG&quot;, <a href="http://www.bobandgeorge.com/"> &quot;Bob and George&quot;</a>, and all things
        related to the comic of that name are copyright to Dave Anez. <a href="http://www.trenchwars.org/">Trench Wars</a> is copyrighted by Priitk. <a href="http://www.subspacehq.com/">Subspace</a> is owned by the
        fans and gamers who operate it, and was created by Virgin Interactive Entertainment. <br>
        This is a non profit site.</font></p>
        </td>
    </tr>
</table>
</center></div>
</body>
</html>
