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

$page_topimg = "admin";
$level = rank($_SESSION[username]);
$page_title = "Manage the squadmembers";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (isset($_POST[adding_user])) {
        $sql = "SELECT Count(*) AS ucount FROM squadmembers WHERE username = '$_POST[new_name]'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $num = $row[ucount];
        }
        if ($num == 0) {
                $pass = md5($_POST[new_pass]);
                $sql = "INSERT INTO squadmembers VALUES ('', '$_POST[new_name]', '$_POST[new_email]', '$pass', 0, 0, 0, 'no', 'squad')";
                $result = mysql_query($sql,$connection) or die(mysql_error());
        } else {
                $error = "Cannot create user $_POST[new_name] -- Name is already in use";
        }
        header("Location: ".$admin_dir."listaccounts.php");
        exit;
}

if (isset($_POST[purge])) {
        if ($_POST[purge] == "yes") {
        
                $purge_msg = "
Attention all Squad members:

A purge is in effect. Everyone, with the exception of admins, has their account selected to be deleted in a purge.

To save your account from the purge, please log into your account and click the button. Your account will be removed from the list and will not be deleted.

Thank you.

\tNessTheHero
                ";
                $subject = "Squad BnG -- Member Purge";
                $m_header = "From: Squad BnG Administration";
        
                $sql = "SELECT * FROM squadmembers";
                $result = @mysql_query($sql, $connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {

                        mail($row[email], $subject, $purge_msg, $m_header);

                        if ($row[rank] == "admin") {
                
                                $sql2 = "INSERT INTO `purge` VALUES ('', '$row[id]', 'yes')";
                                @mysql_query($sql2, $connection) or die(mysql_error());
        
                        } else {
                
                                $sql2 = "INSERT INTO `purge` VALUES ('', '$row[id]', 'no')";
                                @mysql_query($sql2, $connection) or die(mysql_error());
                
                        }
                }
                
        } elseif ($_POST[purge] == "del") {
        
                $sql = "SELECT * FROM squadmembers";
                $result = @mysql_query($sql, $connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {

                        if (get_purge_for_user($row[id]) == "no") {
                        
                                $sql2[] = "INSERT INTO old_members VALUES ('', '$row[id]', '$row[username]')";
                                $sql2[] = "DELETE FROM awards WHERE username = '$row[id]'";
                                $sql2[] = "DELETE FROM squadmembers WHERE id = '$row[id]'";
                                foreach($sql2 as $s) {
                                        @mysql_query($s, $connection) or die(mysql_error());
                                }
                        
                        }

                }
				
				$sql = "TRUNCATE TABLE `purge`";
                @mysql_query($sql, $connection) or die(mysql_error());
        
        } else {
        
                $sql = "TRUNCATE TABLE `purge`";
                @mysql_query($sql, $connection) or die(mysql_error());
        
        }
        
        
}

if (isset($_POST[user_action])) {
        $users = array();
		
        if (isset($_POST[option])) {
			if (!is_array($_POST[option])) {
				$users[0] = $_POST[option];
			} else {
				$users = $_POST[option];
			}        
        } else {
                header("Location: ".$admin_dir."listaccounts.php");
                exit;
        }
        switch ($_POST[action]) {
        case "delete":
                foreach ($users as $id) {
                        $sql = "DELETE FROM squadmembers WHERE id = '$id'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                }
                header("Location: ".$admin_dir."listaccounts.php");
                exit;
        break;
        case "promote":
                foreach ($users as $id) {
                        $uname = get_user_from_id($id);
                        if (rank($uname) == "squad") {
                                $sql = "UPDATE squadmembers SET rank = 'judge' WHERE id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                        if (rank($uname) == "judge") {
                                $sql = "UPDATE squadmembers SET rank = 'admin' WHERE id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                }
                header("Location: ".$admin_dir."listaccounts.php");
                exit;
        break;
        case "demote":
                foreach ($users as $id) {
                        $uname = get_user_from_id($id);
                        if (rank($uname) == "admin") {
                                $sql = "UPDATE squadmembers SET rank = 'judge' WHERE id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                        if (rank($uname) == "judge") {
                                $sql = "UPDATE squadmembers SET rank = 'squad' WHERE id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                }
                header("Location: ".$admin_dir."listaccounts.php");
                exit;
        break;
        case "tournament":
                foreach ($users as $id) {
                        if (in_tourn(get_user_from_id($id))) {
                                $sql = "UPDATE squadmembers SET intourn = 'no' WHERE id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        } else {
                                $sql = "UPDATE squadmembers SET intourn = 'yes' WHERE id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                }
        break;
        case "purge":
        
                foreach($users as $id) {
                        if (get_purge_for_user($id) == "yes") {
                                $sql = "UPDATE `purge` SET to_delete = 'no' WHERE user_id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        } else {
                                $sql = "UPDATE `purge` SET to_delete = 'yes' WHERE user_id = '$id'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                }
        
        break;
        }		
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
?>

<div align="center">
<? echo $error; ?>
<font>Create a user:</font>
<form method="post" action="listaccounts.php">
        <input type="hidden" name="adding_user" value="TRUE">
        <table border="0" width="62%" id="table1">
                <tr>
                        <td align="right"><font>Name:</font></td>
                        <td width="194"><input type="text" name="new_name" size="20"></td>
                </tr>
                <tr>
                        <td align="right"><font>E-mail:</font></td>
                        <td width="194"><input type="text" name="new_email" size="20"></td>
                </tr>
                <tr>
                        <td align="right"><font>Password:</font></td>
                        <td width="194"><input type="text" name="new_pass" size="20"></td>
                </tr>
                <tr>
                        <td colspan="2"><center><input type="submit" value="Create User"></center></td>
                </tr>
        </table>
        <input type="hidden" name="createuser" value="TRUE">
</form>
<?
        if (!check_purge()) {
                echo "
                <div align=\"center\">
                <table width=\"50%\" border=\"0\">
                        <tr>
                                <td align=\"center\">
                                        <form method=\"post\" action=\"".$admin_dir."listaccounts.php\">
                                                <input type=\"hidden\" name=\"purge\" value=\"yes\">
                                                <input type=\"submit\" value=\"Purge Inactive Squadmembers\">
                                        </form>
                                </td>
                        </tr>
                </table>
                </div>";

        } else {
                echo "
                <div align=\"center\">
                <table width=\"50%\" border=\"0\">
                        <tr>
                                <td align=\"center\">
                                        <form method=\"post\" action=\"".$admin_dir."listaccounts.php\">
                                                <input type=\"hidden\" name=\"purge\" value=\"no\">
                                                <input type=\"submit\" value=\"Deactivate Purge\">
                                        </form>
                                        <form method=\"post\" action=\"".$admin_dir."listaccounts.php\">
                                                <input type=\"hidden\" name=\"purge\" value=\"del\">
                                                <input type=\"submit\" value=\"Purge Members\">
                                        </form>
                                </td>
                        </tr>
                </table>
                </div>";
        }
?>
<form method="post" action="listaccounts.php" name="actionform">
        <table border="0" width="95%" cellspacing="0" class="ranktable">
                <tr>
                        <td><center><font><u>Username</u></font></center></td>                        
                        <td><center><font><u>E-Mail</u></font></center></td>
                        <td><center><font><u>In Tournament</u></font></center></td>
                        <?
                                if (check_purge()) {
                                        echo "<td><center><font><u>Purge</u></font></center></td>";
                                }
                        ?>
                        <td></td>
                </tr>

<?
        $sql = "SELECT * FROM squadmembers ORDER BY rank, username ASC";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $id = $row[id];
                $uname = $row[username];
                $rank = $row[rank];
                if (check_purge()) {
                        if (get_purge_for_user($id) == "yes") {
                                $purge = "<td align=\"center\" class=\"$rank\"><font color=\"#00FF00\"><b>SAVE</b></font></td>";
                        } else {
                                $purge = "<td align=\"center\" class=\"$rank\"><font color=\"#FF0000\"><b>DEL</b></font></td>";
                        }
                } else {
                        $purge = "";
                }
                $tournmsg = ucfirst($row[intourn]);
                if ($uname == $_SESSION[username]) {
                        $cbox = "";
                } else {
                        $cbox = "<input type=\"checkbox\" name=\"option[]\" value=\"$id\">";
                }
                echo "
                <tr>
                        <td align=\"center\" class=\"$rank\">
                                $uname
                                [<a href=\"".$site_dir."profile.php?user=$uname\">P</a>]
                        </td>                        
                        <td align=\"center\" class=\"$rank\">
                                $row[email]
                        </td>
                        <td align=\"center\" class=\"$rank\">
                                <font>
                                $tournmsg
                                </font>
                        </td>

                        ".$purge."

                        <td align=\"center\" class=\"$rank\">
                                $cbox
                        </td>
                </tr>
                ";
        }
?>

        </table>
        <br>

        <input type="hidden" name= "user_action" value="TRUE">
        <select size="1" name="action">
                <option selected value="promote">Promote</option>
                <option value="demote">Demote</option>
                <option value="delete">Delete</option>
                <option value="tournament">Change Tournament Status</option>
                <option value="purge">Change Purge Status</option>
        </select>
        <br><br>
        <input type="submit" value="Perform the selected action">
</form>
</div>

<?
$w3c = TRUE;
include($root."inc/bottom.html");
?>
