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

$page_topimg = "squad";
$level = "squad";
$page_title = "User Profile";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (isset($_POST[save])) {
        $uname = $_SESSION[username];

        $user_id = get_user_id($uname);
        $sql = "UPDATE `purge` SET to_delete = 'yes' WHERE user_id = '$user_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
}

if ($_POST[upload_av]) {
        if ($_POST[title] != "") {
                $user_id = get_user_id($_SESSION[username]);
                $location = $admin_folder."avatars/".$_FILES[avatar][name];
                $from = $_FILES[avatar][tmp_name];
                if (!file_exists($uploaddir.$admin_folder."avatars/")) {
                        mkdir($uploaddir.$admin_folder."avatars/");
                }
                $to = $uploaddir.$admin_folder."avatars/".$_FILES[avatar][name];
                if ($_POST[def] == 1) {
                        $def = 1;
                } else {
                        $def = 0;
                }
                if (rank($_SESSION[username]) != "admin") {
                        $def = 1;
                }
                if ($def == 1) {
                        $sql = "UPDATE avatars SET def = '0' WHERE user = '$user_id'";
                        @mysql_query($sql,$connection) or die(mysql_error());
                }
                @move_uploaded_file($from,$to) or die("Could not copy file");
                $sql = "INSERT INTO avatars VALUES ('', '$user_id', '$_POST[title]', '$location', '$def')";
                $result = mysql_query($sql,$connection) or die(mysql_error());
                if (rank($_SESSION[username]) != "admin") {
                        $sql = "DELETE FROM avatars WHERE def = '0' AND user = '$user_id'";
                        mysql_query($sql,$connection) or die(mysql_error());
                }
        } else {
                $a_error = "<font color=\"red\">You must specify a title</font>";
        }
}

if ($_POST[change_def]) {

        $user_id = get_user_id($_SESSION[username]);
        $sql = "UPDATE avatars SET def = '0' WHERE user = '$user_id'";
        @mysql_query($sql,$connection) or die(mysql_error());
        
        $a_id = $_POST[av_list];
        $sql = "UPDATE avatars SET def = '1' WHERE id = '$a_id'";
        @mysql_query($sql,$connection) or die(mysql_error());

}

if ($_POST[delete_av]) {
        $sql = "SELECT * FROM avatars WHERE id = ".$_POST[avatar];
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $location = $row[file];
        }
        $sql = "DELETE FROM avatars WHERE id = ".$_POST[avatar];
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        @unlink($location);
        
        $user_id = get_user_id($_SESSION[username]);
        $sql = "SELECT id FROM avatars WHERE user = '$user_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());;
        $first = mysql_result($result, 0);
        $sql = "UPDATE avatars SET def = '1' WHERE id = '$first'";
        @mysql_query($sql,$connection) or die(mysql_error());
}

