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
$title = "Are you sure?";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if ($_POST[action] == "round") {
        $key = get_key();
        $sql = "SELECT * FROM matches WHERE round = '$_POST[round]' AND t_key = '$key' ORDER BY match_id, box_id ASC";
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        $count = mysql_num_rows($result);
        if ($count == 2) {
                header("Location: ".$admin_dir."end.php?key=$key&round=$_POST[round]");
                exit;
        }
        $winners = array();
        while ($row = mysql_fetch_array($result)) {
                if ($row[box_id] == 2) {
                
                        $player_2 = $row[contender];
                        $p2_score = $row[score];
                        
                        if ($player_2 != "UNEVEN") {
                                if ($p1_score > $p2_score) {
                                        array_push($winners, $player_1);
                                } else {
                                        array_push($winners, $player_2);
                                }
                        } else {
                                array_push($winners, $player_1);
                                $last_loser = $player_1;
                        }
                        
                } else {
                
                        $player_1 = $row[contender];
                        $p1_score = $row[score];
                        
                }

                $m_id = $row[match_id];
                $i++;
                
        }
        $size = sizeof($winners);
        if (get_tourn_var($key, "bracket") == "no") {
                shuffle($winners);

                if ($winners[$size-1] == $last_loser) {
                        shuffle($winners);
                }
        } else {
                if ($winners[$size-1] == $last_loser) {
                        $mover = array_shift($winners);
                        array_push($winners, $mover);
                }
        }
        if (odd($size)) {
                array_push($winners, "UNEVEN");
        }
        $size = sizeof($winners);
        $round = get_round($key) + 1;
        $i = 0;
        $k = 1;
        $m_id++;
        while ($i <= $size-1) {
                $player = $winners[$i];
                                                   // id, t_key, match_id, contender, score, box_id, round, done
                $sql = "INSERT INTO matches VALUES ('', '$key', '$m_id', '$player', 0, $k, $round, 'NO')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                
                if (odd($i+1) == TRUE) {
                        $k++;
                } else {
                        $k = 1;
                        $m_id++;
                }
                $i++;
        }
        header("Location: ".$admin_dir."tournament.php");
        exit;
}
if ($_POST[action] == "delete") {
        $key = get_key();
        $t_name = $_POST[t_name];
        $form = "
        <div align=\"center\">
        <center>
        <table border=\"0\" width=\"71%\">
                <tr>
                        <td width=\"100%\">
                          <center>
                          <font>Are you sure you want to delete this tournament?</font><br>

                          <center>
                          <form method=\"POST\" action=\"delete.php\">
                            <input type=\"hidden\" value=\"$t_name\" name=\"t_name\">
                            <input type=\"hidden\" value=\"$key\" name=\"t_key\">
                            <input type=\"submit\" value=\"Yes\" name=\"yes\">
                          </form>
                          <form method=\"POST\" action=\"tournament.php\">
                            <input type=\"submit\" value=\"No, I changed my mind! Keep the tournament!\" name=\"no\">
                          </form>
                          </center>
                        </td>
                </tr>
        </table>
        </center>
        </div>
        ";
}

$header = "";
include($root."inc/top.html");
echo "$form";
$w3c = FALSE;
include($root."inc/bottom.html");
?>
