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
$page_title = "Add a new Squad Game";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (isset($_GET['edit_id'])) {
	echo "YEEESSSSS";
	$header = "
	<style type='text/css'>
		.bannerform { display: none; }
	</style>
	";
	
	$edit_id = (int)$_GET['edit_id'];
	
	$sql = "SELECT * FROM games WHERE id = '$edit_id'";
	//id, game, key, description, rec_method, method_name, site, banner, tourneys

	$edit = array();

	$result = @mysql_query($sql,$connection) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {   
		echo 1;    
		$edit['name'] = $row['game'];
		$edit['description'] = $row['description'];
		$edit['method'] = $row['method_name'];                
		$edit['site'] = $row['site'];                
		$edit['warning'] = "<font color=\"red\">Don't forget to redo the tournament info!</font>";                
		$edit['banner'] = "<input type=\"hidden\" name=\"e_banner\" value=\"$row[banner]\">";                
		$edit['tourn'] = $row['tourneys'];
	}
} else {
echo "NOOOO";
}

if ($_POST[ds] == "op") {
	$game = $_POST[name];
	$key = strtolower(ereg_replace(" ","_",$game));
	$description = trim($_POST[description]);
	$site = $_POST[homepage];
	$from = $_FILES[banner][tmp_name];        
	if ((!isset($e_banner)) && (isset($from))) {
		if (!file_exists($uploaddir."images/banners/")) {
			mkdir($uploaddir."images/banners/",0777);
		}
		$to = $uploaddir."images/banners/".$_FILES[banner][name];
		$banner = "images/banners/".$_FILES[banner][name];
		@copy($from,$to) or die("Could not upload image");        
	} else {        
		$banner = $_POST[e_banner];
	}
	$t_capable = $_POST[t_capable];
	if ($t_capable == "yes") {
		$recording_method = $_POST[recording_method];
		$method_name = $_POST[method_name];
	}
	//id, game, key, description, rec_method, method_name, site, banner, tourneys
	if (isset($_POST[editing])) {
		$sql= "REPLACE INTO games VALUES ('$_POST[editing]', '$game', '$key', '$description', '$recording_method', '$method_name', '$site', '$banner', '$_POST[tourneys]')";
		$result = @mysql_query($sql,$connection) or die(mysql_error());
		header("Location: ".$admin_dir."games.php");
		exit;
	} else {
		$sql = "INSERT INTO games VALUES ('', '$game', '$key', '$description', '$recording_method', '$method_name', '$site', '$banner', 0)";
		$result = @mysql_query($sql,$connection) or die(mysql_error());
	}
	$uploaded = "Game successfully uploaded!";
	unset($e_warning);
}
$header = "";
if (
include($root."inc/top.html");
print_r($edit);
?>

<div align="center">
Upload a new Squad Game
<br />
<? echo $uploaded; ?>
<? echo $e_warning; ?>
<br />	
<form method="POST" action="" enctype="multipart/form-data">
	<input type="hidden" value="op" name="ds">
	<?
		if (isset($_GET[edit_id])) {
			echo "<input type=\"hidden\" value=\"$_GET[edit_id]\" name=\"editing\">\n";
			echo "<input type=\"hidden\" value=\"$e_tourn\" name=\"tourneys\">\n";
			echo $e_banner;
		} else {
			echo "";
		}
	?>
	<div class="form">						
	Enter the name of the Game: <input type="text" name="name" size="26" value="<? echo $edit['name']; ?>">						
	</div>
	<div class="form">						
	TEST Describe the game as best you can:<br />						
	<textarea rows="5" name="description" cols="60"><? echo $edit['description']; ?></textarea>
	</div>
	<div class="form">						
	If the game has a homepage, put it here: <input type="text" name="homepage" size="26" value="<? echo $edit['site']; ?>">						
	</div>	   
	<hr width="25%" />
	Tournament Info					
	<div class="form">
	Is the game tournament capable?
	Yes<input type="radio" value="yes" checked name="t_capable" onClick="new Effect.BlindDown(document.getElementById('tournament'), {duration: 1})">
	No<input type="radio" name="t_capable" value="no" onClick="new Effect.BlindUp(document.getElementById('tournament'))">
	</div>
	<div id="tournament">
		<div class="form">
		Please select the type of match recording method:
		<select size="1" name="recording_method">
			<option selected value="NULL">Select a method</option>
			<option value="none">No available recording method</option>
			<option value="log">Log (Text File)</option>
			<option value="game_file">File used within Game</option>
			<option value="file">File used outside Game (Not sound)</option>
			<option value="sound">Sound file</option>
		</select>
		</div>
		<div class="form">
		What is the name used for this method? <input type="text" name="method_name" size="27" value="">
		</div>
	</div>
	<div id="bannerform">
		<div class="form">
		Upload a 345 x 145 banner for the game (required!):	<input type="file" name="banner">
		</div>		
	</div>
	<div class="form">
	<input type="submit" value="Submit"><input type="reset" value="Reset">
	</div>
</form>
</div>  
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>