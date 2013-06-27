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
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = rank($_SESSION[username]);
$page_title = "Upload a match";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$key    = get_key();
$t_name = get_tourn_var($key, "name");
$game   = get_tourn_var($key, "game");
$teams  = get_tourn_var($key, "teams");
$rec_method  = get_tourn_var($key, "rec_method");
$method_name  = get_tourn_var($key, "method_name");

$e_msg1 = "";
$e_msg2 = "";

if (isset($_POST[ds])) {
        
        if ($_POST[p1score] == $_POST[p2score]) {
		
				$e_msg1 = "A tie cannot be uploaded to the database.";
				$e_msg2 = "Please redo this match and upload new scores.";

        } elseif ((!is_numeric($_POST[p1score])) || (!is_numeric($_POST[p2score]))) {
		
				$e_msg1 = "The score must be NUMBERS, not WORDS.";
				$e_msg2 = "Please redo this match and upload new scores.";
				 
        } else {

                $p = array();
        
                $sql = "SELECT * FROM matches WHERE match_id = '$_POST[match_id]' AND t_key = '$key'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        if ($row[box_id] == 1) {
                                $p[1] = $row[contender];
                        } else {
                                $p[2] = $row[contender];
                        }
                }
                $sql = array();
                $sql[] = "UPDATE matches SET score = '$_POST[p1score]' WHERE match_id = '$_POST[match_id]' AND box_id = 1";
                $sql[] = "UPDATE matches SET score = '$_POST[p2score]' WHERE match_id = '$_POST[match_id]' AND box_id = 2";
                $sql[] = "UPDATE matches SET done = 'YES' WHERE match_id = '$_POST[match_id]'";

                if (($rec_method != NULL) && ($rec_method != "")) {

						switch ($rec_method) {
							case "log":
								$log_name = team_name($p[1])."_vs_".team_name($p[2]).'['.$key.']'.".txt";
								break;								
							default:
								$log_name = team_name($p[1])."_vs_".team_name($p[2]).'['.$key.']'.".".substr($_FILES[match_rec][name],-1,3);
								break;
						}
                        
                        $from = $_FILES[match_rec][tmp_name];
                        if (!file_exists($uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name)))) {
                                mkdir($uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name)));
                                mkdir($uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name))."/logs/", 0777);
                        }
                        $to = $uploaddir."tournaments/".$game."/".str_replace(" ","_",strtolower($t_name))."/logs/".$log_name;
                        $log_location = "tournaments/".$game."/".str_replace(" ","_",strtolower($t_name))."/logs/".$log_name;
                        copy($from,$to) or die("Could not upload log. Please contact administrator.");
                        $sql[] = "INSERT INTO logs VALUES ('', '$key', '$_POST[match_id]', '$log_location')";
                }
                foreach ($sql as $s) {
                        @mysql_query($s,$connection) or die(mysql_error());
                }
                header("Location: ".$admindir."match.php");
                exit;
                
        }
}

if (($e_msg1 != "") && ($e_msg2 != "")) {
	$error = "
                <br /><br />
                <div class='error'>
                $e_msg1<br />
                $e_msg2<br />
                </div>
			";
}

$i = 1;
$matches_left = FALSE;
$round = get_round($key);
unset($matches);
unset($fighters);
$matches = array();
$fighters = array();
$sql = "SELECT * FROM matches WHERE round = '$round' AND done = 'NO' ORDER BY match_id, box_id ASC";
$result = @mysql_query($sql, $connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[box_id] == 1) {
                $p[1] = $row[contender];
        } else {
                $p[2] = $row[contender];
                if ($p[2] !== "UNEVEN") {
                        array_push($matches, $row[match_id]);
                        array_push($fighters, team_name($p[1])." vs ".team_name($p[2]));
                        $matches_left = TRUE;
                }
        }

}


$header = "";
include($root."inc/top.html");
?>
<div align="center">
	Upload a Match
	<? echo $error; ?>
	<hr width="75%">

	<form method="POST" action="match.php" enctype="multipart/form-data">
		<input type="hidden" name="ds" value="true">
		<div align="center">

			<div class="form">
				Match: <select size="1" name="match_id">
				<?
					if ($matches_left) {
						$i = mysql_num_rows($result);
						foreach ($matches as $key => $m) {
							echo "<option value='$m'>$fighters[$key]</option>\n";
						}
					} else {
						echo "<option value='0'>No matches left</option>";
					}
				?>
				</select>
			</div>
			<br />
			<div class="form">
				Player 1 Score: <input type="text" name="p1score" size="3" maxlength="5"><br />			
				Player 2 Score: <input type="text" name="p2score" size="3" maxlength="5">
			</div>
			<div class="form">
				<?
					$sql = "SELECT rec_method, method_name FROM games WHERE game = '$game'";
					$result = @mysql_query($sql, $connection) or die(mysql_error());
					while ($row = mysql_fetch_array($result)) {
						$recm_name = $row[method_name];
						if (($row[rec_method] == "none") || ($row[rec_method] == null)) {
							echo "";
						} else {
							$recm_name = ucfirst($recm_name);
							echo "Upload $recm_name: <input type=\"file\" name=\"match_rec\">\n";
						}
					}
				?>
			</div>
			<div class="form">
				<input type="submit" value="Submit Match" name="submit">
			</div>
		</div>
	</form>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
