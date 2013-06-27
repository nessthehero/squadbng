<?

session_start();



$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");


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



if ($_FILES[button] == "") {

        die("No file uploaded!!");

}

$type = $_FILES[button][type];

$name = $_FILES[button][name];

$temp = $_FILES[button][tmp_name];

if (($type != "image/png") && ($type != "image/x-png")) {

                header("Location: ".$admin_dir."buttons.php?png=no&type=$type");

                exit;

}



$error = "Could not copy image!";

$img_source = $uploaddir."CSS/".$name;

move_uploaded_file($temp, $img_source) or die($error);

$u_type = $_POST[select_type];

$u_number = $_POST['num'.$u_type] + 1;

$u_source = $name;

$u_path = $_POST[page];

$u_active = $_POST[active];



$sql = "INSERT INTO buttons VALUES('', '$u_source', '$u_path', '$u_type', '$u_number', '$u_active')";

                

$result = @mysql_query($sql,$connection) or die(mysql_error());



if ($result) {

        header("Location: ".$admin_dir."buttons.php");

        exit;

}



?>

