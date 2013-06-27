<?php
session_start();

// Directories
define("SITE_DIR", "http://".$_SERVER['HTTP_HOST']."/sites/squadbng/");
define("SITE_ROOT", '/home/moffitt/public_html');
define("DOWNLOADS_DIR", $_SERVER["DOCUMENT_ROOT"]."/sites/squadbng/downloads/");
define("ADMIN_FOLDER", SITE_DIR."admin/");

// Database info
define("DB_HOST", "localhost");
define("DB_USER", "moffitt_db");
define("DB_PASS", "b4ttl3fi3ld");
define("DB_DATABASE", "moffitt_squadbng");

// Site functionality (independant of templates)
define("MIN_USERS", 8);
define("POST_LIMIT", 3);

// Functions and classes
require_once("class.user.php");
require_once("functions.php");

// Website images
define("LOGO", SITE_DIR."images/logosmall.gif");
define("BACKGROUND", SITE_DIR."images/space.png");

define("NEXT", SITE_DIR."images/nextposts.PNG");
define("PREV", SITE_DIR."images/prevposts.PNG");
define("DELETE", SITE_DIR."images/del.PNG");
define("EDITGAME", SITE_DIR."images/editgame.PNG");
define("DELETEGAME", SITE_DIR."images/deletegame.PNG");
define("W3C", SITE_DIR."images/valid-html401.png");
define("CSS", SITE_DIR."images/css.PNG");
define("UP", SITE_DIR."images/up.PNG");
define("DOWN", SITE_DIR."images/down.PNG");

define("DEF_AVATAR_MALE", SITE_DIR."images/male_av.PNG");
define("DEF_AVATAR_FEMALE", SITE_DIR."images/female_av.PNG");

define("POST_BLOCK_TOP", SITE_DIR."CSS/speechbubble/top.PNG");
define("POST_BLOCK_CENTER", SITE_DIR."CSS/speechbubble/center.PNG");
define("POST_BLOCK_BOTTOM", SITE_DIR."CSS/speechbubble/bottom.PNG");

//define("COMMENT_BLOCK_TOP", SITE_DIR."CSS/speechbubble/c_top.PNG");
//define("COMMENT_BLOCK_CENTER", SITE_DIR."CSS/speechbubble/c_center.PNG");
//define("COMMENT_BLOCK_BOTTOM", SITE_DIR."CSS/speechbubble/c_bottom.PNG");

define("COMMENT_BLOCK_TOP", POST_BLOCK_TOP);
define("COMMENT_BLOCK_CENTER", POST_BLOCK_CENTER);
define("COMMENT_BLOCK_BOTTOM", POST_BLOCK_BOTTOM);

define("TABLE_TOP", SITE_DIR."CSS/tableTOP.PNG");
define("TABLE_CENTER", SITE_DIR."CSS/tableBG.PNG");
define("TABLE_BOTTOM", SITE_DIR."CSS/tableBOTTOM.PNG");

define("MENU_TOP", SITE_DIR."CSS/menuTOP.PNG");
define("MENU_CENTER", SITE_DIR."CSS/menuBG.PNG");
define("MENU_BOTTOM", SITE_DIR."CSS/menuBOTTOM.PNG");

// TODO: Change this to three images
$img_bluebg 			= SITE_DIR."CSS/blue_bg.PNG";
$img_a_tl 				= SITE_DIR."CSS/award/topleftcorner.PNG";
$img_a_top 				= SITE_DIR."CSS/award/top.PNG";
$img_a_tr 				= SITE_DIR."CSS/award/toprightcorner.PNG";
$img_a_left 			= SITE_DIR."CSS/award/left.PNG";
$img_a_right 			= SITE_DIR."CSS/award/right.PNG";
$img_a_bl 				= SITE_DIR."CSS/award/bottomleftcorner.PNG";
$img_a_bottom 			= SITE_DIR."CSS/award/bottom.PNG";
$img_a_br 				= SITE_DIR."CSS/award/bottomrightcorner.PNG";
$img_a_bg 				= SITE_DIR."CSS/award/bg.PNG";
?>