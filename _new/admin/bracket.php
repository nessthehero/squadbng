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
$level = "admin";
$page_title = "Bracket Finalization";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$b = _get_browser();

if ($b[browser] == "MSIE") {
        include($root."inc/top.html");
        echo "A Netscape Browser is required to use the functions of this page.";
        include($root."inc/bottom.html");
        exit;
}

$sql = "SELECT status, t_key FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        switch ($row[status]) {
                case "pending":
                        header("Location: ".$site_dir."start_tournament.php");
                        exit;
                break;
                case "teams":
                        header("Location: ".$site_dir."teams.php");
                        exit;
                break;
                case "active":
                        header("Location: ".$site_dir."tournament.php");
                        exit;
                break;
        }
}

$key = get_key();

if (isset($_GET[finalize])) {

        $sql = "UPDATE tournaments SET status = 'active' WHERE t_key = '$key'";
        @mysql_query($sql, $connection) or die(mysql_error());
        
        header("Location: ".$admin_dir."tournament.php");
        exit;

}

if (isset($_GET[change])) {

        $p[1] = $_GET[player1];
        $p[2] = $_GET[player2];
        
        if ($p[1] == $p[2]) {
                header("Location: ".$admin_dir."bracket.php?e=same");
                exit;
        }
        
        $fighters = array();
        $additions = array();
        $sql = "SELECT * FROM matches WHERE match_id >= ".$_GET[change]." AND t_key = '$key' ORDER BY match_id ASC";
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $fighters[] = $row[contender];
        }
        
        $sql = "DELETE FROM matches WHERE match_id >= ".$_GET[change]." AND t_key = '$key'";
        @mysql_query($sql, $connection) or die(mysql_error());
        
        for ($loop = 0; $loop <= sizeof($fighters) - 1; $loop++) {
                if (($fighters[$loop] != $p[1]) && ($fighters[$loop] != $p[2])) {
                        $bracket[] = $fighters[$loop];
                }
        }
        
        shuffle($bracket);
        
        $bracket[] = $p[1];
        $bracket[] = $p[2];
        
        $key = get_key();
        
        $m = $_GET[change];
        $b_id = 1;
        $loop = 1;
        foreach ($bracket as $b) {
                //id, t_key, match_id, contender, score, box_id, round, done
                $sql = "INSERT INTO matches VALUES ('', '$key', '$m', '$b', 0, $b_id, 1, 'NO')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                $b_id++;
                if (even($loop)) {
                        $m++;
                        $b_id = 1;
                }
                $loop++;
        }
        
}

$header = "";
include($root."inc/top.html");
?>
<center>
<font>
Bracket Editing
<br><br>
Is this good?<br>
*Click a match to edit it and all sequential matches*
</font>
</center>

<br>
                                        
<div align="center">
<table border="0" cellspacing="0" cellpadding="0" width="526">
        <tr>
                <td>
                        <center>
                        <form method="get" action="bracket.php">

                        <?
                                $sql = "SELECT * FROM matches WHERE t_key = '$key' ORDER BY match_id, box_id ASC";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        if ((isset($_GET[edit_b])) && ($_GET[edit_b] <= $row[match_id])) {
                                                if ($_GET[editb] == $row[match_id]) {
                                                        $selections .= "<option selected value='".$row[contender]."'>".team_name($row[contender])."</option>";
                                                } else {
                                                        $selections .= "<option value='".$row[contender]."'>".team_name($row[contender])."</option>";
                                                }
                                        } else {
                                                if ($row[box_id] == 1) {
                                                        $p1 = team_name($row[contender]);
                                                } else {
                                                        $p2 = team_name($row[contender]);
                                                        echo "
                                                        <button name=\"edit_b\" type=\"submit\" value=\"".$row[match_id]."\" onClick=\"\">
                                                        <b>$p1</b> versus <b>$p2</b>
                                                        </button>
                                                        <br><br>
                                                        ";
                                                }
                                        }
                                }
                                if (isset($_GET[edit_b])) {
                                        echo "
                                <select name=\"player1\">
                                $selections
                                </select>
                                versus
                                <select name=\"player2\">
                                $selections
                                </select>
                                <br>
                                <button name=\"change\" type=\"submit\" value=\"".$_GET[edit_b]."\" onClick=\"\">
                                Change this match
                                </button>
                                        ";
                                }
                        ?>
                                <br><br>
                                <button name="finalize" type="submit" value="yes" onClick="">
                                Finalize Bracket and Begin Tournament
                                </button>

                        </form>
                        </center>
                        <?
                        if (get_tourn_var($key, "teams") == "yes") {
                        
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
                        
                                echo $team_table."</div>";

                        }
                        ?>
                </td>
        </tr>
</table>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
