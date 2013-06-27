<?
$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_title = "Under Construction";
?>

<html>
<head>
<title>
Squad BnG - <? echo $page_title; ?>
</title>
</head>
<body background="<? echo $img_BG; ?>" link="#FFFFFF" vlink="#E2C022" alink="#4A92CD" text="#E0B95B">

<p align="center">
<? echo "<a href=\"$homedir\">"; ?>
<font color="#FFCC99" size="7" face="verdana">
<img src="images/underconstruction.gif" border="0" width="513" height="500">
</font>
</a>
<font color="#FFCC99" size="7" face="verdana">
</font>
</p>
</body>
</html>
