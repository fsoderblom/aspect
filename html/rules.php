<?php
require("inc/inc.init.php");
include("inc/inc.header.php");

$disabled = ( AUTH_RULES===true || AUTH_ADMIN===true ) ? '' : 'disabled'; 

$columns = array("color","severity","facility","priority","host" );
$orders = array("ASC","DESC");

$col = isset($_GET['col']) ? (int)$_GET['col'] : 2;
$ord = isset($_GET['ord']) ? (int)$_GET['ord'] : 1;

$sql = sprintf("SELECT * FROM classify ORDER BY %s %s", $columns[$col], $orders[$ord]);
$classifyQuery = mysql_query($sql, $db);

$ord = $ord == 1 ? 0 : 1;
$icon = $ord == 0 ? '<img src="images/pilner.gif" border="0">' : '<img src="images/pilupp.gif" border="0">';

?>
<br>
<p class="flerp">Existing rules</p>
<br>

<form name="rulesform" action="rules.php" method="post">
<input type="hidden" name="returnto" value="rules.php">

<table border="0" cellspacing="0" cellpadding="2">
<tr>
	<th style="width: 5px">&nbsp;</th>
	<th style="width: 60px"><a href="rules.php?col=0&ord=<?php echo $ord?>">color<?php echo $col==0?$icon:''?></a></th>
	<th style="width: 60px"><a href="rules.php?col=1&ord=<?php echo $ord?>">severity<?php echo $col==1?$icon:''?></a></th>
	<th style="width: 80px"><a href="rules.php?col=2&ord=<?php echo $ord?>">facility<?php echo $col==2?$icon:''?></a></th>
	<th style="width: 80px"><a href="rules.php?col=3&ord=<?php echo $ord?>">priority<?php echo $col==3?$icon:''?></a></th>
	<th><a href="rules.php?col=4&ord=<?php echo $ord?>">host<?php echo $col==4?$icon:''?></a></th>
</tr>
<?php
while($classify = mysql_fetch_array($classifyQuery))
{
	$color = $classify['color'] == '' ? "red" : $classify['color'];
	?>
	<tr>
		<td bgcolor="<?php echo $color?>" width="5" style="border-left:1px solid #000000;border-right:1px solid #000000;border-top:1px solid #000000;">&nbsp;</td>
		<td class="bright" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['color']?></td>
		<td class="bright" align="left" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['severity']?></td>
		<td class="bright" align="left" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['facility']?></td>
		<td class="bright" align="left" style="border-top:1px solid #000000;border-right:1px dotted #000000">&nbsp;<?php echo $classify['priority']?></td>
		<td class="bright" align="left" style="border-top:1px solid #000000;border-right:1px solid #000000">&nbsp;<?php echo $classify['host']?></td>
	</tr>
	<tr>
		<td class="shadow" colspan="6" style="border-top:1px dotted #000000;border-left:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000"><?php echo $classify['message']?></td>	
	</tr>
	<tr>
		<td colspan="6">
			<input <?php echo $disabled?> type="submit" class="btn<?php echo $disabled?>" id="btnedit" name="editrule" value="edit" onclick="this.form.action='editrule.php?id=<?php echo $classify['seq']?>'; this.form.target='_self'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
		</td>
	</tr>
	<tr><td colspan="6">&nbsp;</td></tr>
	<?php
}
?>
</table>
</form>
<?php
include("inc/inc.footer.php");
?>
