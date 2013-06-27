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

$page_topimg = "squad";
$level = "squad";
$page_title = "User Profile";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (isset($_GET[shame])) {
        $how_many = $_GET[num];
        $user = $_GET[username];
        $award = $_GET[award];
}

if (!isset($_GET[user])) {
        $uname = $_SESSION[username];

        $sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while($row = mysql_fetch_array($result)) {
                $bname = $row[bracketname];
                $ban = $row[ban];
                $email = $row[email];
                $wontourn = $row[twon];
                $ptourn = $row[tpart];
                $intourn = $row[intourn];
                $rank = $row[rank];
        }

        $trophy_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 = 1";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $trophies_won = "
                                <center>
                                <u>Trophies won from Tournaments</u>
                                <table>
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
                        $trophies_won .= "<td><img src=\"".$site_dir."awards/".$row_2[filename]."\" alt=\"$row_2[name] - $row_2[misc]\"></td>";
                        $trophy_loop++;
                }
        }
        if (isset($trophies_won)) {
                $trophies_won .= "
                        </tr>
                </table>
                </center>
                <br>
                ";
        }
        unset($loop_init);
        $award_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$uname' ORDER BY level";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 != 1";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $awards_won = "
                                <center>
                                <u>Awards won</u>
                                <table>
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
                        $awards_won .= "<td><img src=\"".$site_dir."awards/".$row_2[filename]."\" title=\"$row_2[name] - $row_2[misc]\" onMouseOver=\"Show_Award($row_2[img_id])\" onMouseOut=\"document.award.style.display='none'\"></td>";
                        $award_loop++;
                }
        }
        if (isset($awards_won)) {
                $awards_won .= "
                        </tr>
                </table>
                </center>
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
                $tournmsg = "<br>You are participating in the current tournament.<br>\n";
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
        $statistics = $banmsg.$wontourn.$ptourn.$tournmsg;
        
        $edit = array(
                "username"    => "<a href=\"editprofile.php?e=username\">[Edit]</a>",
                "email"       => "<a href=\"editprofile.php?e=email\">[Edit]</a>",
                "bracketname" => "<a href=\"editprofile.php?e=bracketname\">[Edit]</a>"
        );
        
        if ($intourn == "yes") {
                $edit['bracketname'] = "";
        }
        
        $bottom_links = "
        [<a href=\"changepass.php\">Change Password</a>]
        [<a href=\"".$site_dir."home.php\">Home</a>]
        [<a href=\"logout.php\">Log out</a>]
        ";
        
        $prof_msg = "your profile,";
} else {
        $uname = $_GET[user];

        $sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 1) {
                header("Location: ".$site_dir."profile.php");
                exit;
        }
        while($row = mysql_fetch_array($result)) {
                $bname = $row[bracketname];
                $ban = $row[ban];
                $email = $row[email];
                $wontourn = $row[twon];
                $ptourn = $row[tpart];
                $intourn = $row[intourn];
                $rank = $row[rank];
        }
        
        $trophy_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]' AND misc_2 = 1";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $trophies_won = "
                                <center>
                                <u>Trophies won from Tournaments</u>
                                <table>
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
                        $trophies_won .= "<td><img src=\"".$site_dir."awards/".$row_2[filename]."\" alt=\"$row_2[name] - $row_2[misc]\"></td>";
                        $trophy_loop++;
                }
        }
        if (isset($trophies_won)) {
                $trophies_won .= "
                        </tr>
                </table>
                </center>
                <br>
                ";
        }
        unset($loop_init);
        $award_loop = 1;
        $sql = "SELECT * FROM awards WHERE username = '$uname' ORDER BY  level";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $sql_2 = "SELECT * FROM images WHERE id = '$row[img_id]'";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        if ($loop_init == FALSE) {
                                $awards_won = "
                                <center>
                                <u>Awards won</u>
                                <table>
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
                        $awards_won .= "<td><img src=\"".$site_dir."awards/".$row_2[filename]."\" Title=\"$row_2[name] - $row_2[misc]\"></td>";
                        $award_loop++;
                }
        }
        if (isset($awards_won)) {
                $awards_won .= "
                        </tr>
                </table>
                </center>
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
                $tournmsg = "<br>$uname is participating in the current tournament.<br>\n";
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
        $statistics = $banmsg.$wontourn.$ptourn.$tournmsg;
        
        $edit = array(
                "username"    => "",
                "email"       => "",
                "bracketname" => ""
        );
        
        $bottom_links = "
        [<a href=\"profile.php\">Your profile</a>]
        [<a href=\"$site_dir"."home.php\">Home</a>]
        ";
        
        $prof_msg = "the profile of";
}

include($site_dir."top.html");
?>
<div align="center">
<center>
<table border="0" width="70%">
        <tr>
                <td width="100%">
                        <p align="center">
                        <font>
                        User Profile
                        </font>
                        </p>
                        <hr>
                        <p align="center">
                        <font>
                        Welcome to <? echo $prof_msg; ?> <? echo "$uname"; ?>!<br>
                        <br><? echo "$rankmsg"; ?>
                        <u><b>User Statistics</b></u><br><br>
                        <? echo "$statistics"; ?>
                        <br>
                        <? echo "$trophies_won"; ?>
                        <br>
                        <? echo "$awards_won"; ?>
                        <br>
                        <u><b><center>Profile Options</center></b></u>
                        </font>
                        </p>
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
                                <tr>
                                        <td width="31%" align="right">
                                                <font>
                                                Bracket Name:
                                                </font>
                                        </td>
                                        <td width="70%">
                                                <font>
                                                <? echo "$bname"; ?>
                                                </font>
                                        </td>
                                        <td width="11%">
                                                <font>
                                                <? echo $edit["bracketname"]; ?>
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
<? include($site_dir."bottom.html"); ?>
