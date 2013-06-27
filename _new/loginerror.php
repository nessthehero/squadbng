<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

$page_topimg = "squad";
$level = "squad";
$page_title = "Login error!";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$loginpage = "accountlogin.php";
$createpage = "apply.php";
include($root."inc/top.html");
?>
                                <div align="center">
          <center>
          <table border="0" width="70%">
            <tr>
              <td width="100%">
              <center>
              <font face="Verdana" size="1" color="#FFCC99">
              Login Error!
              </font>
              </center>
              <hr>
              <center>
              <font face="Verdana" size="1" color="#FFCC99">
              <?
              if ($_SESSION[error] == "noname") {
                        $msg = "That username does not exist in our database.<br><br>\n";
                        $msg .= "Either return to the log in screen to try again or create an admin screenname.<br><br>\n";
                        $msg .= "<a href=\"$loginpage\">Return to log in area</a><br>\n";
                        $msg .= "<a href=\"$createpage\">Create a username</a>";
              } elseif ($_SESSION[error] == "badpass") {
                        $msg = "The password you entered is incorrect.<br><br>\n";
                        $msg .= "Either return to the log in screen to try again or use the Lost Password function.<br><br>\n";
                        $msg .= "<a href=\"$loginpage\">Return to log in area</a><br>\n";
                        $msg .= "<a href=\"lostpassword.php\">Lost Password</a>";
              } else {
                        $msg = "There is no determinable error. Please return to the login area.<br><br>\n";
                        $msg .= "<a href=\"$loginpage\">Return to log in area</a><br>\n";
                        $msg .= "<a href=\"$createpage\">Create a username</a>";
              }
              echo "$msg";
              ?>
              </font>
              </center>
              </td>
            </tr>
          </table>
          </center>
        </div>

<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
