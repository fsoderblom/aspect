<?php
require("inc/inc.init.php");
require("inc/inc.header.php");

    $db = mysql_connect($syslogHost, $syslogUser, $syslogPass) or die("cannot connect to database");
    mysql_select_db($syslogDatabase, $db) or die("cannot select database");

	mysql_query("DELETE FROM scratch WHERE type = 'host'", $db);
	$hosts = mysql_query("SELECT DISTINCT host FROM syslog", $db);
	while ($my_host = mysql_fetch_array($hosts)) {
		$sqlQuery = sprintf("INSERT INTO scratch (type, value) VALUES ('host', '%s')", $my_host[0]);
		mysql_query($sqlQuery, $db);
		if ($debug)
			printf("INSERT INTO scratch (type, value) VALUES ('host', '%s')<br>\n", $my_host[0]);
	}

	mysql_query("DELETE FROM scratch WHERE type = 'facility'", $db);
	$facilities = mysql_query("SELECT DISTINCT facility FROM syslog", $db);
	while ($my_facility = mysql_fetch_array($facilities)) {
		$sqlQuery = sprintf("INSERT INTO scratch (type, value) VALUES ('facility', '%s')", $my_facility[0]);
		mysql_query($sqlQuery, $db);
		if ($debug)
			printf("INSERT INTO scratch (type, value) VALUES ('facility', '%s')<br>\n", $my_facility[0]);
	}

	mysql_query("DELETE FROM scratch WHERE type = 'priority'", $db);
	$priorities = mysql_query("SELECT DISTINCT priority FROM syslog", $db);
	while ($my_priority = mysql_fetch_array($priorities)) {
		$sqlQuery = sprintf("INSERT INTO scratch (type, value) VALUES ('priority', '%s')", $my_priority[0]);
		mysql_query($sqlQuery, $db);
		if ($debug)
			printf("INSERT INTO scratch (type, value) VALUES ('priority', '%s')<br>\n", $my_priority[0]);
	}
?>
</head>
</html>
