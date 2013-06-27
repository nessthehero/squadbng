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
$level = rank($_SESSION[username]);
$page_title = "Tournament Pending";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT status, t_key FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        switch ($row[status]) {
                case "bracket":
                        header("Location: ".$admin_dir."bracket.php");
                        exit;
                break;
                case "teams":
                        header("Location: ".$admin_dir."teams.php");
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

if (isset($_GET[change])) {

        switch ($_GET[change]) {
        case "roster":
                $sql = "UPDATE squadmembers SET intourn = 'no' WHERE id = '$_GET[u_id]'";
                $result = @mysql_query($sql, $connection) or die(mysql_error());
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
        
        header("Location: ".$admin_dir."start_tournament.php");
        exit;
}

if (isset($_POST[start])) {
        $key = get_key();
        $teams = get_tourn_var($key, "teams");
        if ($teams == "yes") {
        
                $sql = "UPDATE tournaments SET status = 'teams' WHERE t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());
                $sql = "UPDATE t_stats SET signups = 'OFF' WHERE t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());

                $fighters = array();
                
                $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        array_push($fighters, $row[id]);
                }

                $size = sizeof($fighters);
                $ppt    = get_tourn_var($key, "ppt");
                $random = get_tourn_var($key, "random");
                
                if ($ppt != 0) {
                        for ($team_maker = 1; $team_maker <= ($size / $ppt); $team_maker++) {
                                $sql = "INSERT INTO teams VALUES ('', '$team_maker', 'Team $team_maker', '$key')";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                        if ($random == "yes") {
                                $j = 0;
                                for ($i = 0;$i <= $size - 1; $i++) {
                                        if ($i / $ppt == intval($i / $ppt)) {
                                                $j++;
                                        }

                                        $sql = "INSERT INTO teammates VALUES ('', '$key', '$fighters[$i]', '$j')";
                                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                                }
                        }
                }
                
                header("Location: ".$admin_dir."teams.php");
                exit;
                
        } else {
        
                $sql = "UPDATE tournaments SET status = 'bracket' WHERE t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());
                $sql = "UPDATE t_stats SET signups = 'OFF' WHERE t_key = '$key'";
                @mysql_query($sql,$connection) or die(mysql_error());
                
                $fighters = array();
                
                $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        array_push($fighters, $row[id]);
                }
                
                insert_matches($fighters, $key);
                
                header("Location: ".$admin_dir."bracket.php");
                exit;

        }
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
$peeps        = peeps();

$sql = "SELECT * FROM games WHERE g_key = '$game'";
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
        $peeps_msg = "There are ".peeps()." people signed up for this tourney.";
}

if ($teams == "yes") {

        if ($ppt != 0) {
                $peeps_msg .= "<br>Teams have $ppt players per team.";
        
                if ($peeps / $ppt != intval($peeps / $ppt)) {
                        $button_msg = "<input type=\"submit\" value=\"Teams will not be even. Get more players.\" name=\"start\" disabled=\"true\">";
                } else {
                        $button_msg = "<input type=\"submit\" value=\"Start tournament with ".intval(peeps() / $ppt)." teams.\" name=\"start\">";
                }
        } else {
                $peeps_msg .= "<br>Teams will be manually created.";
        
                $button_msg = "<input type=\"submit\" value=\"Start tournament and create teams.\" name=\"start\">";
        }
        
} else {

        if ($peeps < $min_users) {
                $button_msg = "<input type=\"submit\" value=\"Begin Tournament\" name=\"start\" disabled=\"true\">";
        } else {
                $button_msg = "<input type=\"submit\" value=\"Begin Tournament\" name=\"start\">";
        }

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
?>

<center><font>There is a tournament pending...</font></center>

<br>

<center><? echo "<img src=\"$site_dir"."$banner\" border=\"0\">"; ?></center>

<br>

<div align="center">
<table border="0" width="65%" cellspacing="6">
        <tr>
                <td width="100%">
                        <center>
                        <font><b><h2><? echo $t_name; ?></h2></b></font>
                        </center>
                </td>
        </tr>
        <tr>
                <td width="100%">
                        <center>
                        <font>
                        <? echo nl2br($description); ?>
                        
                        </font>
                        </center>
                </td>
        </tr>
        <tr>
                <td width="100%">

                        <table border="0" width="100%" cellspacing="4" cellpadding="0">
                                <tr>
                                        <td width="100%">
                                                <center><font><u>Tourney Info</u></font></center>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="100%" align="right">
                                                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                                <td><font><center><u>Award</u></center></font></td>
                                                        </tr>
                                                        <tr>
                                                                <td><font><center>
                                                                <br>
                                                                <?
                                                                if (!empty($award)) {
                                                                        if (is_numeric($award)) {
                                                                                $sql = "SELECT * FROM images WHERE id = ".$award;
                                                                                $result = @mysql_query($sql, $connection) or die(mysql_error());
                                                                                while ($row = mysql_fetch_array($result)) {
                                                                                        echo "<img src='".$site_dir."awards/".$row[filename]."' ALT='$row[name]'>";
                                                                                }
                                                                        } else {
                                                                                echo nl2br("<b>".$award."</b>");
                                                                        }
                                                                } else {
                                                                        $award = "<b>No award</b><br><br>";
                                                                        echo $award;
                                                                }
                                                                ?>
                                                                </center></font></td>
                                                        </tr>
                                                </table>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="100%"><center><font>
                                        <?
                                        switch ($match_type) {
                                        case "time":
                                                echo "Timed matches with a length of $time minutes";
                                                break;
                                        case "elim":
                                                echo "All matches are based on elimination. See description for kill limit";
                                                break;
                                        }
                                        ?>
                                        </font></center></td>
                                </tr>
                                <tr>
                                        <td width="100%"><center><font>
                                        <?
                                        switch ($bracket) {
                                        case "yes":
                                                echo "Matches are on a structured bracket.";
                                                break;
                                        case "no":
                                                echo "Matches are randomized every round.";
                                                break;
                                        }
                                        ?>
                                        </font></center></td>
                                </tr>
                                <tr>
                                        <td width="100%">
                                                <center>
                                                <font>
                                                <? echo $peeps_msg; ?>
                                                </font>
                                                </center>
                                        </td>
                                </tr>
                        </table>
                        </center>
                        <br>
                        <center>
                        <form method="POST" action="start_tournament.php?change=judges">
                        <input type="hidden" name="roster_edit" value="TRUE">
                        <table width="56%" cellspacing="2px" cellpadding="0px" class="ranktable">
                                <tr>
                                        <td width="33%" align="center" class="squad"><font><b>Squadmember</b></font></td>
                                        <td width="33%" align="center" class="squad"><font><b>Judge</b></font></td>
                                        <td width="34%" align="center" class="squad"><font><b>Delete</b></font></td>
                                </tr>
                                <?
                                $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        $u_id = $row[id];
                                        $uname = $row[username];
                                        $class = rank($uname);
                                        echo "
                                <tr>
                                        <td align=\"center\" class=\"$class\">
                                                <font face=\"Verdana\" size=\"1\" color=\"#E2C022\">
                                                $uname
                                                </font>
                                        </td>";
                                        if (rank($uname) != "admin") {
                                        echo "
                                        <td align=\"center\" class=\"$class\">
                                                <input type=\"checkbox\" name=\"is_judge[]\" value=\"$u_id\">
                                        </td>
                                        ";
                                        } else {
                                                echo "
                                                <td align=\"center\" class=\"$class\">
                                                ----
                                                </td>";
                                        }
                                        echo "
                                        <td align=\"center\" class=\"$class\">
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
                        <form method="POST" action="start_tournament.php">
                                <input type="hidden" value="yes" name="start">
                                <? echo "$button_msg"; ?>
                        </form>
                        </center>
                </td>
        </tr>
</table>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
