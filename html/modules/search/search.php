		<?php

		$search = true;
		$calendar = true;

		include('../../inc/inc.init.php');
		include('../../inc/inc.header.php');

		$date1 = $_GET['date1'] != '' ? $_GET['date1'] : $_POST['date1']; 
		if ($date1 == '') {
			$sql = mysql_query("SELECT date,time FROM syslog ORDER BY date ASC LIMIT 1;");	// retreive first date and time from log
			$first_entry = mysql_fetch_array($sql);
			$date1 = $first_entry[0] . " " . substr($first_entry[1], 0, 5);
		}

		$date2 = $_GET['date2'] != '' ? $_GET['date2'] : $_POST['date2']; 
		if ($date2 == '') {
			$sql = mysql_query("SELECT NOW()");
			$first_entry = mysql_fetch_array($sql);
			$date2 = substr($first_entry[0], 0, 16);
		}

		$limit = $_GET['limit'] != '' ? $_GET['limit'] : $_POST['limit']; 
		$limit = $limit != '' ? $limit : "50";

		$host = $_GET['host'] != '' ? $_GET['host'] : $_POST['host']; 
		$host = $host != '' ? $host : "all";

		$facility = $_GET['facility'] != '' ? $_GET['facility'] : $_POST['facility']; 
		$facility = $facility != '' ? $facility : "all";

		$priority = $_GET['priority'] != '' ? $_GET['priority'] : $_POST['priority']; 
		$priority = $priority != '' ? $priority : "all";

		$reverse = $_GET['reverse'] != '' ? $_GET['reverse'] : $_POST['reverse']; 
		$reverse = $reverse != '' ? $reverse : "";

		$showextra = $_GET['showextra'] != '' ? $_GET['showextra'] : $_POST['showextra'];
		$showextra = $showextra != '' ? $showextra : "";

		$showquery = $_GET['showquery'] != '' ? $_GET['showquery'] : $_POST['showquery']; 
		$showquery = $showquery != '' ? $showquery : "";

		$query = $_GET['query'] != '' ? $_GET['query'] : $_POST['query']; 
		$query = $query != '' ? $query : "";

		$savedquery = $_GET['savedquery'] != '' ? $_GET['savedquery'] : $_POST['savedquery']; 
		$savedquery = $savedquery != '' ? $savedquery : "";

		$_start = $_GET['_start'] != '' ? $_GET['_start'] : $_POST['_start']; 
		$_start = $_start != '' ? $_start : "0";

		$syslogm = $_GET['syslogm'] != '' ? $_GET['syslogm'] : $_POST['syslogm'];
		$syslogm = $syslogm != '' ? base64_decode($syslogm) : "0";

		$classifym = $_GET['classifym'] != '' ? $_GET['classifym'] : $_POST['classifym'];
		$classifym = $classifym != '' ? base64_decode($classifym) : "0";

		$search = $_GET['search'] != '' ? $_GET['search'] : $_POST['search'];
		$search = $search != '' ? $search : "";

		$match = $_GET['match'] != '' ? $_GET['match'] : $_POST['match'];
		$match = $match != '' ? $match : "";

		$save_description = $_GET['save_description'] != '' ? $_GET['save_description'] : $_POST['save_description'];
		$save_description = $save_description != '' ? $save_description : "";

		$save_query = $_GET['save_query'] != '' ? $_GET['save_query'] : $_POST['save_query'];
		$save_query = $save_query != '' ? $save_query : "";

		$delete_description = $_GET['delete_description'] != '' ? $_GET['delete_description'] : $_POST['delete_description'];
		$delete_description = $delete_description != '' ? $delete_description : "";

		$delete_query = $_GET['delete_query'] != '' ? $_GET['delete_query'] : $_POST['delete_query'];
		$delete_query = $delete_query != '' ? $delete_query : "";

		$run = $_GET['run'] != '' ? $_GET['run'] : $_POST['run'];
		$run = $run != '' ? $run : "";

		$paginate = $_GET['paginate'] != '' ? $_GET['paginate'] : $_POST['paginate'];
		$paginate = $paginate != '' ? $paginate : "";

		$saved  = $_GET['saved'] != '' ? $_GET['saved'] : $_POST['saved'];
		$saved = $saved != '' ? $saved : "";

		$query = $_GET['query'] != '' ? $_GET['query'] : $_POST['query'];
		$query = $query != '' ? $query : "";

		// queries from peep.php
		if ($search || $match) {
			$query = sprintf("SELECT * FROM syslog WHERE message %s '%s'", ($search ? "=" : "LIKE"),
							($search ? $syslogm : $classifym));
		}

		if ($save_description != "") {
			$sql = "INSERT INTO queries (query, description) VALUES ('$save_query', '$save_description')";
			$result = mysql_query($sql);
			if ($result == false) {
				?> <script language=javascript>alert('ERROR: failed to create the saved query "' + ' <?php echo $delete_description; ?>' + '"')</script> <?php
	}
}

