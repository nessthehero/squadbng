<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "news";
$level = "squad";
$page_title = "Welcome!";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$post_limit = 3;
$post_start = 0;
!isset($_GET[p_id]) === false ? $post_start = $_GET[p_id] : $post_start = $post_start;

$num_posts = 0;
$sql = "SELECT Count(*) AS post_count FROM news";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $num_posts = $row[post_count];
}

$sql = 'SELECT * FROM news ORDER BY timestamp DESC LIMIT '.$post_start.','.$post_limit;
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $id = $row[id];
        $sql_2 = "SELECT * FROM comments WHERE type_id = '$id'";
        $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
        $num_comments = mysql_num_rows($result_2);

        $num_comments == 1 ? $wording = "Comment" : $wording = "Comments";

        $poster = $row[poster];
        $avatar = get_default_avatar($poster);
        $post = nl2br(trim(stripslashes($row[post])));
        $title = trim(stripslashes($row[title]));
        $date = $row[timestamp];
                $format_date = explode(" ", $date);
                $form_date = explode("-", $format_date[0]);
                $form_time = explode(":", $format_date[1]);
        $date = date("F jS, Y - g:i:s A", mktime($form_time[0], $form_time[1], $form_time[2], $form_date[1], $form_date[2], $form_date[0]));
        $newsblock .= "
<div align=\"center\">
<table width=\"579\">
        <tr>
                <td width=\"571\">
                        <div align=\"center\">
                        <table border=\"0\" width=\"546\">
                                <tr>
                                        <td width=\"13%\" valign=\"top\">
                                                <p align=\"right\">
                                                <img src=\"".$site_dir.$avatar."\" border=\"0\" ALT=\"".get_user_from_id($poster)."\" /><br>
                                                <center>".get_user_from_id($poster)."</center>
                                        </td>
                                        <td width=\"84%\" align=\"center\" valign=\"top\">
                                                <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"443\">
                                                        <tr>
                                                                <td align=\"right\" valign=\"bottom\" height=\"0\"><img border=\"0\" src=\"".$img_sb_tl."\" ALT=\"\" /></td>
                                                                <td valign=\"top\" bgcolor=\"#FFFFFF\"><img border=\"0\" src=\"".$img_sb_top."\" ALT=\"\">
                                                                        <font class=\"newsheaders\">
                                                                        ".$date."
                                                                        <br>
                                                                        ".$title."
                                                                        </font>
                                                                </td>
                                                                <td valign=\"bottom\"><img border=\"0\" src=\"".$img_sb_tr."\" ALT=\"\" /></td>
                                                        </tr>
                                                        <tr>
                                                                <td align=\"right\" class=\"left\">
                                                                        &nbsp;
                                                                </td>
                                                                <td class=\"newstext\">
                                                                	$post                                                                       
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
        <tr>
                <td height=\"25\" width=\"619\">
                        <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                        <td>
                                                [".$num_comments." ".$wording."]
                                        </td>
                                        <td width=\"56%\">
                                                <hr size=\"1\" style=\"color: #FF9933\">
                                        </td>
                                        <td>                                         
                                                <a href=\"".$site_dir."comments.php?type=news&amp;id=".$id."\">Comment on this</a>                                                                                                
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
</div>
        ";
}
if (mysql_num_rows($result) == 0) {
        $newsblock = "<center>There are no news posts</center>";
}
$prev_id = $post_start + $post_limit;
$next_id = $post_start - $post_limit;
$prev = "
<a href=\"".$site_dir."home.php?p_id=$next_id\">
<img src=\"".$img_next."\" ALT=\"\">
</a>
";
$next = "
<a href=\"".$site_dir."home.php?p_id=$prev_id\">
<img src=\"".$img_prev."\" ALT=\"\">
</a>
";
if ($post_start == 0) {
$page_flipper = "
        <div align=\"center\">
          <center>
          <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
              <td>
              $next
              </td>
            </tr>
          </table>
          </center>
        </div>
";
} elseif ($post_start + $post_limit >= $num_posts) {
$page_flipper = "
        <div align=\"center\">
          <center>
          <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
              <td>
              $prev
              </td>
            </tr>
          </table>
          </center>
        </div>
";
} else {
$page_flipper = "
        <div align=\"center\">
          <center>
          <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
              <td>
              $prev
              $next
              </td>
            </tr>
          </table>
          </center>
        </div>
";
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
echo $newsblock;
echo $page_flipper;
$w3c = TRUE;
include($root."inc/bottom.html");
?>
