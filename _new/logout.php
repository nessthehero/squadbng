<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");

setcookie('SQUADBNG_LOGIN', FALSE);

session_destroy();

header("Location: ".$site_dir."home.php");
exit;
?>