if ($delete_description != "") {
	$sql = "DELETE FROM queries WHERE query = '$delete_query' AND description = '$delete_description'";
	$result = mysql_query($sql);
	if ($result == false) {
		?> <script language=javascript>alert('ERROR: failed to delete the saved query "' + ' <?php echo $delete_description; ?>' + '"')</script> <?php
	}
}
?>

<br><p class="flerp">Search</p><br>
<form name="searchform" action="<?php echo $PHP_SELF; ?>" method="post">

<table border="0">
<tr>
	<th>from</th>
	<th>to</th>
	<th>limit</th>
	<th>host</th>
	<th>facility</th>
	<th>priority</th>
</tr>
<tr>
	<td width="170">
		<input type="text" name="date1" id="date1" size="17" value="<?php echo $date1?>">
		<input type="image" src="<?php echo ASPECT_ROOT?>images/calendar.gif" alt="Start date selector" border="0" align="absmiddle" onclick="return showCalendar('date1', '%Y-%m-%d %H:%M', '24');">
	</td>
	<td width="170">
		<input type="text" name="date2" id="date2" size="17" value="<?php echo $date2?>">
		<input type="image" src="<?php echo ASPECT_ROOT?>images/calendar.gif" alt="End date selector" border="0" align="absmiddle" onclick="return showCalendar('date2', '%Y-%m-%d %H:%M', '24');"> 
	</td>
	<td>
		<SELECT name="limit">
			<OPTION <?php if ($limit == "10") echo "selected"; ?> label="limit" value="10">10 lines</OPTION>
			<OPTION <?php if ($limit == "20") echo "selected"; ?> label="limit" value="20">20 lines</OPTION>
			<OPTION <?php if ($limit == "50") echo "selected"; ?> label="limit" value="50">50 lines</OPTION>
			<OPTION <?php if ($limit == "100") echo "selected"; ?> label="limit" value="100">100 lines</OPTION>
			<OPTION <?php if ($limit == "500") echo "selected"; ?> label="limit" value="500">500 lines</OPTION>
			<OPTION <?php if ($limit == "1000") echo "selected"; ?> label="limit" value="1000">1000 lines</OPTION>
			<OPTION <?php if ($limit == "5000") echo "selected"; ?> label="limit" value="5000">5000 lines</OPTION>
			<OPTION <?php if ($limit == "10000") echo "selected"; ?> label="limit" value="10000">10000 lines</OPTION>
		</SELECT>
	</td>
	<td align="right">
		<SELECT name="host" style="width:120px">
			<OPTION label="host" value="all">all</OPTION>
		<?php
		$hosts = mysql_query("SELECT value FROM scratch WHERE type = 'host' GROUP BY value ASC", $db);
		while ($my_host = mysql_fetch_array($hosts)) {
			printf("\t\t<OPTION");
			if ($host == $my_host[0])
				printf(" selected");
			printf(" label=\"host\" value=\"%s\">%s</OPTION>\n", $my_host[0], $my_host[0]);
		} ?>
		</SELECT>
	</td>
	<td>
		<SELECT name="facility">
			<OPTION label="facility" value="all">all</OPTION>
		<?php
		$facilities = mysql_query("SELECT value FROM scratch WHERE type = 'facility' GROUP BY value ASC", $db);
		while ($my_facility = mysql_fetch_array($facilities)) {
			printf("\t\t<OPTION");
			if ($facility == $my_facility[0])
				printf(" selected");
			printf(" label=\"facility\" value=\"%s\">%s</OPTION>\n", $my_facility[0], $my_facility[0]);
		} ?>
		</SELECT>
	</td>
	<td>
		<SELECT name="priority">
			<OPTION label="priority" value="all">all</OPTION>
		<?php
		$priorities = mysql_query("SELECT value FROM scratch WHERE type = 'priority' GROUP BY value ASC", $db);
		while ($my_priority = mysql_fetch_array($priorities)) {
			printf("\t\t<OPTION");
			if ($priority == $my_priority[0])
				printf(" selected");
			printf(" label=\"priority\" value=\"%s\">%s</OPTION>\n", $my_priority[0], $my_priority[0]);
		} ?>
		</SELECT>
	</td>