if (!isset($_GET[user])) {
        $uname = $_SESSION[username];

        $sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while($row = mysql_fetch_array($result)) {
                $user_id = $row[id];
                $ban = $row[ban];
                $email = $row[email];
                $wontourn = $row[twon];
                $ptourn = $row[tpart];
                $intourn = $row[intourn];
                $rank = $row[rank];
                $gender = $row[gender];
        }

        $trophy_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$user_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 = 1";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $trophies_won = "
                                <u><font>Trophies won from Tournaments</font></u>
                                <table border=\"0\">
                                        <tr>
                                ";
                                $loop_init = TRUE;
                        }
                        if ($trophy_loop == 5) {
                                $trophies_won .= "
                                        </tr>
                                        <tr>
                                ";
                        }
                        $trophies_won .= "<td><a href=\"javascript:viewAward($row[id])\"><img src=\"".$site_dir."awards/".$row_2[filename]."\" alt=\"$row_2[name] - $row_2[misc]\"></a></td>";
                        $trophy_loop++;
                }
        }
        if (isset($trophies_won)) {
                $trophies_won .= "
                                        </tr>
                                </table>
                                <br>
                ";
        }
        unset($loop_init);
        $award_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$user_id' ORDER BY level";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 != 1 ORDER BY misc_2, filename";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $awards_won = "
                                <u>Awards won</u>
                                <table border=\"0\">
                                        <tr>
                                ";
                                $loop_init = TRUE;
                        }
                        if ($award_loop == 6) {
                                $awards_won .= "
                                        </tr>
                                        <tr>
                                ";
                        }
                        $awards_won .= "<td><a href=\"javascript:viewAward($row[id])\"><img src=\"".$site_dir."awards/".$row_2[filename]."\" title=\"$row_2[name] - $row_2[misc]\" alt=\"$row_2[name] - $row_2[misc]\"></a></td>";
                        $award_loop++;
                }
        }
        if (isset($awards_won)) {
                $awards_won .= "
                                        </tr>
                                </table>
                                <br>
                ";
        }

        if ($rank == "admin") {
                $rankmsg = "You are an <a href=\"".$admin_dir."main.php\">Administrator</a><br><br>\n";
        }
        if ($rank == "judge") {
                $rankmsg = "You are a <a href=\"".$admin_dir."tournament.php\">Tournament Judge</a><br><br>\n";
        }
        if ($rank == "squad") {
                $rankmsg = "";
        }

        if ($intourn == "yes") {
                $key = get_key();
                $tournmsg = "<br>You are participating in the current tournament.<br>\n";
                if (get_tourn_var($key, "teams") == "yes") {
                        $tournmsg .= "Team: ".team_name($team_id);
                }
        } else {
                $tournmsg = "";
        }

        $banmsg = "You are banned from $ban tournaments.<br>\n";
        if ($ban == 0) {
                $banmsg = "You are not banned from any tournaments.<br>\n";
        }
        if ($ban == 1) {
                $banmsg = "You are banned from $ban tournament.<br>\n";
        }
        if ($ban == "I") {
                $banmsg = "You are banned indefinitely from all tournaments.<br>\n";
        }

        if ($wontourn == 1) {
                $wontourn = "You have won $wontourn tournament.<br>\n";
        } else {
                $wontourn = "You have won $wontourn tournaments.<br>\n";
        }

        if ($ptourn == 1) {
                $ptourn = "You have participated in $ptourn tournament.<br>\n";
        } else {
                $ptourn = "You have participated in $ptourn tournaments.<br>\n";
        }
        if (get_purge_for_user($user_id) == "no") {
                $purgemsg = "<br>You are selected to be deleted.
                <form method=\"post\" action=\"profile.php\">
                        <input type=\"hidden\" name=\"save\" value=\"true\">
                        <input type=\"submit\" value=\"Remove yourself from Purge\">
                </form>
                <br>\n";
        }

        $statistics = $banmsg.$wontourn.$ptourn.$tournmsg.$purgemsg;
        
        $edit = array(
                "username"    => "<a href=\"".$site_dir."editprofile.php?e=username\">[Edit]</a>",
                "email"       => "<a href=\"".$site_dir."editprofile.php?e=email\">[Edit]</a>",
        );
        
        $bottom_links = "
        [<a href=\"changepass.php\">Change Password</a>]
        [<a href=\"".$site_dir."home.php\">Home</a>]
        [<a href=\"logout.php\">Log out</a>]
        ";
        
        $prof_msg = "your profile,";
        
        $avatar_form = "
                                                        <br>
<form method=\"POST\" action=\"profile.php\"  enctype=\"multipart/form-data\">
<input type=\"hidden\" name=\"upload_av\" value=\"yes\">
<p><input type=\"file\" name=\"avatar\" size=\"12\"><br>
$a_error
Title: <input type=\"text\" name=\"title\" size=\"15\"><br>
";
if (rank($_SESSION[username]) == "admin") {
        $avatar_form .= "Default: <input type=\"checkbox\" name=\"def\" value=\"1\"><br>";
}
$avatar_form .= "
<input type=\"submit\" value=\"Upload Avatar\"></p>
</form>
<form method=\"POST\" action=\"profile.php\">
<input type=\"hidden\" name=\"delete_av\" value=\"yes\">
<select size=\"1\" name=\"avatar\">
";

$sql = "SELECT * FROM avatars WHERE user = '$user_id'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[def] == 1) {
                $avatar_form .= "<option value=\"$row[id]\" selected>$row[name]</option>\n";
        } else {
                $avatar_form .= "<option value=\"$row[id]\">$row[name]</option>\n";
        }
}

$avatar_form .= "
</select>
<input type=\"submit\" value=\"Delete Avatar\">
</form>
";

        if (rank($_SESSION[username]) == "admin") {
                $avatar_form .= "
                <form method=\"POST\" action=\"profile.php\">
                <input type=\"hidden\" name=\"change_def\" value=\"yes\">
                <p><select size=\"1\" name=\"av_list\">
                ";

                $sql = "SELECT * FROM avatars WHERE user = '$user_id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        if ($row[def] == 1) {
                                $avatar_form .= "<option value=\"$row[id]\" selected>$row[name]</option>\n";
                        } else {
                                $avatar_form .= "<option value=\"$row[id]\">$row[name]</option>\n";
                        }
                }

                $avatar_form .= "
                </select><br>
                <input type=\"submit\" value=\"Change Default\"></p>
                </form>
                ";
        }
} else {
        $uname = $_GET[user];

        $sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 1) {
                header("Location: ".$site_dir."profile.php");
                exit;
        }
        while($row = mysql_fetch_array($result)) {
                $user_id = $row[id];                
                $ban = $row[ban];
                $email = $row[email];
                $wontourn = $row[twon];
                $ptourn = $row[tpart];
                $intourn = $row[intourn];
                $rank = $row[rank];
                $gender = $row[gender];
        }
        
        $trophy_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$user_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 = 1";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $trophies_won = "
                                <u><font>Trophies won from Tournaments</font></u>
                                <table border=\"0\">
                                        <tr>
                                ";
                                $loop_init = TRUE;
                        }
                        if ($trophy_loop == 5) {
                                $trophies_won .= "
                                        </tr>
                                        <tr>
                                ";
                        }
                        $trophies_won .= "<td><a href=\"javascript:viewAward($row[id])\"><img src=\"".$site_dir."awards/".$row_2[filename]."\" alt=\"$row_2[name] - $row_2[misc]\"></a></td>";
                        $trophy_loop++;
                }
        }
        if (isset($trophies_won)) {
                $trophies_won .= "
                                        </tr>
                                </table>
                                <br>
                ";
        }
        unset($loop_init);
        $award_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$user_id' ORDER BY  level";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 != 1 ORDER BY misc_2, filename";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $awards_won = "
                                <u><font>Awards won</font></u>
                                <table border=\"0\">
                                        <tr>
                                ";
                                $loop_init = TRUE;
                        }
                        if ($award_loop == 6) {
                                $awards_won .= "
                                        </tr>
                                        <tr>
                                ";
                        }
                        $awards_won .= "<td><a href=\"javascript:viewAward($row[id])\"><img src=\"".$site_dir."awards/".$row_2[filename]."\" Title=\"$row_2[name] - $row_2[misc]\" ALT=\"\"></a></td>";
                        $award_loop++;
                }
        }
        if (isset($awards_won)) {
                $awards_won .= "
                                        </tr>
                                </table>
                                <br>
                ";
        }

        if ($rank == "admin") {
                $rankmsg = "$uname is an Administrator<br><br>\n";
        }
        if ($rank == "judge") {
                $rankmsg = "$uname is a Tournament Judge<br><br>\n";
        }
        if ($rank == "squad") {
                $rankmsg = "";
        }

        if ($intourn == "yes") {
                $key = get_key();
                $tournmsg = "<br>$uname is participating in the current tournament.<br>\n";
                if (get_tourn_var($key, "teams") == "yes") {
                        $sql = "SELECT * FROM teammates WHERE user_id = '$user_id' AND t_key = '$key'";
                        $result = @mysql_query($sql, $connection) or die(mysql_error());
                        while ($row = mysql_fetch_array($result)) {
                                $team_id = $row[team_id];
                        }
                        $tournmsg .= "Team: ".team_name($team_id);
                }
        } else {
                $tournmsg = "";
        }

        $banmsg = "$uname is banned from $ban tournaments.<br>\n";
        if ($ban == 0) {
                $banmsg = "$uname is not banned from any tournaments.<br>\n";
        }
        if ($ban == 1) {
                $banmsg = "$uname is banned from $ban tournament.<br>\n";
        }
        if ($ban == "I") {
                $banmsg = "$uname is banned indefinitely from all tournaments.<br>\n";
        }

        if ($wontourn == 1) {
                $wontourn = "$uname has won $wontourn tournament.<br>\n";
        } else {
                $wontourn = "$uname has won $wontourn tournaments.<br>\n";
        }

        if ($ptourn == 1) {
                $ptourn = "$uname has participated in $ptourn tournament.<br>\n";
        } else {
                $ptourn = "$uname has participated in $ptourn tournaments.<br>\n";
        }
        
        if (get_purge_for_user($user_id) == "no") {
                $purgemsg = "<br>$uname is selected to be deleted.<br>\n";
        }
        
        $statistics = $banmsg.$wontourn.$ptourn.$tournmsg.$purgemsg;
        
        $edit = array(
                "username"    => "",
                "email"       => "",
        );
        
        $bottom_links = "
        [<a href=\"profile.php\">Your profile</a>]
        [<a href=\"$site_dir"."home.php\">Home</a>]
        ";
        
        $prof_msg = "the profile of";
}

$header = "
<script language=\"JavaScript\">
// Place this script within <head> section.

var viewAwardX = (screen.width/2)-175;
var viewAwardY = (screen.height/2)-150;
var loc = \"left=\"+viewAwardX+\",top=\"+viewAwardY;
function viewAward(id){
var site = 'award_info.php?id='+id
viewAwardWindow = window.open(site,\"award_view\",\"width=290,height=210,\"+loc);
}
</script>
";
include($root."inc/top.html");
?>
<div align="center">
<center>
<table border="0" width="70%">
        <tr>
                <td width="100%">
                        <center>
                        <table>
                                <tr>
                                        <td width="30%">
                                                <?
                                                $avatar = get_default_avatar($user_id);
                                                $avatar == "NONE" ? $avatar = $img_defav[$gender] : $avatar = $site_dir.$avatar;
                                                echo "<img src='".$avatar."' ALT=''>";
                                                echo $avatar_form;
                                                ?>
                                        </td>
                                        <td width="60%">
                                                <center>
                                                <font>
                                                Welcome to <? echo $prof_msg; ?> <? echo "$uname"; ?>!<br>
                                                <br><? echo "$rankmsg"; ?>

                                                <u><b>User Statistics</b></u>
                                                </font>
                                                <br><br>
                                                <font>
                                                <? echo "$statistics"; ?>
                                                </font>
                                                <br>
                                                <? echo "$trophies_won"; ?>
                                                <br>
                                                <? echo "$awards_won"; ?>
                                                <br>
                                                </center>
                                        </td>
                                </tr>
                        </table>
                        <font>
                        <u><b>Profile Options</b></u>
                        </font>
                        </center>
                        <div align="center">
                        <table border="0" width="95%" cellspacing="3" cellpadding="0">
                                <tr>
                                        <td width="31%" align="right">
                                                <font>
                                                Username (Login):
                                                </font>
                                        </td>
                                        <td width="70%">
                                                <font>
                                                <? echo "$uname"; ?>
                                                </font>
                                        </td>
                                        <td width="11%">
                                                <font>
                                                <? echo $edit["username"]; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="31%" align="right">
                                                <font>
                                                E-mail:
                                                </font>
                                        </td>
                                        <td width="70%">
                                                <font>
                                                <? echo "$email"; ?>
                                                </font>
                                        </td>
                                        <td width="11%">
                                                <font>
                                                <? echo $edit["email"]; ?>
                                                </font>
                                        </td>
                                </tr>                                
                        </table>
                        </div>
                </td>
        </tr>
</table>
</center>
</div>
<center>
<font>
<? echo $bottom_links; ?>
</font>
</center>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
