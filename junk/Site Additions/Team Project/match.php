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
$page_title = "Upload a match";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT * FROM tournaments WHERE status = 'active'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $key = $row[t_key];
        $t_name = $row[t_name];
        $game = $row[game];
        $logs = $row[logs];
}
if (mysql_num_rows($result) != 0) {
        if (isset($_POST[ds])) {
                $sql = "SELECT * FROM matches WHERE id = '$_POST[matchid]'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        $play_1 = $row[play_1];
                        $play_2 = $row[play_2];
                }
                $sql = array();
                $sql[1] = "UPDATE matches SET p1score = '$_POST[p1score]' WHERE id = '$_POST[matchid]'";
                $sql[2] = "UPDATE matches SET p2score = '$_POST[p2score]' WHERE id = '$_POST[matchid]'";
                $sql[3] = "UPDATE matches SET done = 'YES' WHERE id = '$_POST[matchid]'";
                $sqlloop = 3;
                if ($logs == "TRUE") {
                        $log_name = $play_1."vs".$play_2.'['.$key.']'.".txt";
                        $from = $_FILES[match_log][tmp_name];
                        if (!file_exists($uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name)))) {
                                mkdir($uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name)));
                                mkdir($uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name))."/logs/", 0777);
                        }
                        $to = $uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name))."/logs/".$log_name;
                        @copy($from,$to) or die("Could not upload log. Please contact administrator.");
                        $sql[4] = "UPDATE matches SET log = '$log_name' WHERE id = '$_POST[matchid]'";
                        $sqlloop = 4;
                }
                for ($i = 1; $i <= $sqlloop; $i++) {
                        @mysql_query($sql[$i],$connection) or die(mysql_error());
                }
                header("Location: ".$admindir."match.php");
                exit;
        }
        unset($sql);
        $i = 1;
        $matches_left = FALSE;
        $round = get_round($key);
        unset($matches);
        unset($fighters);
        $matches = array();
        $fighters = array();
        $sql = "SELECT * FROM matches WHERE t_round = '$round' AND done = 'NO' AND play_2 != 'UNEVEN'";
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                        array_push($matches, $row[id]);
                        array_push($fighters, "$row[play_1] vs $row[play_2]");
                        $matches_left = TRUE;
        }

} else {
        $matches_left = FALSE;
}

$header = "";
include($site_dir."top.html");
?>

                 <p align="center">
                    <font color="#E0B95B" face="Verdana" size="1">
                 Upload a Match</font>
                 <hr width="75%">

                 <form method="POST" action="<? echo $_SERVER[PHP_SELF]; ?>" enctype="multipart/form-data">
                 <input type="hidden" name="ds" value="blah">
                  <div align="center">

                    <table border="0">
                      <tr>
                        <td>
                            <p align="center"><font color="#E0B95B" face="Verdana" size="1">Match: </font><select size="1" name="matchid">
                            <?
                            if ($matches_left) {
                                $i = mysql_num_rows($result);
                                for ($loop = 0; $loop <= $i - 1; $loop++) {
                                        echo "<option value='$matches[$loop]'>$fighters[$loop]</option>\n";
                                }
                            } else {
                                echo "<option value='0'>No matches left</option>";
                            }
                            ?>
                            </select>
                                                        </td>
                      </tr>
                      <tr>
                        <td>
                            <font color="#E0B95B" face="Verdana" size="1">Player 1 Score: </font><input type="text" name="p1score" size="3">
                                                        </td>
                      </tr>
                      <tr>
                        <td>
                            <font color="#E0B95B" face="Verdana" size="1">Player 2 Score: </font><input type="text" name="p2score" size="3">
                                                        </td>
                      </tr>
                      <tr>
                        <td>
                                                        <p align="center">
                                                        <?
                                                        if ($logs == "TRUE") {
                                                                echo "<font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Upload Log:</font><input type=\"file\" name=\"match_log\">\n";
                                                        }
                                                        ?>
                                                        </td>
                      </tr>
                      <tr>
                        <td>
                                                        <p align="center">
                                                        <input type="submit" value="Submit Match" name="submit">
                                                        </td>
                      </tr>
                    </table>
                  </div>
                  </form>
                  <br>

<? include($site_dir."bottom.html"); ?>
