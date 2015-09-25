<?php
require("inc/inc.init.php");
require("inc/inc.header.php");

$x = $_POST['img_x'];
$y = $_POST['img_y'];
$date = $_SESSION['date'];
$start = $_POST["start"];

$x = floor($x/$gridSize);
$y = floor($y/$gridSize);
$cols = $imageSize/$gridSize;

$pos = $_GET['pos'] != '' ? $_GET['pos'] : $_POST['pos'];
$pos = $pos == '' ? $x + ($cols*$y) + $start : $pos;
$pos = isset($_POST['prev']) ? $pos-=1 : $pos;
$pos = isset($_POST['next']) ? $pos+=1 : $pos;

// PROPOSAL: replace
// $sql = sprintf("SELECT * FROM syslog WHERE date >= '%s' ORDER BY seq ASC LIMIT %d, 1", $date, $pos);
// with something like the below, brings major speedups.
$sequenceArray = unserialize( $_SESSION['sequenceData'] );
$sql = sprintf("SELECT * FROM syslog WHERE seq = '%s'", $sequenceArray[$pos-$start]);

$syslogQuery = mysql_query($sql, $db);
if($syslog = mysql_fetch_array($syslogQuery))
{
	$sql = sprintf("SELECT * FROM classify WHERE '%s' LIKE facility AND '%s' LIKE priority AND
					'%s' LIKE message AND '%s' LIKE host ORDER BY precedence ASC LIMIT 0,1",
					$syslog["facility"],
					$syslog["priority"],
				   	addslashes($syslog["message"])),
					$syslog["host"];

	$classifyQuery = mysql_query($sql, $db);
	$classify = mysql_fetch_array($classifyQuery);
	$num_rows = mysql_num_rows($classifyQuery);

	$isClassified = trim($classify['color']) == "" ? false : true;
	$color = $classify['color'] == '' ? "red" : $classify['color'];
	
}

?>
<br>
<p class="flerp">Log details</p>
<br>

<form name="peepform" action="" method="post" target="_self">
<input type="hidden" name="pos" value="<?php echo $pos?>">
<input type="hidden" name="message" value="">
<input type="hidden" name="facility" value="">
<input type="hidden" name="priority" value="">
<input type="hidden" name="host" value="">
<input type="hidden" name="syslogm" value="<?php echo base64_encode($syslog['message'])?>">
<input type="hidden" name="classifym" value="<?php echo base64_encode($classify['message'])?>">

<!-- /////////////// SHOW LOGPOST ////////////////  -->

<table width="100%" cellspacing="1" cellpadding="3" class="peeptabell" style="border: 3px solid <?php echo $isClassified?$classify['color']:'#ff0000'?>">
<tr>
	<td colspan="2" bgcolor="<?php echo $isClassified?$classify['color']:'#ff0000'?>" align="left" style="border:1px solid #000000">
		<font class="bigwhite">&nbsp;<?php echo $isClassified?"":"Unclassified"?>&nbsp;</font>
	</td>
</tr>
<tr onmouseover="this.bgColor='#132B51'" onmouseout="this.bgColor=''">
	<th width="80" class="r2">date:</th>
	<td>&nbsp;<?php echo $syslog['date']?></td>
</tr>
<tr onmouseover="this.bgColor='#132B51'" onmouseout="this.bgColor=''">
	<th class="r2">time:</th>
	<td>&nbsp;<?php echo $syslog['time']?></td>
</tr>
<tr onmouseover="this.bgColor='#132B51'" onmouseout="this.bgColor=''">
	<th class="r2">facility:</th>
	<td>&nbsp;<?php echo $syslog['facility']?></td>
</tr>
<tr onmouseover="this.bgColor='#132B51'" onmouseout="this.bgColor=''">
	<th class="r2">priority:</th>
	<td>&nbsp;<?php echo $syslog['priority']?></td>
</tr>
<tr onmouseover="this.bgColor='#132B51'" onmouseout="this.bgColor=''">
	<th class="r2">host:</th>
	<td>&nbsp;<?php echo $syslog['host']?></td>
</tr>
<tr onmouseover="this.bgColor='#132B51'" onmouseout="this.bgColor=''">
	<th class="r2">message:</th>
	<td>&nbsp;<?php echo htmlentities($syslog["message"])?></td>
</tr>
</table>
<br>
<input type="submit" class="btn" name="prev" id="btnprev" value="previous" onclick="this.form.target='_self'; this.form.action='peep.php';" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
<input type="submit" class="btn" name="next" id="btnnext" value="next" onclick="this.form.target='_self'; this.form.action='peep.php';" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
<input type="submit" class="btn" id="btnsearch" name="search" value="find more" onclick="this.form.action='modules/search/search.php'; this.form.target='_blank'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">

<?php
// &nbsp;&nbsp;<input type="button" value="search" onclick="this.form.action='search.php';this.form.submit();return false;">
?>

<!-- ////////////// SHOW RULE //////////////// -->
<br>
<br>
<br>
<?php 
	$disabled = ( AUTH_RULES===true || AUTH_ADMIN===true ) ? '' : 'disabled'; 
?>
<?php if($isClassified) {?>
	<p class="flerp">Capturing rule</p>
	<br>
	<table border="0" cellspacing="0" cellpadding="2">
	<tr>
		<th width="5">&nbsp;</th>
		<th>color</th>
		<th>severity</th>
		<th>facility</th>
		<th>priority</th>
		<th style="width: 100%">host</th>
	</tr>

	<tr>
		<td bgcolor="<?php echo $color?>" width="5" style="border-left:1px solid #000000;border-right:1px solid #000000;border-top:1px solid #000000;">&nbsp;</td>
		<td class="bright" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['color']?></td>
		<td class="bright" align="right" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['severity']?></td>
		<td class="bright" align="right" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['facility']?></td>
		<td class="bright" align="right" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['priority']?></td>
		<td class="bright" style="border-top:1px solid #000000; border-right:1px solid #000000" width="100%">&nbsp;<?php echo $classify['host']?></td>
	</tr>

	<tr>
		<td class="shadow" colspan="6" style="border-top:1px dotted #000000;border-left:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000"><?php echo htmlentities($classify['message'])?>&nbsp;</td>	
	</tr>

	<tr>
		<td colspan="6">
			<input <?php echo $disabled?> type="submit" class="btn<?php echo $disabled?>" id="btnedit" name="editrule" value="edit" onclick="this.form.target='_self'; this.form.action='editrule.php?id=<?php echo $classify['seq']?>'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
			<input type="submit" class="btn" id="btnmatch" name="match" value="match" onclick="this.form.action='modules/search/search.php'; this.form.target='_blank'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
			<input type="submit" class="btn" id="btnrules" value="view rules" onclick="this.form.target='_self'; this.form.action='rules.php'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
		</td>
	</tr>

	</table>
<?php } else {?>
<p class="flerp2">No rules captured this event</p>
<br>
<input <?php echo $disabled?> type="submit" class="btn<?php echo $disabled?>" id="btnnew" value="new rule" onclick="this.form.target='_self'; this.form.message.value='<?php echo base64_encode($syslog['message'])?>';this.form.facility.value='<?php echo base64_encode($syslog['facility'])?>';this.form.priority.value='<?php echo base64_encode($syslog['priority'])?>';this.form.host.value='<?php echo base64_encode($syslog['host'])?>';this.form.action='editrule.php';" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
<input type="submit" class="btn" id="btnrules" value="view rules" onclick="this.form.target='_self'; this.form.action='rules.php'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
<?php }?>
<br>
</form>
<?php
require("inc/inc.footer.php");
?>
