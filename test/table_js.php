<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<title>test</title>
<style type="text/css">
body {
        color: #FFCC33;
        background-image: url('<? echo $site_dir."/images/space.png"; ?>');
        font-size: 7pt;
        font-family: Verdana, sans-serif;
        background-color: #000000;
}
.admin {
        border-left: 1px solid #FF0000;
        border-top: 1px solid #FF0000;
        border-right: 1px solid #FF0000;
        border-bottom: 1px solid #FF0000;
        background-color: #660000;
}
.judge {
        border-left: 1px solid #00FF00;
        border-top: 1px solid #00FF00;
        border-right: 1px solid #00FF00;
        border-bottom: 1px solid #00FF00;
        background-color: #006600;
}
.squad {
        border-left: 1px solid #0000FF;
        border-top: 1px solid #0000FF;
        border-right: 1px solid #0000FF;
        border-bottom: 1px solid #0000FF;
        background-color: #000066;
}
.ranktable {
        border-right: 1px solid #0000FF;
        border-bottom: 1px solid #0000FF;
        border-left: 1px solid #0000FF;
        border-top: 1px solid #0000FF;
        background-color: #000066
}
.rankrows {
		background-color:#0000FF;		
}
</style>
</head>

<body>
<div align="center" id="loadbar">Click "Kill this row" to remove a row!</div>
<table border="0" id="table1" class="ranktable" cellspacing="0">
<?

	for ($i=1;$i<11;$i++) {
		$row = "row".$i;
		echo "<tr id=\"$row\" class=\"rankrows\">";
		for ($j=1;$j<6;$j++) {
			$slot="tr".$i;
			echo "<td id=\"$slot\" class=\"squad\">".rand(0,10)."</td>";
		}
		if ($i == 1) { $abr = "null"; } else { $abr = "'tr".$i."'"; }
		echo "<td id=\"$slot\" class=\"squad\"><a href=\"#\" onClick=\"killRow('$row',$abr);\">Kill this Row</a></td>";
		echo "</tr>";
	}

?>
</table>

<script>
var bar = new Array(
	"<h2>.</h2>.........",
	".<h2>.</h2>........",
	"..<h2>.</h2>.......",
	"...<h2>.</h2>......",
	"....<h2>.</h2>.....",
	".....<h2>.</h2>....",
	"......<h2>.</h2>...",
	".......<h2>.</h2>..",
	"........<h2>.</h2>.",
	".........<h2>.</h2>"
);

var cycle = 0;

function obj(id) {
	if (document.getElementById) {
		return document.getElementById(id);
	}
	if (document.all) {
		return document.all[id];
	}
	if (document.layers) {
		return document.layers[id];
	}
	return null;
}

function cycleBar() {
	var loadbar = obj('loadbar');

	if (cycle>9) {
		cycle=0;
	}
	loadbar.innerHTML = bar[j];
	
	cycle++;
}

function killRow(id, aid) {
	var row = obj(id);
	
	if (aid != null) {
		var	abover = obj(aid);
	} else {
		var abover = null;
	}
	
	if (document.all){
		row.style.visibility = "hidden";
		row.style.position = "absolute";
		row.height = "0";
	} else {
		row.innerHTML = "";
		if (abover != null) {
			for (loop=0; loop < abover.length; loop++){
				abover[loop].rowspan = "2";
			}
		}
	}	

	loadbar.innerHTML = "Click \"Kill this row\" to remove a row!";
}
</script>

</body>

</html>