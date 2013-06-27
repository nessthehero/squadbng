<?php
include_once("inc/includes.php");

setcookie('SQUADBNG_LOGIN', FALSE);

session_destroy();

header("Location: ".SITE_DIR);
exit;
?>
