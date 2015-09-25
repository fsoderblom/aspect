<?php
require("inc/inc.init.php");

if( AUTH_RULES===true || AUTH_ADMIN===true ) {;;} else die();

$returnto = $_POST['returnto'] != '' ? $_POST['returnto'] : 'peep.php';
$id = $_GET['id'] != '' ? $_GET['id'] : $_POST['id']; 
$id = $id != '' ? $id : "";
$pos = $_GET['pos'] != '' ? $_GET['pos'] : $_POST['pos']; 
$pos = $pos != '' ? $pos : "";


// ----------
// -- SAVE --
// ----------
if($_POST['act']=='save' )
{
	$color = $_POST['color'];
	$severity = $_POST['severity'];
	$message = $_POST['message'];
	$facility = $_POST['facility'];
	$priority = $_POST['priority'];
	$host = $_POST['host'];
	

	if($_POST['id']!='')
	{
		$sql = sprintf("UPDATE classify SET facility='%s', priority='%s', host='%s', color='%s', severity='%s', message='%s' WHERE seq='%s'", $facility,$priority,$host, $color, $severity, $message, $id);
		//echo $sql;
		mysql_query($sql, $db);
		$id = $_POST['id'];
		
	} else {
		$sql = sprintf("INSERT INTO classify(facility,priority,host,message,severity,color,precedence) VALUES('%s','%s','%s','%s','%s','%s','0')",$facility,$priority,$host,$message,$severity,$color);
		//echo $sql;
		mysql_query($sql, $db);
		$id = mysql_insert_id($db);
		
	}

	
	?>
	<script language="JavaScript" type="text/javascript">
	if(top.window.bf == null)
	{
		top.window.bf.location.reload();
	}
	else
	{
		top.window.bf.window['lf'].location.reload();
	}
	</script>
	<?php
}

// -----------
// --DELETE --
// -----------
if($_POST['act']=='delete' )
{
	$sql = sprintf("DELETE FROM classify WHERE seq='%s'", $id);
	mysql_query($sql, $db);
	$id = '';
	?>
	<script language="JavaScript" type="text/javascript">
	if(top.window.bf == null)
	{
		top.window.bf.location.reload();
	}
	else
	{
		top.window.bf.window['lf'].location.reload();
	}
	</script>
	<?php
}

// ----------
// -- LOAD --
// ----------
if($id!='')
{
	$sql = sprintf("SELECT * FROM classify WHERE seq = '%s'", $id);
	$classifyQuery = mysql_query($sql, $db);
	$classify = mysql_fetch_array($classifyQuery);
}
else
{
	if($_POST["facility"]=='') $_POST["facility"] = '%';
	if($_POST["priority"]=='') $_POST["priority"] = '%';
	if($_POST["host"]=='') $_POST["host"] = '%';
}



include("inc/inc.header.php");
?>
<br>
<p class="flerp2">Create / edit rule</p>
<br>


<form name="editrule" method="post" action="editrule.php">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="act" value="">
<input type="hidden" name="pos" value="<?php echo $pos?>">
<input type="hidden" name="returnto" value="<?php echo $returnto?>">

<table border="0" cellspacing="0" cellpadding="4">

<tr>
	<th width="5">&nbsp;</th>
	<th>color</th>
	<th>severity</th>
	<th>facility </th>
	<th>priority </th>
	<th>host </th>
</tr>
<?php

$color = $classify['color'] == '' ? "green" : $classify['color'];
?>

<tr>

	<td bgcolor="<?php echo $color?>" width="5" style="border-left:1px solid #000000;border-right:1px solid #000000;border-top:1px solid #000000;">&nbsp;</td>

	<td class="bright" style="border-top:1px solid #000000;border-right:1px dotted #000000">
		<select name="color" style="width:80px">
		<?php
		for($i=0; $i<count($colors); $i++)
		{
		?>
		<option style="background:<?php echo $colors[$i]?>; color:#ffffff" value="<?php echo $colors[$i]?>"<?php echo ($colors[$i]==$classify['color'])?' selected':''?>><?php echo $colors[$i]?></option>
		<?php
		}
		?>
		</select>
	</td>

	<td class="bright" style="border-top:1px solid #000000;border-right:1px dotted #000000">
		<!--<input type="text" name="severity" style="width:50px" value="<?php echo $classify['severity']?>">-->
		<select name="severity" style="width:50px">
			<?php for($i=0; $i<=10; $i++){?>
			<option value="<?php echo $i?>"<?php echo $i==($classify['severity'])?' selected':''?>><?php echo $i?></option>
			<?php }?>
		</select>
	</td>

	<td class="bright" style="border-top:1px solid #000000;border-right:1px dotted #000000">
	<input type="text" name="facility" style="width:80px" value="<?php echo $classify['facility']==""?base64_decode($_POST['facility']):$classify['facility']?>">
	</td>

	<td class="bright" style="border-top:1px solid #000000;border-right:1px dotted #000000">
	<input type="text" name="priority" style="width:80px" value="<?php echo $classify['priority']==""?base64_decode($_POST['priority']):$classify['priority']?>">
	</td>

	<td class="bright" style="border-top:1px solid #000000; border-right:1px solid #000000" width="100%">
	<input type="text" name="host" style="width:90%" value="<?php echo $classify['host']==""?base64_decode($_POST['host']):$classify['host']?>">
	</td>

</tr>

<tr>
	<td class="shadow" colspan="6" style="border-top:1px dotted #000000;border-left:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000">
	<input type="text" name="message" style="width:98%" value="<?php echo $classify['message']==""?base64_decode($_POST['message']):$classify['message']?>">
	</td>	
</tr>

<tr><td colspan="6">&nbsp;</td></tr>

</table>

<input type="submit" class="btn" id="btncancel" value="cancel" onclick="this.form.method='get';this.form.action='<?php echo $returnto?>';" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
<input type="submit" class="btn" id="btnsave" value="save" onclick="this.form.act.value='save'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
<input type="submit" class="btn" id="btndel" name="deleterule" value="delete" onclick=" if( confirm('Are you sure?') ) { this.form.act.value='delete'; } else { return false;}" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">

</form>

<?php
include("inc/inc.footer.php");
?>
