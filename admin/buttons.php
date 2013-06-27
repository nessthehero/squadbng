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
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "admin";
$level = rank($_SESSION[username]);
$page_title = "Upload the site buttons";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$numadmin = 0;
$numjudge = 0;
$numsquad = 0;

if (isset($_POST[a])) {
        $e_type = $_POST[a];
        $e_id = $_POST[id];
        $e_place = $_POST[place];
        $e_source = $_POST[source];
        $e_active = $_POST[active];
        $e_page = $_POST[page];
        $e_action = $_POST[action];

        $up_place = $e_place - 1;
        $down_place = $e_place + 1;
        
        if ($e_action == "delete") {
                $sql = "DELETE FROM buttons WHERE id = '$e_id'";
                @mysql_query($sql, $connection) or die(mysql_error());
        }
        if ($e_action == "update") {
                $sql[] = "UPDATE buttons SET dest = '$e_page' WHERE id = '$e_id'";
                $sql[] = "UPDATE buttons SET path = '$e_source' WHERE id = '$e_id'";
                $sql[] = "UPDATE buttons SET type = '$e_type' WHERE id = '$e_id'";
                $sql[] = "UPDATE buttons SET active = '$e_active' WHERE id = '$e_id'";
        }
        if ($e_action == "up") {
                $sql[] = "UPDATE buttons SET type_id=type_id-1 WHERE id = '$e_id'";
                $sql[] = "UPDATE buttons SET type_id=type_id+1 WHERE type_id = '$up_place'";
        }
        if ($e_action == "down") {
                $sql[] = "UPDATE buttons SET type_id=type_id+1 WHERE id = '$e_id'";
                $sql[] = "UPDATE buttons SET type_id=type_id-1 WHERE type_id = '$down_place'";                
        }
		foreach ($sql as $s) {
				@mysql_query($s, $connection) or die(mysql_error());
		}
}

if (isset($_GET[png])) {
        $img_error = "<br><center>Image is not a .PNG file!</center><br>";
} else {
        $img_error = "";
}

//Find highest button number for each type. Required to perform some features, such as moving the buttons.
$sql = "SELECT Count(*) AS count FROM buttons WHERE type = 'admin'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
$numadmin = mysql_result($result,0,'count');

$sql = "SELECT Count(*) AS count FROM buttons WHERE type = 'judge'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
$numjudge = mysql_result($result,0,'count');

$sql = "SELECT Count(*) AS count FROM buttons WHERE type = 'squad'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
$numsquad = mysql_result($result,0,'count');

//Get form blocks prepared
$sql = "SELECT * FROM buttons WHERE type = 'admin' ORDER BY type_id";
$result = @mysql_query($sql,$connection) or die(mysql_error());
$check = mysql_num_rows($result);
if ($check > "0") {
        while ($row = mysql_fetch_array($result)) {
                $type = $row[type];
                $type_id = $row[type_id];
                $id = $row[id];
                $page = $row[dest];
                $source = $row[path];
                $active = $row[active];
                if ($active == "yes") {
                        $yescheck = "<input type=\"radio\" value=\"yes\" checked name=\"active\">";
                        $nocheck = "<input type=\"radio\" value=\"no\" name=\"active\">";
                } else {
                        $page = $site_dir."underconstruction.php";
                        $nocheck = "<input type=\"radio\" value=\"no\" checked name=\"active\">";
                        $yescheck = "<input type=\"radio\" value=\"yes\" name=\"active\">";
                }
                if ($type_id == 1) {
                        $admin_direction_up = "";
                        $admin_direction_down = "<option value=\"down\">Move down</option>";
                } elseif ($type_id == $numadmin) {
                        $admin_direction_up = "<option value=\"up\">Move up</option>";
                        $admin_direction_down = "";
                } elseif ($numadmin == 1) {
                        $admin_direction_up = "";
                        $admin_direction_down = "";
                } else {
                        $admin_direction_up = "<option value=\"up\">Move up</option>";
                        $admin_direction_down = "<option value=\"down\">Move down</option>";
                }
                $buttons_admin .= "
                <tr>
                          <form method='post' action='".$_SERVER[PHP_SELF]."'>
                          <input type='hidden' name='a' value='admin'>
                          <input type='hidden' name='place' value='$type_id'>
                          <input type='hidden' name='id' value='$id'>
                          <!-- <input type='hidden' name='' value=''> -->
                            <td width='92'>
                            	<img border='0' src='".$site_dir."CSS/".$source."' alt='' />
                            </td>
                            <td width='371'>
                              <table border='0' width='100%'>
                                <tr>
                                  <td width='17%' style='text-align: right;'>
                                    Source:
                                  </td>
                                <center>
                                <center>
                                  <td width='65%'><input type='text' name='source' value='$source' size='32'></td>
                                  <td width='18%' rowspan='2'>
                                    <p align='center'>Active
                                    <table border='0' width='100%' height='39'>
                                      <tr>
                                        <td width='50%' height='14' align='right'>Yes:</td>
                                        <td width='50%' height='14'>$yescheck</td>
                                      </tr>
                                      <tr>
                                        <td width='50%' height='13' align='right'>No:</td>
                                        <td width='50%' height='13'>$nocheck</td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                               <tr>
                                  <td width='17%' align='right'>Page:</td>
                                  <td width='65%'><input type='text' name='page' value='$page' size='32'></td>
                                </tr>
                              </table>
                            </td>
                            <td width='67' align='center'>
                                <select size='1' name='action'>
                                  <option value='update' selected>Submit Values</option>
                                  <option value='delete'>Delete</option>
                                  $admin_direction_up
                                  $admin_direction_down
                                </select>
                                <br>
                              <br>
                              <input type='submit' value='Update Button' name='update'>
                            </td>
                          </form>
                          </tr>
                ";
        }
}

