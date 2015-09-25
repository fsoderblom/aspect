<?php
$calendar = true;

require("inc/inc.init.php");
include("inc/inc.header.php");

// Date setup
$date = $_POST['date'];
$date = $date == '' ? $_SESSION['date'] : $date;
if ($date == '') 
{
	$sql = mysql_query("SELECT date FROM syslog ORDER BY date ASC LIMIT 1;");	// retreive first date from log
	$first_entry = mysql_fetch_array($sql);
	$date = $first_entry[0];
}

$_SESSION['date'] = $date;


// Fetch data
$sql = sprintf("SELECT count(*) FROM syslog WHERE date >= '%s'", $date);
$qry = mysql_query($sql, $db);
$row = mysql_fetch_array($qry);
$maxRows = $row[0];
while($lastpage+$area < $maxRows) $lastpage+=$area;

$start = $_GET["start"] == "" ? 0 : $_GET["start"];
$color = array();
$sequence = array();

$sql = sprintf("SELECT * FROM syslog WHERE date >= '%s' ORDER BY seq ASC LIMIT %d, %d", $date, $start, $area);
$syslogQuery = mysql_query($sql, $db);
while($syslog = mysql_fetch_array($syslogQuery))
{
	$sequence[] = $syslog["seq"];
	$sql = sprintf("SELECT color FROM classify WHERE '%s' LIKE facility AND
			'%s' LIKE priority AND '%s' LIKE message AND '%s' LIKE host ORDER BY precedence ASC LIMIT 0,1",
				( $syslog["facility"] ),
				( $syslog["priority"] ),
				( addslashes($syslog["message"])),
				( $syslog["host"] )
			  );

	$classifyQuery = mysql_query($sql, $db);
	$num = mysql_num_rows($classifyQuery);
	if($num!=1 && $num!=0) die("database fuckup");

	if($classify = mysql_fetch_array($classifyQuery))
	{
		$color[] = $classify["color"];
	}
	else
	{
		$color[] = "red";
	}
}

$_SESSION['colorData'] = serialize($color);
$_SESSION['sequenceData'] = serialize($sequence);
$_SESSION['imageSize'] = $imageSize;
$_SESSION['gridSize'] = $gridSize;
$calendar = true;
?>
<br>
<p class="flerp">Legend</p>
<br>
<center>

<table border="0" cellpadding="2" cellspacing="0" class="bright">
<tr>
	<th id="shadow" align="right" colspan="5" class="r">
		<form name="dateform" action="legend.php" method="post">from
		<input type="text" name="date" id="date" value="<?php echo $date?>" size="12">
		<input type="image" src="images/calendar.gif" alt="Start date selector" border="0" align="absmiddle" onclick="return showCalendar('date', '%Y-%m-%d');">
		<input type="submit" class="btn" id="btnsave" value="update" onclick="" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)" >
		</form>
	</th>
</tr>
<tr>
	<td colspan="5">
		<form name="img" method="post" action="legend.php" target="lf">
		<input type="hidden" name="start" value="<?php echo $start?>">
		<input type="image" src="image.php" name="img" value="0" onmousedown="document.forms['dateform'].date.focus(); return false" onClick="this.form.action='peep.php';this.form.target='rf'; this.form.submit();">
		</form>
	</td>
</tr>
<tr>
	<th id="shadow" align="left" class="l" width="10%"><?php if($start!=0){?><a href="?start=0">&lt;&lt;</a><?php }?>&nbsp;</th>
	<th id="shadow" align="left" class="l" width="10%"><?php if($start-$area>=0){?><a href="?start=<?php echo ($start-$area)?>">&lt;</a><?php }?>&nbsp;</th>
	<th id="shadow" align="center" class="c" width="60%"><?php echo $start?> - <?php echo ($start+$area)<$maxRows?($start+$area):$maxRows?></th>
	<th id="shadow" align="right" class="r" width="10%"><?php if($start+$area<=$maxRows){?><a href="?start=<?php echo ($start+$area)?>">&gt;</a><?php }?>&nbsp;</th>
	<th id="shadow" align="right" class="r" width="10%"><?php if($start+$area<=$maxRows){?><a href="?start=<?php echo ($lastpage)?>">&gt;&gt;</a><?php }?>&nbsp;</th>
</tr>
</table>
</form>

<br><br>
<a href="?mapSize=0" class="menu">normal</a>&nbsp;::&nbsp;
<a href="?mapSize=4" class="menu">blind</a>&nbsp;::&nbsp;
<a href="?mapSize=1" class="menu">cute</a>&nbsp;::&nbsp;
<a href="?mapSize=3" class="menu">fatty</a>&nbsp;::&nbsp;
<a href="?mapSize=2" class="menu">amazing</a><br><br>
</center>
<?php
include("inc/inc.footer.php");
?>
