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
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = "admin";
$page_title = "Manage the teams in the tournament";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$key = get_key();

if (isset($_POST[assigning])) {

        $member = array();
        $team_num = array();
        $member = $_POST[member];
        $team_num = $_POST[team_num];
        $size = sizeof($member)-1;
        for ($i = 0; $i <= $size; $i++) {
                $sql = "SELECT * FROM teams WHERE team_id = '".$team_num[$i]."' AND t_key = '$key'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                if (mysql_num_rows($result) > 0) {
                        $sql = "INSERT INTO teammates VALUES ('', '".$key."', '".$member[$i]."', '".$team_num[$i]."')";
                        @mysql_query($sql,$connection) or die(mysql_error());
                }
        }
        header("Location: ".$admin_dir."teams.php");
        exit;

}
if (isset($_POST[name])) {

        $sql = "UPDATE teams SET name = '$_POST[new_name]' WHERE team_id = '$_POST[id]' AND t_key = '$key'";
        @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$admin_dir."teams.php");
        exit;

}
if (isset($_POST[finalize])) {

        $sql = "UPDATE tournaments SET status = 'bracket' WHERE t_key = '$key'";
        @mysql_query($sql,$connection) or die(mysql_error());
        $sql = "SELECT * FROM teams ORDER BY id";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $fighters = array();
        while ($row = mysql_fetch_array($result)) {
                array_push($fighters, $row[id]);
        }

        $random = get_tourn_var($key, "bracket");
        
        if ($random == "yes") {
                shuffle($fighters);
                shuffle($fighters);
                shuffle($fighters);
        }

        insert_matches($fighters, $key);
        
        header("Location: ".$admin_dir."tournament.php");
        exit;

}
if (isset($_POST[adding])) {

        $newteam = $_POST[number];
        $sql = "INSERT INTO teams VALUES ('', '".$newteam."', 'Team ".$newteam."', '".get_key()."')";
        @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$admin_dir."teams.php");
        exit;

}
if (isset($_GET[move])) {

        $key = get_key();

        $move = $_GET[move];
        if ($move == "up") {
                $sql = "UPDATE teammates SET team_id = team_id - 1 WHERE user_id = '$_GET[id]' AND t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());
        }
        if ($move == "down") {
                $sql = "UPDATE teammates SET team_id = team_id + 1 WHERE user_id = '$_GET[id]' AND t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());
        }
        if ($move == "del") {
                $sql = "DELETE FROM teammates WHERE user_id = '$_GET[id]' AND t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());
        }
        header("Location: ".$admin_dir."teams.php");
        exit;

}
if (isset($_GET[remove])) {

        $key = get_key();

        $sql = array();

        $sql = "DELETE FROM teams WHERE id = '$_GET[remove]' AND t_key = '$key'";
        $sql = "DELETE FROM teammates WHERE team_id = '$_GET[remove]' AND t_key = '$key'";
        $sql = "UPDATE teammates SET team_id = team_id-1 WHERE team_id > '$_GET[remove]' AND t_key = '$key'";
        foreach ($sql as $s) {
                @mysql_query($s,$connection) or die(mysql_error());
        }
        header("Location: ".$admin_dir."teams.php");
        exit;

}
if (isset($_GET[del])) {

        $key = get_key();

        $sql = "UPDATE squadmembers SET intourn = 'no' WHERE id = '$_GET[del]'";
        @mysql_query($sql,$connection) or die(mysql_error());
        if (peeps() < $min_users) {
                $sql = array();
                $sql[] = "UPDATE tournaments SET status = 'pending' WHERE t_key = '$key'";
                $sql[] = "DELETE FROM teams WHERE t_key = '$key'";
                $sql[] = "DELETE FROM teammates WHERE t_key = '$key'";
                $sql[] = "UPDATE t_stats SET signups = 'ON' WHERE t_key = '$key'";
                foreach ($sql as $s) {
                        @mysql_query($s,$connection) or die(mysql_error());
                }
        }
        header("Location: ".$admin_dir."teams.php");
        exit;

}

$sql = "SELECT status, t_key FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        switch ($row[status]) {
                case "bracket":
                        header("Location: ".$admin_dir."bracket.php");
                        exit;
                break;
                case "pending":
                        header("Location: ".$admin_dir."start_tournament.php");
                        exit;
                break;
                case "active":
                        header("Location: ".$admin_dir."tournament.php");
                        exit;
                break;
        }
}
if (mysql_num_rows($result) == 0) {
        header("Location: ".$admin_dir."create_tournament.php");
        exit;
}

$fighters = array();
$key = get_key();

$sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        array_push($fighters, $row['id']);
}

$size = sizeof($fighters) - 1;

$sql = "SELECT status, t_key FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        switch ($row[status]) {
                case "bracket":
                        header("Location: ".$admin_dir."bracket.php");
                        exit;
                break;
                case "pending":
                        header("Location: ".$admin_dir."start_tournament.php");
                        exit;
                break;
                case "active":
                        header("Location: ".$admin_dir."tournament.php");
                        exit;
                break;
        }
}
if (mysql_num_rows($result) == 0) {
        header("Location: ".$admin_dir."create_tournament.php");
        exit;
}

$header = "";
include($root."inc/top.html");
?>
                                                <div align="center">
                                                <table border="0" cellspacing="0" cellpadding="0">

