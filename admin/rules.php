<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
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
$page_title = "Submit a tournament rule";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$deleted = "";
$uploaded = "";

if (isset($_GET[del])) {
        $sql = "DELETE FROM rules WHERE id = '$_GET[del]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $deleted = "Rule successfully deleted!";
}

if (isset($_POST[ds])) {
        if (isset($_POST[editing])) {
                $sql = "DELETE FROM rules WHERE id = '$_POST[editing]'";
                @mysql_query($sql,$connection) or die(mysql_error());
        }
        $sql = "INSERT INTO rules VALUES ('', '".addslashes($_POST[details])."', '".addslashes($_POST[game])."', '".addslashes($_POST[title])."')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $uploaded = "Rule successfully uploaded!";
}

if (isset($_GET[edit])) {
        $sql = "SELECT * FROM rules WHERE id = '$_GET[edit]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $name = $row[description];
                $desc = $row[rule];
                $game_disable = "disabled=\"true\"";
                $frozen_game = "<option selected>$row[game]</option>";
                $editing = "<input type=\"hidden\" value=\"$_GET[edit]\" name=\"editing\">";
        }
}

$header = "";
include($root."inc/top.html");
?>

<center>
<font>
Submit tournament rule
<? echo "
$deleted
$uploaded
";
?>
</font
></center>
<br>
<br>
<form method="POST" action="rules.php">
        <input type="hidden" name="ds" value="TRUE">
        <? echo $editing; ?>
        <div align="center">
        <center>
        <table border="0" width="70%">
                <tr>
                        <td width="50%" align="right">
                                <font face="Verdana" size="1" color="#E0B95B">
                                Title the rule:
                                </font>
                        </td>
                        <td width="50%" align="left">
                                <input type="text" name="title" size="31" value="<? echo $name; ?>">
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font face="Verdana" size="1" color="#E0B95B">
                                What game is it for?:
                                </font>
                        </td>
                        <td width="50%" align="left">
                                <select size="1" name="game" <? echo $game_disable; ?>>
                                        <option value="NULL">Select a game</option>
                                        <? echo $frozen_game; ?>
                                        <?
                                                $sql = "SELECT * FROM games";
                                                $result = mysql_query($sql,$connection) or die(mysql_error());
                                                while ($row = mysql_fetch_array($result)) {
                                                        echo "<option value=\"$row[game]\">$row[game]</option>\n";
                                                }
                                        ?>
                                </select>
                        </td>
                </tr>
                <tr>
                        <td width="50%" align="right">
                                <font face="Verdana" size="1" color="#E0B95B">
                                Type out the rule.<br>
                                Be specific on the details:
                                </font>
                        </td>
                        <td width="50%" align="left">
                                <textarea rows="10" name="details" cols="40"><? echo $desc; ?></textarea>
                        </td>
                </tr>
        </table>
        </center>
        </div>
        <center>
        <input type="submit" value="Submit rule" name="B1">
        <input type="reset" value="Reset" name="B2">
        </center>
        <center>
        <br>
        <font>
        Click the name to change the rule and the X to delete it
        </font>
        <br><br>
        <table border="0" width="50%">
                <tr>
                        <td align="left">
                                <?
                                        $sql = "SELECT * FROM rules ORDER BY game";
                                        $result = mysql_query($sql,$connection) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                                if (!$list_game) {
                                                        $list_game = $row[game];
                                                        echo "<ul>$list_game\n";
                                                }
                                                if ($row[game] == $list_game) {
                                                        echo "<li><a href=\"$admin_dir"."rules.php?edit=$row[id]\"><font>$row[description]</font></a><a href=\"$admin_dir"."rules.php?del=$row[id]\"><img src=\"".$img_del."\"></a></li>\n";
                                                } else {
                                                        $list_game = $row[game];
                                                        echo "</ul><ul>$list_game\n";
                                                        echo "<li><a href=\"$admin_dir"."rules.php?edit=$row[id]\"><font>$row[description]</font></a><a href=\"$admin_dir"."rules.php?del=$row[id]\"><img src=\"".$img_del."\"></a></li>\n";
                                                }
                                        }
                                ?>
                                </ul>
                        </td>
                </tr>
        </table>
        </center>
</form>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