</tr>
<tr>
	<th colspan="3">saved queries</th>
	<th colspan="3">&nbsp;</th>
</tr>
<tr>
	<td colspan="6" align="left">
	<SELECT name="savedquery">
		<OPTION label="savedquery" value="">none</OPTION>
		<?php
		$result = mysql_query("SELECT query,description FROM queries", $db);
		while ($sq = mysql_fetch_array($result)) {
			printf("\t\t<OPTION");
			if ($savedquery == $sq[0])
				printf(" selected");
			printf(" label=\"savedquery\" value=\"%s\">%s</OPTION>\n", $sq[0], $sq[1]);
		}
		?>
	</SELECT>
	&nbsp;
	<input type="submit" class="btn" id="btnrun" name="saved" value="Run">
	<input type="button" class="btn" id="btnload" name="saved" onClick="recallQuery(this.form)" value="Recall">
	<input type="button" class="btn" id="btndel" name="saved" onClick="deleteQuery(this.form)" value="Delete">
	<input type="hidden" name="delete_query">
	<input type="hidden" name="delete_description">
	</td>
</tr>
<tr>
	<th colspan="6">SQL statements</th>
</tr>
<tr>
	<td colspan="6">
		<textarea class="searchselect" name="query">
<?php
if ($query) echo eregi_replace("[\]", "", $query);
else printf("SELECT * FROM syslog ");
?>
</textarea>
	</td>
</tr>
<tr>
	<td colspan="6" valign="top">
		<input type="hidden" name="_start" value="<?php echo $start?>">
		<input type="submit" class="btn" id="btnrun" style="width:95px" name="run" value="Run Query">
		<input type="button" class="btn" id="btnsave" style="width:95px" name="save" onClick="saveQuery(this.form)" value="Save Query">
		<input type="hidden" name="save_query">
		<input type="hidden" name="save_description">
		<input type="reset" class="btn" id="btnreset" style="width:95px" value="Reset">
		<input type="checkbox" class="noborder" name="showquery" <?php if ($showquery == "on") echo "checked"; ?>> show query
		<input type="checkbox" class="noborder" name="showextra" <?php if ($showextra == "on") echo "checked"; ?>> show facility/prio
		<input type="checkbox" class="noborder" name="reverse" <?php if ($reverse == "on") echo "checked"; ?>> search from end
	</td>
</tr>
</table>
</form>

