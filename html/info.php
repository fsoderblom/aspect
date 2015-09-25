<?php
include("inc/inc.init.php");
include("inc/inc.header.php");

// Init some variables to present below.

// How many rows in syslog?
// SELECT COUNT(*) takes > 26 minutes on a 53GiB table, workaround might be:
$sql = sprintf("SELECT (MAX(seq) - MIN(seq) + 1) AS number_of_rows FROM syslog;");
$qry = mysql_query($sql, $db);
if($arr = mysql_fetch_array($qry))
{
	$syslog_items = $arr[0];
} else $syslog_items = 'Could not find'; 

// How many users are there?
$sql = sprintf("SELECT COUNT(*) FROM users");
$qry = mysql_query($sql, $db);
if($arr = mysql_fetch_array($qry))
{
	$number_of_users = $arr[0];
} else $number_of_users = 'Could not find'; 


// How many rules do we have?
$sql = sprintf("SELECT COUNT(*) FROM classify");
$qry = mysql_query($sql, $db);
if($arr = mysql_fetch_array($qry))
{
	$number_of_rules = $arr[0];
} else $number_of_rules = 'Could not find'; 

?>

<br/><p class="flerp">System info</p><br/>
<table border="0">
<tr>
	<th class="r">syslog rows: </th><td><?php echo $syslog_items?></td>
</tr>
<tr>
	<th class="r">number of rules: </th><td><?php echo $number_of_rules?></td>
</tr>
<tr>
	<th class="r">number of users: </th><td><?php echo $number_of_users?></td>
</tr>
<tr>
	<th class="r">Today is: </th><td><?php echo date('l')?> the <?php echo date('j:S')?> of <?php echo date('F Y')?></td>
</tr>
<tr>
	<th class="r">Current time is: </th><td><?php echo date('H:i')?></td>
</tr>
</table>
<?php
include("inc/inc.footer.php");
?>
