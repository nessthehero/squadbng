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
if (tourny_status("active")) {
        if (rank($_SESSION[username]) == "squad") {
                header("Location: ".$site_dir."accountlogin.php");
                exit;
        }
} else {
        if (rank($_SESSION[username]) != "admin") {
                header("Location: ".$site_dir."accountlogin.php");
                exit;
        }
}

$page_topimg = "admin";
$level = rank($_SESSION[username]);
$page_title = "Make a news post";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if ($_POST[posting]) {
        $poster = get_user_id($_SESSION[username]);
        $post = $_POST[post];
        $title = $_POST[title];
        $avatar = $_POST[avatar];
        // id, poster, avatar, post, title, day, month, year, time
        $sql = "INSERT INTO news VALUES ('', '$poster', '$post', '$title', NOW())";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        $posted = TRUE;
}

$header = "";
include($root."inc/top.html");
?>
<p align="center">
<font size="+1">
Submit News Post
</font>
</p>
<?
        if ($posted) {
                echo "
                <p align=\"center\">
                <font face=\"Verdana\" size=\"1\" color=\"#FF0000\">
                Posted successfully!
                </font>
                </p>
                ";
        }
?>
<form method="POST" action="news.php" name="news">
        <input type="hidden" value="TRUE" name="posting">
        <div align="center">
        <table border="0" width="74%">
                <tr>
                        <td width="32%" align="right">
                                Username:
                        </td>
                        <td width="68%" align="left">
                                <? echo $_SESSION[username]; ?>
                        </td>
                </tr>
                <tr>
                        <td width="32%" align="right">
                                Title of Post:
                        </td>
                        <td width="68%" align="left">
                                <input type="text" name="title" size="35">
                        </td>
                </tr>
                <tr>
                        <td width="32%" align="right">
                                Post:
                        </td>
                        <td width="68%" align="left">
                                <textarea rows="10" name="post" cols="50"></textarea>
                        </td>
                </tr>
        </table>
        </div>
        <p align="center">
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
        </p>
</form>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>

