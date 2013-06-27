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

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
if (isset($_POST[action])) {
        if ($_POST[action] == "upload") {
                $a_name = $_POST[award_name];
                $rank = $_POST[award_rank];
                $a_image = $_FILES[award_image][name];
                $from = $_FILES[award_image][tmp_name];
                if (!file_exists($uploaddir."awards/")) {
                        mkdir($uploaddir."awards/",0777);
                }
                $to = $uploaddir."awards/".$a_image;
                $a_description = $_POST[award_description];
                move_uploaded_file($from, $to) or die("Could not upload image");
                $sql = "INSERT INTO images VALUES ('', 'award', '$a_image', '$a_name', '$a_description', '$rank')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
        }
        if ($_POST[action] == "award") {
                $members = array();
                $awards = array();
                $notes = $_POST[notes];
                $members = $_POST[squadmembers];
                $awards = $_POST[award_names];
                for ($i = 0; $i <= sizeof($members)-1; $i++) {
                        for ($j = 0; $j <= sizeof($awards)-1; $j++) {
                                $sql = "SELECT * FROM images WHERE id = '$awards[$j]'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        $id = $row[id];
                                        $level = $row[misc_2];
                                }
                                $sql = "INSERT INTO awards VALUES ('', '$id', '$members[$i]', '$level', '$notes')";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                }
        }
        if ($_POST[action] == "alter") {
                if ($_POST[alter_action] == "delete") {
                        $id = array();
                        $id = $_POST[img_id];
                        for ($i = 0; $i <= sizeof($id)-1; $i++) {
                                $sql = "DELETE FROM awards WHERE img_id = '$id[$i]'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                $sql = "DELETE FROM images WHERE id = '$id[$i]'";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                        }
                }
        }
}

$page_topimg = "admin";
$level = "admin";
$page_title = "Upload and hand out squad awards!";

$header = "";
include($root."inc/top.html");
?>
<div align="center">
<center>
<form method="POST" action="award.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="upload">
<table border="0" width="74%" cellspacing="0" cellpadding="0">
        <tr>
                <td width="100%" colspan="2">
                        <p align="center">
                        Upload new award
                        </p>
                </td>
        </tr>
        <tr>
                <td width="38%">
                        <p align="right">
                        Name of award:
                        </p>
                </td>
                <td width="62%">
                    <p align="left">
                        <input type="text" name="award_name" size="33">
                    </p>
                </td>
        </tr>
        <tr>
                <td width="38%">
                        <p align="right">
                        Upload picture:
                        </p>
                </td>
                <td width="62%">
                    <p align="left">
                    <input type="file" name="award_image">
                    </p>
            </p>
                </td>
        </tr>
        <tr>
                <td width="38%">
                        <p align="right">
                        Description of award:
                        </p>
                </td>
                <td width="62%">
                    <p align="left">
                        <textarea name="award_description" rows="3" cols="34"></textarea>
                    </p>
                </td>
        </tr>
        <tr>
                <td width="38%">
                        <p align="right">
                        Rank of Award:
                        </p>
                </td>
                <td width="62%">
                        <p align="left">
                        <select name="award_rank">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                           <!-- <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option> -->
                        </select>
                        </p>
                </td>
        </tr>
        <tr>
                <td width="100%" colspan="2">
                        <p align="center">
                        <input type="Submit" value="Set New Award">
                        <input type="reset" value="Reset">
                        </p>
                </td>
        </tr>
</table>
</form>
<br>
<form method="POST" action="award.php">
<input type="hidden" name="action" value="award">
<table border="0" width="240" height="63">
        <tr>
                <td width="230" height="28">
                        <p align="center">
                        Apply<br>
                        </p>
                        <select size="10" name="award_names[]" multiple>
                                <?
                                $sql = "SELECT * FROM images WHERE class = 'award' AND misc_2 != '1' ORDER BY misc_2";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        echo "<option value=\"$row[id]\">$row[name]</option>\n";
                                }
                                if (mysql_num_rows($result) == 0) {
                                        echo "<option>No awards yet</option>\n";
                                }
                                ?>
                        </select>
                </td>
                <td width="215" height="28">
                        <p align="center">
                        To<br>
                        </p>
                        <select size="10" name="squadmembers[]" multiple>
                                <?
                                $sql = "SELECT * FROM squadmembers ORDER BY username";
                                $result = @mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        echo "<option value=\"$row[id]\">$row[username]</option>\n";
                                }
                                ?>
                        </select>
                </td>
        </tr>
        <tr>
                <td colspan="2">
                        <center>
                        Enter any notes about the award (Optional):<br>
                        <textarea name="notes" rows="3" cols="34"></textarea>
                        </center>
                </td>
        </tr>
        <tr>
                <td width="426" colspan="2" height="27">
                        <p align="center">
                        <input type="submit" value="Go for it!">
                        </p>
                </td>
        </tr>
</table>
</form>
<br>
<form method="POST" action="award.php">
<input type="hidden" name="action" value="alter">
<table border="0" width="570">
        <tr>
                <th width="67">
                        Award
                </th>
                <th width="113">
                        Name
                </th>
                <th width="211">
                        Description
                </th>
                <th width="100">
                        # awarded
                </th>
                <th width="45">
                        Rank
                </th>
                <th width="26">
                </th>
        </tr>
        <?
        $sql = "SELECT * FROM images WHERE class = 'award' ORDER BY misc_2";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $img_id = $row[id];
                $award_img = $row[filename];
                $award_name = $row[name];
                $award_description = $row[misc];
                $rank = $row[misc_2];
                $num_given = 0;
                $sql_2 = "SELECT * FROM awards WHERE img_id = '$img_id'";
                $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row_2 = mysql_fetch_array($result_2)) {
                        $num_given++;
                }
                echo "
                <tr>
                <td width=\"67\" align=\"center\"><img src=\"".$site_dir."awards/".$award_img."\" ALT=\"".$award_name."\"></td>
                <td width=\"113\" align=\"center\">$award_name</td>
                <td width=\"211\" align=\"center\">$award_description</td>
                <td width=\"100\" align=\"center\">$num_given</td>
                <td width=\"45\" align=\"center\">$rank</td>
                <td width=\"26\" align=\"center\"><input type=\"checkbox\" name=\"img_id[]\" value=\"$img_id\"></td>
                </tr>
                ";
        }
        ?>
        <tr>
                <td width="517" align="center" colspan="6">
                        Action to do with checked awards:
                        <select size="1" name="alter_action">
                                <option value="delete" selected>
                                Delete
                                </option>
                      </select>
                      <input type="submit" value="Go for it!">
                </td>
        </tr>

</table>
</form>
</center>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