$sql = "SELECT * FROM buttons WHERE type = 'judge' ORDER BY type_id";
$result = @mysql_query($sql,$connection) or die(mysql_error());
$check = mysql_num_rows($result);
if ($check > "0") {
        while ($row = mysql_fetch_array($result)) {
                $type = $row[type];
                $type_id = $row[type_id];
                $id = $row[id];
                $page = $row[dest];
                $source = $row[path];
                $active = $row[active];
                if ($active == "yes") {
                        $yescheck = "<input type=\"radio\" value=\"yes\" checked name=\"active\">";
                        $nocheck = "<input type=\"radio\" value=\"no\" name=\"active\">";
                } else {
                        $page = $site_dir."underconstruction.php";
                        $nocheck = "<input type=\"radio\" value=\"no\" checked name=\"active\">";
                        $yescheck = "<input type=\"radio\" value=\"yes\" name=\"active\">";
                }
                if ($type_id == 1) {
                        $judge_direction_up = "";
                        $judge_direction_down = "<option value=\"down\">Move down</option>";
                } elseif ($type_id == $numjudge) {
                        $judge_direction_up = "<option value=\"up\">Move up</option>";
                        $judge_direction_down = "";
                } elseif ($numjudge == 1) {
                        $judge_direction_up = "";
                        $judge_direction_down = "";
                } else {
                        $judge_direction_up = "<option value=\"up\">Move up</option>";
                        $judge_direction_down = "<option value=\"down\">Move down</option>";
                }
                $buttons_judge .= "
                <tr>
                          <form method=\"post\" action=\"".$_SERVER[PHP_SELF]."\">
                          <input type=\"hidden\" name=\"a\" value=\"judge\">
                          <input type=\"hidden\" name=\"place\" value=\"$type_id\">
                          <input type=\"hidden\" name=\"id\" value=\"$id\">
                          <!-- <input type=\"hidden\" name=\"\" value=\"\"> -->
                            <td width=\"92\">

                            <img border=\"0\" src=\"".$site_dir."CSS/".$source."\">

                            </td>
                        </center>
                        </center>
                            <td width=\"371\">
                              <table border=\"0\" width=\"100%\">
                                <tr>
                                  <td width=\"17%\" align=\"right\">
                                    <p align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Source:</font></p>
                                  </td>
                                <center>
                                <center>
                                  <td width=\"65%\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\"><input type=\"text\" name=\"source\" value=\"$source\" size=\"32\"></font></td>
                                  <td width=\"18%\" rowspan=\"2\">
                                    <p align=\"center\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Active</font>
                                    <table border=\"0\" width=\"100%\" height=\"39\">
                                      <tr>
                                        <td width=\"50%\" height=\"14\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Yes:</font></td>
                                        <td width=\"50%\" height=\"14\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">
                                        $yescheck
                                        </font></td>
                                      </tr>
                                      <tr>
                                        <td width=\"50%\" height=\"13\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">No:</font></td>
                                        <td width=\"50%\" height=\"13\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">
                                        $nocheck
                                        </font></td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td width=\"17%\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Page:</font></td>
                                  <td width=\"65%\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\"><input type=\"text\" name=\"page\" value=\"$page\" size=\"32\"></font></td>
                                </tr>
                              </table>
                            </td>
                            <td width=\"67\" align=\"center\">
                                <select size=\"1\" name=\"action\">
                                  <option value=\"update\" selected>Submit Values</option>
                                  <option value=\"delete\">Delete</option>
                                  $judge_direction_up
                                  $judge_direction_down
                                </select>
                                <br>
                              <br>
                              <input type=\"submit\" value=\"Update Button\" name=\"update\">
                            </td>
                          </form>
                          </tr>
                ";
        }
}

