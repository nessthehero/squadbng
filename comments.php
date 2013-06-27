<?php
include_once("inc/includes.php");

$c_type = format($_GET[type]);
$c_id = format($_GET[id]);

if (isset($_POST['commenting'])) {
		$POST 		= format($_POST);
		
        $c_title 	= $POST['c_title'];
        $c_post 	= $POST['comment'];
        $c_who 		= $POST['who'];
		
        $sql = "INSERT INTO comments VALUES ('', '$c_who', '$c_post', '$c_title', NOW(), '$c_type', '$c_id')";
        $result = mysql_query($sql) or die(mysql_error());
		
        $success_msg = "<p class='alert'>Commented successfully</p>";
}

if (isset($_GET['del'])) {
		$del = format($_GET['del']);

        $sql = "DELETE FROM comments WHERE id = '$del'";
        $result = mysql_query($sql) or die(mysql_error());
		
        header("Location: ".SITE_DIR."comments.php?type=news&amp;id=".$c_id);
        exit;
}

if ($c_type == "news") {
        $sql = "SELECT * FROM news WHERE id = '$c_id'";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
		
                $poster = new User($row[poster]);
                
                $post = nl2br($row['post']);
                $title = $row['title'];
				
                $date = date("F jS, Y - g:i:s A", strtotime($row['timestamp']));
				
				$newsblock .= "
					<div class='postsblock'>	
						<div class='user_avatar'>
								".$poster->getAvatar()."<br />".$poster->getName()."
						</div>
						<div class='post'>
							<img border='0' src='".POST_BLOCK_TOP."' ALT='' />
							<p class='date'>".$date."</p>
							<p>".$title."</p>
							<p>".$post."</p>
							<img border='0' src='".POST_BLOCK_BOTTOM."' ALT=''>
						</div>
					</div>
					<br />
				";
        }
		
        $commenting_on = $poster->getName()."'s news post";
		
        $sql = "SELECT * FROM comments WHERE type = '$c_type' AND type_id = '$c_id'";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {	
		
				$CURRENT_USER = new User($_REQUEST['SQUADBNG_LOGIN']);
		
                if ($CURRENT_USER->getRank() == "admin") {
                        $delete_link = "<br><a href=\"".SITE_DIR."comments.php?del=".$row['id']."&amp;id=".$c_id."\">[-Delete-]</a>";
                }
				
                $commenter = new User($row['who']);           
                
                $comment = nl2br($row['comment']);
                $what = $row['title']."<br />";
                $when = $row['month']." ".$row[day].", ".$row[year]." -- ".$row[time];
				
                $date = date("F jS, Y - g:i:s A", strtotime($row['timestamp']));
				
				$comment_block .= "
					<div class='commentblock'>							
						<div class='user_avatar'>
								".$commenter->getAvatar()."<br />".$commenter->getName()."
						</div>
						<div class='comment'>
							<img border='0' src='".COMMENT_BLOCK_TOP."' ALT='' />
							<p class='c_title'>".$date."<br />
							".$what."</p>
							<p>".$comment."</p>
							<br /><br />
							".$delete_link."
							<img border='0' src='".COMMENT_BLOCK_BOTTOM."' ALT='' />
						</div>						
					</div>
					<br />
				";				
               
        }
        $page = $success_msg.$newsblock."<hr width='40%'>".$comment_block;

		if (isset($_SESSION[username])) {
		$page .= "
		<br><br>
		<form method=\"POST\" name=\"comment\" action=\"comments.php?type=".$c_type."&amp;id=".$c_id."\">
				<input type=\"hidden\" name=\"commenting\" value=\"yes\">
				<input type=\"hidden\" name=\"who\" value=\"".get_user_id($_SESSION[username])."\">
				<div align=\"center\">
				<center>
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						<tr>
								<td>
										<p align=\"center\">Title:
								</td>
								<td>
										<p align=\"center\"><input type=\"text\" name=\"c_title\" size=\"35\">
								</td>
						</tr>
						<tr>
								<td colspan=\"2\">
										<p align=\"center\"><textarea rows=\"4\" name=\"comment\" cols=\"40\"></textarea>
								</td>
						</tr>
						<tr>
								<td colspan=\"2\">
										<p align=\"center\">
										<input type=\"submit\" value=\"Submit\">
										<input type=\"reset\" value=\"Reset\">
										</p>
								</td>
						</tr>
				</table>
				</center>
				</div>
		</form>
		";
		}
} else {
        header("Location: ".$site_dir."home.php");
        exit;
}

$header = "";
pageHeader("squad", "squad", "Comment on ".$commenting_on, $header);
echo $page;
pageFooter(FALSE, FALSE);
?>