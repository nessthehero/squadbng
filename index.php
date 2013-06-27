<?php
include_once("inc/includes.php");

!isset($_GET['p_id']) === false ? $post_start = $_GET['p_id'] : $post_start = 0;

$sql = "SELECT Count(*) AS post_count FROM news";
$result = mysql_query($sql) or die(mysql_error());
$num_posts = mysql_result($result,0, 'post_count');

$sql = 'SELECT * FROM news ORDER BY timestamp DESC LIMIT '.$post_start.','.POST_LIMIT;
$result = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($result) != 0) {
	while ($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		$sql_2 = "SELECT * FROM comments WHERE type_id = '$id'";
		$result_2 = @mysql_query($sql_2) or die(mysql_error());
		$num_comments = mysql_num_rows($result_2);

		$wording = ($num_comments == 1) ? "Comment" : "Comments";

		$poster = new User($row['poster']);
		
		$post 	= nl2br($row['post']);
		$title 	= $row['title'];
		
		$date = date("F jS, Y - g:i:s A", strtotime($row['timestamp']));	
			
		$newsblock .= "
			<div class='postsblock'>	
				".$poster->getAvatar('news')."
				<div class='post'>
					<img border='0' src='".POST_BLOCK_TOP."' ALT='' />
					<p class='date'>".$date."</p>
					<p>".$title."</p>
					<p>".$post."</p>
					<strong>[".$num_comments." <a href='".SITE_DIR."comments.php?type=news&amp;id=".$id."'>".$wording."</a>]</strong>
					<img border='0' src='".POST_BLOCK_BOTTOM."' ALT=''>
				</div>
			</div>
			<br />
		";
	}
} else {
	$newsblock = "There are no news posts";
}
$prev_id = $post_start + POST_LIMIT;
$next_id = $post_start - POST_LIMIT;
$prev = "
<a href='".SITE_DIR."?p_id=$next_id'>
<img src='".NEXT."' ALT=''>
</a>
";
$next = "
<a href='".SITE_DIR."?p_id=$prev_id'>
<img src='".PREV."' ALT=''>
</a>
";

$page_flipper = "
        <div style='text-align: center;'>
			";
if ($post_start == 0) { 
	$page_flipper .= "$next";
} elseif ($post_start + $post_limit >= $num_posts) {
	$page_flipper .= "$prev";
} else {
	$page_flipper .= "
		$prev
        $next
	";
}
$page_flipper .= "
        </div>
";

$header = "";
pageHeader("news", "squad", "Welcome!", $header);
echo "<div class='newsblock'>".$newsblock."</div>";
echo $page_flipper;
pageFooter(FALSE, TRUE);
?>