$sql = "SELECT * FROM buttons WHERE type = 'squad' ORDER BY type_id";
$result = @mysql_query($sql,$connection) or die(mysql_error());
$check = mysql_num_rows($result);
if ($check > 0) {
        while ($row = mysql_fetch_array($result)) {
                $type = "squad";
                $type_id = $row[type_id];
                $id = $row[id];
                $page = $row[dest];
                $source = $row[path];
                $active = $row[active];
                if ($active == "yes") {
                        $yescheck = " checked ";
                        $nocheck = "";
                } else {
                        $page = $site_dir."underconstruction.php";
                        $nocheck = " checked ";
                        $yescheck = "";
                }
                if ($type_id == 1) {
                        $squad_direction_up = "";
                        $squad_direction_down = "<option value=\"down\">Move down</option>";
                } elseif ($numsquad == 1) {
                        $squad_direction_up = "";
                        $squad_direction_down = "";
                } elseif ($type_id == $numadmin) {
                        $squad_direction_up = "<option value=\"up\">Move up</option>";
                        $squad_direction_down = "";
                } else {
                        $squad_direction_up = "<option value=\"up\">Move up</option>";
                        $squad_direction_down = "<option value=\"down\">Move down</option>";
                }
                $buttons_squad .= "
                <tr>
                          <form method=\"post\" action=\"$_SERVER[PHP_SELF]\">
                          <input type=\"hidden\" name=\"a\" value=\"squad\">
                          <input type=\"hidden\" name=\"place\" value=\"$type_id\">
                          <input type=\"hidden\" name=\"id\" value=\"$id\">
                          <!-- <input type=\"hidden\" name=\"\" value=\"\"> -->
                            <td width=\"92\">

                            <img border=\"0\" src=\"".$site_dir."CSS/".$source."\">

                            </td>
                        </center>
                        </center>
                            <td width=\"371\">
                              <table border=\"0\" width=\"100%\">
                                <tr>
                                  <td width=\"17%\" align=\"right\">
                                    <p align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Source:</font></p>
                                  </td>
                                <center>
                                <center>
                                  <td width=\"65%\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\"><input type=\"text\" name=\"source\" value=\"$source\" size=\"32\"></font></td>
                                  <td width=\"18%\" rowspan=\"2\">
                                    <p align=\"center\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Active</font>
                                    <table border=\"0\" width=\"100%\" height=\"39\">
                                      <tr>
                                        <td width=\"50%\" height=\"14\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Yes:</font></td>
                                        <td width=\"50%\" height=\"14\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\"><input type=\"radio\" value=\"yes\" $yescheck name=\"active\"></font></td>
                                      </tr>
                                      <tr>
                                        <td width=\"50%\" height=\"13\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">No:</font></td>
                                        <td width=\"50%\" height=\"13\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\"><input type=\"radio\" value=\"no\" $nocheck name=\"active\"></font></td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td width=\"17%\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Page:</font></td>
                                  <td width=\"65%\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\"><input type=\"text\" name=\"page\" value=\"$page\" size=\"32\"></font></td>
                                </tr>
                              </table>
                            </td>
                            <td width=\"67\" align=\"center\">
                                <select size=\"1\" name=\"action\">
                                  <option value=\"update\" selected>Submit Values</option>
                                  <option value=\"delete\">Delete</option>
                                  $squad_direction_up
                                  $squad_direction_down
                                </select>
                                <br>
                              <br>
                              <input type=\"submit\" value=\"Update Button\" name=\"update\">
                            </td>
                          </form>
                          </tr>
                ";

        }
}

