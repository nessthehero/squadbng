<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "Comment on $commenting_on";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$c_type = $_GET[type];
$c_id = $_GET[id];

if ($_POST[commenting]) {
        $c_title = $_POST[c_title];
        $c_post = htmlspecialchars($_POST[comment],ENT_QUOTES);
        $c_who = $_POST[who];
        $sql = "INSERT INTO comments VALUES ('', '$c_who', '$c_post', '$c_title', NOW(), '$c_type', '$c_id')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $success_msg = "<font color=\"red\"><b>Commented successfully</b></font>";
}

if ($_GET[del]) {
        $sql = "DELETE FROM comments WHERE id = '$_GET[del]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$site_dir."comments.php?type=news&amp;id=".$_GET[id]);
        exit;
}

if ($c_type == "news") {
        $sql = "SELECT * FROM news WHERE id = '$c_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $poster = get_user_from_id($row[poster]);
                $p_avatar = get_default_avatar($row[poster]);
                $p_avatar == "NONE" ? $p_avatar = $img_defav[$row[gender]] : $p_avatar = $site_dir.$p_avatar;
                $post = nl2br(trim(stripslashes($row[post])));
                $title = trim(stripslashes($row[title]));
                $date = $row[timestamp];
                        $format_date = explode(" ", $date);
                        $form_date = explode("-", $format_date[0]);
                        $form_time = explode(":", $format_date[1]);
                $date = date("F jS, Y - g:i:s A", mktime($form_time[0], $form_time[1], $form_time[2], $form_date[1], $form_date[2], $form_date[0]));
        }
        $commenting_on = $poster."'s news post";
        $sql = "SELECT * FROM comments WHERE type = '$c_type' AND type_id = '$c_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if (rank($_SESSION[username]) == "admin") {
                        $delete_link = "<br><a href=\"".$site_dir."comments.php?del=".$row[id]."&amp;id=".$c_id."\">[-Delete-]</a>";
                }
                $who = get_user_from_id($row[who]);
                $gender = get_gender($row[who]);
                $avatar = get_default_avatar($row[who]);
                $avatar == "NONE" ? $avatar = $img_defav[$gender] : $avatar = $site_dir.$avatar;
                $comment = nl2br(trim(stripslashes($row[comment])));
                $what = $row[title]."<br>";
                $when = $row[month]." ".$row[day].", ".$row[year]." -- ".$row[time];
                $date = $row[timestamp];
                        $format_date = explode(" ", $date);
                        $form_date = explode("-", $format_date[0]);
                        $form_time = explode(":", $format_date[1]);
                $date = date("F jS, Y - g:i:s A", mktime($form_time[0], $form_time[1], $form_time[2], $form_date[1], $form_date[2], $form_date[0]));
                $comment_block .= "
        <tr>
                <td>
                        <center>
                        <table border=\"0\">
                                <tr>
                                        <td valign=\"top\">
                                                <img src='$avatar' ALT='$who'>
                                                <center>$who</center>
                                        </td>
                                        <td rowspan=\"2\">
                                                <div align=\"center\">
                                                <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"50\">
                                                        <tr>
                                                                <td style=\"background-image: url('$img_csb_left'); repeat-y\" rowspan=\"2\" valign=\"top\">
                                                                        <img border=\"0\" src=\"$img_csb_tl\" ALT=\"\">
                                                                </td>
                                                                <td valign=\"top\" bgcolor=\"#FFFFFF\">
                                                                        <img border=\"0\" src=\"$img_csb_top\" width=\"239\" height=\"15\" align=\"top\" ALT=\"\">
                                                                </td>
                                                                <td style=\"background-image: url('$img_csb_right'); repeat-y\" rowspan=\"2\" valign=\"top\">
                                                                        <img border=\"0\" src=\"$img_csb_tr\" ALT=\"\">
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td valign=\"top\" height=\"53\" bgcolor=\"#FFFFFF\">
                                                                        <table border=\"0\" cellspacing=\"1\" cellpadding=\"0\">
                                                                                <tr>
                                                                                        <td width=\"100%\">
                                                                                                <center>
                                                                                                <font class=\"commentheaders\">
                                                                                                $what<br>
                                                                                                $date
                                                                                                </font>
                                                                                                </center>
                                                                                        </td>
                                                                                </tr>
                                                                                <tr>
                                                                                        <td width=\"100%\">
                                                                                                <br>
                                                                                                <p align=\"left\" style=\"text-indent: 30px;\">
                                                                                                <font style=\"text-indent: 30; line-height: 150%\" color=\"#000000\">
                                                                                                $comment
                                                                                                </font>
                                                                                                </p>
                                                                                        </td>
                                                                                </tr>
                                                                        </table>
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td width=\"auto\"><img border=\"0\" src=\"$img_csb_bl\" ALT=\"\"></td>
                                                                <td width=\"auto\"><img border=\"0\" src=\"$img_csb_bottom\" ALT=\"\"></td>
                                                                <td width=\"auto\"><img border=\"0\" src=\"$img_csb_br\" ALT=\"\"></td>
                                                        </tr>
                                                </table>
                                                </div>
                                        </td>
                                </tr>
                                <tr>
                                        <td valign=\"top\">
                                                $delete_link
                                        </td>
                                </tr>
                        </table>
                        </center>
                </td>
        </tr>

                ";
        }
        $page = "
