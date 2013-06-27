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
$page_title = "Comment on $commenting_on";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$c_type = $_GET[type];
$c_id = $_GET[id];

if ($_POST[commenting]) {
        $c_title = $_POST[c_title];
        $c_post = $_POST[comment];
        $c_who = $_POST[who];
        $day = $_POST[day];
        $month = $_POST[month];
        $year = $_POST[year];
        $time = $_POST[hour].":".$_POST[minute].":".$_POST[seconds]." ".$_POST[ampm]." ".$_POST[tz];
        $sql = "INSERT INTO comments VALUES ('', '$c_who', '$c_post', '$c_title', '$day', '$month', '$year', '$time', '$c_type', '$c_id')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $success_msg = "<font color=\"red\"><b>Commented successfully</b></font>";
}

if ($_GET[del]) {
        $sql = "DELETE FROM comments WHERE id = '$_GET[del]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$site_dir."comments.php?type=news&id=".$_GET[id]);
        exit;
}

if ($c_type == "news") {
        $sql = "SELECT * FROM news WHERE id = '$c_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $poster = $row[poster];
                $avatar = $site_dir.$row[avatar];
                $post_name = $row[title];
                $post = nl2br($row[post]);
                $post_date = "Posted on ".$row[month]." ".$row[day].", ".$row[year]." at ".$row[time];
        }
        $commenting_on = $poster."'s news post";
        $sql = "SELECT * FROM comments WHERE type = '$c_type' AND type_id = '$c_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if (rank($_SESSION[username]) == "admin") {
                        $delete_link = "<br><a href=\"".$site_dir."comments.php?del=".$row[id]."&id=".$c_id."\">[-Delete-]</a>";
                }
                $who = $row[who];
                $comment = nl2br($row[comment]);
                $what = $row[title]."<br>";
                $when = $row[month]." ".$row[day].", ".$row[year]." -- ".$row[time];
                $comment_block .= "
                <tr>
                        <td width=\"100%\">
                            <div align=\"center\">
                              <table border=\"0\" width=\"47%\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                  <td width=\"26%\">
                                    <center>$who</center>
                                    </td>
                                  <td width=\"74%\">
                                    <center>
                                    $what
                                    $when
                                    $delete_link
                                    </center>
                                    </td>
                                </tr>
                                <tr>
                                  <td width=\"100%\" colspan=\"2\">
                                    <p align=\"left\">$comment</p>
                                  </td>
                                </tr>
                              </table>
                            </div>
                          </td>
                        </tr>
                ";
        }
        $page = "
                        <center>$success_msg</center>
                        <div align=\"center\">
                        <table border=\"0\" width=\"71%\" cellspacing=\"0\" cellpadding=\"0\">
                          <tr>
                            <td width=\"16%\" bgcolor=\"#000080\">
                              <center><img src=\"$avatar\" title=\"$poster\"></center>
                              </td>
                            <td width=\"84%\" bgcolor=\"#000080\">
                              <center>
                              $post_name<br>
                              $post_date
                              </center>
                              </td>
                          </tr>
                          <tr>
                            <td width=\"100%\" colspan=\"2\">
                            <p align=\"left\">
                            $post</p>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <hr width=\"40%\">
                      <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
                        <tr>
                         $comment_block
                        </tr>
                      </table>
                                                  <br><br>
                            <form method=\"POST\" name=\"comment\" action=\"comments.php?type=".$c_type."&id=".$c_id."\">
                            <input type=\"hidden\" name=\"commenting\" value=\"yes\">
                            <input type=\"hidden\" name=\"who\" value=\"".$_SESSION[username]."\">
                              <div align=\"center\">
                                <center>
                              <table border=\"0\" width=\"82%\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                  <td width=\"100%\" colspan=\"2\">
                                    <p align=\"center\"><input type=\"text\" name=\"month\" size=\"10\" style=\"text-align: right\" class=\"date\"><font color=\"#E0B95B\" size=\"1\" face=\"Verdana\"><input type=\"text\" name=\"day\" size=\"2\" style=\"text-align: right\" class=\"date\">,<input type=\"text\" name=\"year\" size=\"4\" style=\"text-align: right\" class=\"date\"><input type=\"text\" name=\"hour\" size=\"2\" style=\"text-align: right\" class=\"date\">:<input type=\"text\" name=\"minute\" size=\"2\" style=\"text-align: right\" class=\"date\">:<input type=\"text\" name=\"seconds\" size=\"2\" style=\"text-align: right\" class=\"date\"><input type=\"text\" name=\"ampm\" size=\"3\" style=\"text-align: right\" class=\"date\"><select size=\"1\" name=\"tz\" class=\"date\">
                                    <select>
                                                  <option selected>EST</option>
                                                  <option>PST</option>
                                                  <option>CST</option>
                                                  <option>MST</option>
                                    </font>
                                    </select></p>
                                  </td>
                                </tr>
                                <tr>
                                  <td width=\"16%\">
                                    <p align=\"center\">Title</td>
                                  <td width=\"84%\">
                                    <p align=\"center\"><input type=\"text\" name=\"c_title\" size=\"68\"></td>
                                </tr>
                                <tr>
                                  <td width=\"100%\" colspan=\"2\">
                                    <p align=\"center\"><textarea rows=\"4\" name=\"comment\" cols=\"77\"></textarea></td>
                                </tr>
                                <tr>
                                  <td width=\"100%\" colspan=\"2\">
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
                          </td>


        ";
} elseif ($c_type == "bio") {
        header("Location: ".$site_dir."home.php");
        exit;
} else {
        header("Location: ".$site_dir."home.php");
        exit;
}

$header = "<SCRIPT LANGUAGE=\"JavaScript\">
<!--  Clock --
var timerID = null
var timerRunning = false

months = new Array()
months[1] = \"January\"
months[2] = \"February\"
months[3] = \"March\"
months[4] = \"April\"
months[5] = \"May\"
months[6] = \"June\"
months[7] = \"July\"
months[8] = \"August\"
months[9] = \"September\"
months[10] = \"October\"
months[11] = \"November\"
months[12] = \"December\"

function stopclock(){
    if(timerRunning)
        clearTimeout(timerID)
    timerRunning = false
}

function startclock(){
    stopclock()
    showtime()
}

function showtime(){
    var now = new Date()
    var month = (now.getMonth()+1)
    var hours = now.getHours()
    var minutes = now.getMinutes()
    var seconds = now.getSeconds()
    var year = now.getFullYear()
    var day = now.getDate()
    var ampm = (hours >= 12) ? \" P.M.\" : \" A.M.\"
    document.comment.month.value = months[month]
    document.comment.day.value = day
    if (day.length==1) {
        day=\"0\"+day
    }
    document.comment.year.value = year
    document.comment.hour.value = (hours > 12) ? (hours-12) : (hours)
    document.comment.minute.value = minutes
    document.comment.seconds.value = seconds
    document.comment.ampm.value = ampm
    timerID = setTimeout(\"showtime()\",1000)
    timerRunning = true
}
//-->
</SCRIPT>
<style type=\"text/css\">
.date {
        border-top-width: 0px;
        border-right-width: 0px;
        border-bottom-width: 0px;
        border-left-width: 0px;
}
</style>
";
$onload = "onLoad=\"startclock()\"";
include($site_dir."top.html");
echo $page;
include($site_dir."bottom.html");
?>