$header = "";
include($root."inc/top.html");
?>


                <div align="center">
                  <center>
                  <table border="0" width="95%" cellpadding="10">
                    <tr>
                    <td>
                    <div align="center">
                      <center>
                      <table border="0" width="54%">
                        <tr>
                          <td width="100%">
                            <form method="POST" action="submitbutton.php" ENCTYPE="multipart/form-data">
                            <input type="hidden" name="numadmin" value="<? echo $numadmin; ?>">
                            <input type="hidden" name="numjudge" value="<? echo $numjudge; ?>">
                            <input type="hidden" name="numsquad" value="<? echo $numsquad; ?>">
                              <p align="center">Submit a Button<br/>
                              (Image must be a .PNG File)<br/>
                              <? echo "$img_error"; ?></p>
                              <table border="0" width="101%">
                                <tr>
                                  <td width="25%" align="right">File:</td>
                                  <td width="75%" colspan="2"><input type="file" name="button"></td>
                                </tr>
                                <tr>
                                  <td width="25%" align="right">Page:</td>
                                  <td width="75%" colspan="2"><input type="text" name="page" size="32"></td>
                                </tr>
                                <tr>
                                  <td width="25%" align="right">Active:</td>
                                  <td width="38%" align="center">Yes<input type="radio" value="yes" checked name="active"></td>
                                  <td width="39%" align="center">No<input type="radio" name="active" value="no"></td>
                                </tr>
                                <tr>
                                  <td width="100%" colspan="3" style="text-align: center;">
                                    <select size="1" name="select_type">
                                      <option value="admin" selected>Administration</option>
                                      <option value="judge">Judges</option>
                                      <option value="squad">Squad Site</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                 <td width="100%" colspan="3">
                                    <p align="center"><input type="submit" value="Submit this Button" name="submit"></p>
                                  </td>
                                </tr>
                              </table>
                            </form>
                            </td>
                        </tr>
                      </table>
                      </center>
                    </div>
                    </td>
                    </tr>
                    <tr>

                    <!-- Admin Buttons Start -->

                      <td width="100%">

                        <div align="center">
                        <table border="1" width="552" bordercolorlight="#4A92CD" bordercolordark="#0000FF" bordercolor="#4A92CD">
                          <tr>
                            <td width="502" colspan="3">
                              <p align="center"><font face="Verdana" color="#E0B95B" size="1">
                              Admin Buttons
                              </font></p>
                            </td>
                          </tr>

                          <!-- Start repeating table -->
                          <? echo "$buttons_admin"; ?>
                          <!-- End Repeating Table -->

                        </table>
                        </div>

                      </td>

                    <!-- Admin Buttons End -->

                    </tr>
                    <tr>

                    <!-- Judge Buttons Start -->

                      <td width="100%">

                        <div align="center">
                        <table border="1" width="552" bordercolorlight="#4A92CD" bordercolordark="#0000FF" bordercolor="#4A92CD">
                          <tr>
                            <td width="502" colspan="3">
                              <p align="center"><font face="Verdana" color="#E0B95B" size="1">
                              Judge Buttons
                              </font></p>
                            </td>
                          </tr>

                          <!-- Start repeating table -->
                          <? echo "$buttons_judge"; ?>
                          <!-- End Repeating Table -->

                        </table>
                        </div>

                      </td>

                    <!-- Judge Buttons End -->

                    </tr>
                    <tr>

                    <!-- Normal Buttons Start -->

                    <td width="100%">
                      <form method="get" action="">
                        <div align="center">
                        <table border="1" width="552" bordercolorlight="#4A92CD" bordercolordark="#0000FF" bordercolor="#4A92CD">
                          <tr>
                            <td width="502" colspan="3">
                              <p align="center"><font face="Verdana" color="#E0B95B" size="1">Normal
                              Buttons</font></p>
                            </td>
                          </tr>

                          <!-- Start repeating table -->
                          <? echo "$buttons_squad"; ?>
                          <!-- End Repeating Table -->

                        </table>
                        </div>
                        </form>
                      </td>

                       <!-- Normal Buttons End -->

                    </tr>
                  </table>
                </div>



<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>