<?
$unassigned = "no";
$unassigned_block = "
                                                        <tr>
                                                                <td>
                                                                <p align=\"center\"><font>Unassigned to Teams<br><br></font></td>
                                                        </tr>
                                                        <tr>
                                                                <td>
                                                                <form method=\"post\" action=\"teams.php\">
                                                                <input type=\"hidden\" name=\"assigning\" value=\"TRUE\">
                                                                <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
";
$sql = "SELECT * FROM squadmembers WHERE intourn = 'yes' ORDER BY username";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if (on_team($row[id], $key) === FALSE) {
                $unassigned_block .= "
                                                                        <tr>
                                                                                <td>
                                                                                <font>
                                                                                <input type=\"hidden\" name=\"member[]\" value=\"".$row[id]."\">
                                                                                ".$row[username]."
                                                                                </font>
                                                                                </td>
                                                                                <td>
                                                                                <input size=\"2\" name=\"team_num[]\" value=\"0\">
                                                                                </td>
                                                                                <td><a href=\"".$admin_dir."teams.php?del=".$row[id]."\"><img border=\"0\" src=\"".$img_del."\" width=\"17\" height=\"17\"></a></td>
                                                                        </tr>
                ";
                $unassigned = "yes";
        }
}
$unassigned_block .= "
                                                                        <tr>
                                                                                <td colspan=\"3\">
                                                                                <center><br>
                                                                                <input type=\"submit\" value=\"Assign Teams\">
                                                                                </center>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                                </form>
                                                                </td>
                                                        </tr>

";
if ($unassigned == "yes") {
        echo $unassigned_block;
}
?>


                                                </table>
                                                <br>
                                                <center>
                                                <form method="POST" action="teams.php">
                                                <input type="hidden" name="adding" value="TRUE">
                                                <?
                                                $newteam = highest("teams", "team_id", "t_key = '$key'") + 1;
                                                echo "<input type=\"hidden\" name=\"number\" value=\"".$newteam."\">";
                                                ?>
                                                <input type="submit" value="Create new Team">
                                                </form>
                                                <table border="0" width="auto" cellspacing="0" cellpadding="0">
<?
$sql = "SELECT * FROM teams WHERE t_key = '$key' ORDER BY id";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $team_block .= "
                                                        <tr>
                                                                <td>
                                                                <form method=\"POST\" action=\"teams.php\">
                                                                <input type=\"hidden\" name=\"name\" value=\"TRUE\">[<u><b>".$row[team_id]."</b></u>] --
                                                                <input type=\"hidden\" name=\"id\" value=\"".$row[team_id]."\">
                                                                <input type=\"text\" name=\"new_name\" size=\"20\" value=\"".$row[name]."\">
                                                                <input type=\"submit\" value=\"Change\">
                                                                <a href=\"".$admin_dir."teams.php?remove=".$row[team_id]."\">
                                                                <img border=\"0\" src=\"".$img_del."\" title=\"Remove this team?\">
                                                                </a>
                                                                </form>

                                                                </td>
                                                        </tr>
        ";
        $sql2 = "SELECT * FROM teammates WHERE team_id = '$row[id]' AND t_key = '$key'";
        $result2 = @mysql_query($sql2,$connection) or die(mysql_error());
        $numrows = mysql_num_rows($result2);
        if (($numrows > 0) || (!empty($numrows))) {
                while ($row2 = mysql_fetch_array($result2)) {
                        $move_block = "
                                                                <a href=\"".$admin_dir."teams.php?move=up&id=".$row2[user_id]."\"><img border=\"0\" src=\"".$img_up."\"></a>
                                                                <a href=\"".$admin_dir."teams.php?move=down&id=".$row2[user_id]."\"><img border=\"0\" src=\"".$img_down."\"></a>
                        ";
                        if ($row2[team_id] == 1) {
                                $move_block = "
                                                                <a href=\"".$admin_dir."teams.php?move=down&id=".$row2[user_id]."\"><img border=\"0\" src=\"".$img_down."\"></a>
                                ";
                        }
                        if ($row2[team_id] == highest("teams", "team_id", "t_key = '$key'")) {
                                $move_block = "
                                                                <a href=\"".$admin_dir."teams.php?move=up&id=".$row2[user_id]."\"><img border=\"0\" src=\"".$img_up."\"></a>
                                ";
                        }
                        $team_block .= "
                                                        <tr>
                                                                <td height=\"21\">
                                                                <center>".get_user_from_id($row2[user_id])." -
                                                                ".$move_block."
                                                                <a href=\"".$admin_dir."teams.php?move=del&id=".$row2[user_id]."\"><img border=\"0\" src=\"".$img_del."\" title=\"Remove from this team?\"></a>
                                                                </center>
                                                                </td>
                                                        </tr>
                        ";
                }
        }
}
echo $team_block;
?>
                                                </table>
                                                <br>
                                                <form method="POST" action="teams.php">
                                                <input type="hidden" value="TRUE" name="finalize">
                                                <?
                                                if ($unassigned == "yes") {
                                                        $finalize = "<input type=\"submit\" value=\"Finalize Teams and Start Round\" disabled=\"true\">";
                                                } else {
                                                        $finalize = "<input type=\"submit\" value=\"Finalize Teams and Start Round\">";
                                                }
                                                echo $finalize;
                                                ?>
                                                <br><font color="red">Warning! Teams cannot be changed after tournament has started!</font>

                                                </form>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