<center>$success_msg</center>
<div align=\"center\">
<center>
<table width=\"579\">
        <tr>
                <td width=\"571\">
                        <div align=\"center\">
                        <table border=\"0\" width=\"546\">
                                <tr>
                                        <td width=\"13%\" valign=\"top\">
                                                <p align=\"right\">
                                                <img src=\"".$p_avatar."\" border=\"0\" ALT=\"".$poster."\">
                                        </td>
                                        <td width=\"84%\" align=\"center\" valign=\"top\">
                                                <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"443\">
                                                        <tr>
                                                                <td align=\"right\" valign=\"bottom\" height=\"0\"><img border=\"0\" src=\"".$img_sb_tl."\" ALT=\"\"></td>
                                                                <td valign=\"top\" bgcolor=\"#FFFFFF\"><img border=\"0\" src=\"".$img_sb_top."\" ALT=\"\">
                                                                        <font class=\"newsheaders\">
                                                                        ".$date."
                                                                        <br>
                                                                        ".$title."
                                                                        </font>
                                                                </td>
                                                                <td valign=\"bottom\"><img border=\"0\" src=\"".$img_sb_tr."\" ALT=\"\"></td>
                                                        </tr>
                                                        <tr>
                                                                <td align=\"right\" class=\"left\">
                                                                        &nbsp;
                                                                </td>
                                                                <td bgcolor=\"#FFFFFF\">
                                                                        <p align=\"left\">
                                                                        <font style=\"text-indent: 30; line-height: 150%\" color=\"#000000\">
                                                                        $post
                                                                        </font>
                                                                        </p>
                                                                </td>
                                                                <td class=\"right\">
                                                                        &nbsp;
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td align=\"right\" valign=\"top\"><img border=\"0\" src=\"".$img_sb_bl."\" ALT=\"\"></td>
                                                                <td><img border=\"0\" src=\"".$img_sb_bottom."\" ALT=\"\"></td>
                                                                <td><img border=\"0\" src=\"".$img_sb_br."\" ALT=\"\"></td>
                                                        </tr>
                                                </table>
                                        </td>
                                </tr>
                        </table>
                        </div>
                </td>
        </tr>
</table>
</center>
</div>
<hr width=\"40%\">
<center>
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"20%\">
        $comment_block
</table>
</center>
";
if (isset($_SESSION[username])) {
$page .= "
<br><br>
<form method=\"POST\" name=\"comment\" action=\"comments.php?type=".$c_type."&amp;id=".$c_id."\">
        <input type=\"hidden\" name=\"commenting\" value=\"yes\">
        <input type=\"hidden\" name=\"who\" value=\"".get_user_id($_SESSION[username])."\">
        <div align=\"center\">
        <center>
        <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                        <td>
                                <p align=\"center\">Title:
                        </td>
                        <td>
                                <p align=\"center\"><input type=\"text\" name=\"c_title\" size=\"35\">
                        </td>
                </tr>
                <tr>
                        <td colspan=\"2\">
                                <p align=\"center\"><textarea rows=\"4\" name=\"comment\" cols=\"40\"></textarea>
                        </td>
                </tr>
                <tr>
                        <td colspan=\"2\">
                                <p align=\"center\">
                                <input type=\"submit\" value=\"Submit\">
                                <input type=\"reset\" value=\"Reset\">
                                </p>
                        </td>
                </tr>
        </table>
        </center>
        </div>
</form>
";
}
} elseif ($c_type == "bio") {
        header("Location: ".$site_dir."home.php");
        exit;
} else {
        header("Location: ".$site_dir."home.php");
        exit;
}

$header = "
<style type=\"text/css\">
td.left {
        background-image: url('".$img_sb_left."');
}
td.right {
        background-image: url('".$img_sb_right."');
}
</style>
";
include($root."inc/top.html");
echo $page;
$w3c = TRUE;
include($root."inc/bottom.html");
?>