<?php
if ($run || $paginate || $saved || $query) { // anything posted?
	if ($saved) {	// process saved queries
		$sqlQuery = eregi_replace("[\]", "", $savedquery);
		if (($num = substr_count($sqlQuery, "\$ARG")) > 0) {
			$args = explode(" ", $query);
			for ($i = 1; $i <= $num; $i++) {
				$sqlQuery = ereg_replace("\\\$ARG$i", $args[$i-1], $sqlQuery);
			}
		}
	// complete query ends with a semicolon
	} else if (substr($query, -1) == ";") {
		$sqlQuery = eregi_replace("[\]", "", $query);
	// uncompleted queries get's completed and posted
	} else {
		$date1 = substr($date1, 0, 10);
		$time1 = substr($date1, 11, 5);
	
		$date2 = substr($date2, 0, 10);
		$time2 = substr($date2, 11, 5);

		// if type query contains WHERE, we add an "AND"
		if (substr_count(strtolower($query), "where"))
			$SEP = "AND";
		else
			$SEP = "WHERE";

		// remove any backslashes from singleticks
		$query = eregi_replace("[\]", "", $query);
		$sqlQuery = "$query $SEP date >= '$date1' AND date <= '$date2'";
		if ($host != "all")
			$sqlQuery .= " AND host = '$host'";
		if ($facility != "all")
			$sqlQuery .= " AND facility = '$facility'";
		if ($priority != "all")
			$sqlQuery .= " AND priority = '$priority'";

		// sort by date, ascending
		if ($reverse == "on")
			$sqlQuery .= " ORDER by date,time DESC";
		else
			$sqlQuery .= " ORDER by date,time ASC";

		// handle pagination
		if ($paginate == "next") {
			$_start += $limit;
		} else if ($paginate == "prev") {
			$_start -= $limit;
			$_start < 0 ? 0 : $_start;
		}
		$sqlQuery .= " LIMIT $_start, $limit";
	}
	?>

<form method="post">

	<table border="0">

	<?php
	// guesstimate the total number of rows in result
	if ($MySQL_Major_version == "4") {
		$wideQuery = eregi_replace("SELECT", "SELECT SQL_CALC_FOUND_ROWS", $sqlQuery);
		$entries = mysql_query($wideQuery, $db);
		$found_rows = mysql_query("SELECT FOUND_ROWS()", $db);
		$found_row = mysql_fetch_array($found_rows);
		$num_rows = $found_row[0];
	} else {
		// execute actual query
		$entries = mysql_query($sqlQuery, $db);
		$num_rows = mysql_num_rows($entries);
	}

	if (!$entries) {
		die('<td colspan="5"><p class="error">Invalid query: ' . mysql_error() . '</p></td>');
	}

	if ($showquery)
		echo "<td colspan=\"5\"><p class=\"info\">Query: $sqlQuery</p></td>";

	// have a swing at guessing if it's a "normal" SQL query or someone browsing the syslog
	$count = mysql_num_fields($entries);
	if (mysql_field_name($entries, 0) == "facility" &&
		mysql_field_name($entries, 1) == "priority") {	// !!FIXME!!
		$displayLog = 1;
	}
	
	while ($entry = mysql_fetch_array($entries)) {
		if ($displayLog) {	// standard logbrowsing, omit facility/priority unless asked for
			printf("<tr bgcolor=\"\"><td valign=\"top\" width=\"80\">%s</td><td valign=\"top\" width=\"70\">%s</td><td valign=\"top\" width=\"50\">%s:</td><td valign=\"top\">%s</td>", $entry[2], $entry[3], htmlentities($entry[4]), htmlentities($entry[5]));
			if ($showextra == "on") {
				printf("<td valign=\"top\">(%s/%s)", $entry[facility], $entry[priority]);
			} else
				echo "<td>&nbsp;";
			echo "</td></tr>\n";
		} else {	// process just any SQL query (besides logbrowsing)
			printf("<tr>");
			for ($i = 0; $i < $count; $i++) {
				printf("<td valign=\"top\">%s</td>", htmlentities($entry[$i]));
			}
			printf("</tr>");
		}
	}
	?>

	<tr>
	<td colspan="5">
		<p class="info">
		<input type="submit" class="btn" id="btnprev" name="paginate" value="prev"> 
		<input type="submit" class="btn" id="btnnext" name="paginate" value="next">
		<?php
		printf("&nbsp;&nbsp;[%d to %d (of %d)]", $_start, ($_start + $limit), $num_rows);
		?>
		</p>
	</td>
	</tr>

	</table>

	<input type="hidden" name="date1" value="<?php echo $date1?>">
	<input type="hidden" name="date2" value="<?php echo $date2?>">
	<input type="hidden" name="limit" value="<?php echo $limit?>">
	<input type="hidden" name="host" value="<?php echo $host?>">
	<input type="hidden" name="facility" value="<?php echo $facility?>">
	<input type="hidden" name="priority" value="<?php echo $priority?>">
	<input type="hidden" name="reverse" value="<?php echo $reverse?>">
	<input type="hidden" name="showquery" value="<?php echo $showquery?>">
	<input type="hidden" name="showextra" value="<?php echo $showextra?>">
	<input type="hidden" name="query" value="<?php echo $query?>">
	<input type="hidden" name="savedquery" value="<?php echo $savedquery?>">
	<input type="hidden" name="_start" value="<?php echo $_start?>">
	<input type="hidden" name="saved" value="<?php echo $saved?>">

</form>

<?php } ?>

<?php
include("../../inc/inc.footer.php");
?>
