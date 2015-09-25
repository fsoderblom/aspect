#!/usr/bin/perl -w
#
# update_scratch.pl
#
# Update the scratch table with distinct hosts, facilities and priorities,
# intended to be run atleast daily from cron(1m).
#
# Requires atleast the perl DBI and DBD::mysql modules.
#
# NOTE: Do NOT keep this file within your documentroot, it's a security risk.
#
# When       Who      What
# 2005-06-18 froo     created.

use strict;
use DBI;

#
# Customize below to match current installation.
#

my $syslogHost="host";        # Where is the database located?
my $syslogDatabase="db";      # What database to use?
my $syslogUser="user";        # user to access $syslogDatabase as, should have DELETE and INSERT privs
my $syslogPass="password";    # password for $syslogUser
my $debug=0;                  # to enable debug output, 1 = normal output, 2 = verbose output.

die("Remove this line to enable this script.\n");

#
# End of customization.
#

my @val;
my $sth;
my $count=0;

my $dsn = "DBI:mysql:host=$syslogHost;database=$syslogDatabase";
my $dbh = DBI->connect($dsn, "$syslogUser", "$syslogPass") 
			or die("Cannot connect do server\n");

my @types = ("host", "facility", "priority");
foreach my $type (@types) {
	$count = $dbh->do("DELETE FROM scratch WHERE type = '$type'");
	if ($debug) { print "removed $count old $type records.\n"; }

	$sth = $dbh->prepare("SELECT DISTINCT $type FROM syslog");
	$sth->execute();
	$count = 0;
	while (@val = $sth->fetchrow_array()) {
		my $c = $dbh->do("INSERT INTO scratch (type, value) VALUES ('$type', '$val[0]')");
		if ($debug > 1) { print "INSERT INTO scratch (type, value) VALUES ('$type', '$val[0]')\n"; }
		++$count;
	}
	$sth->finish();
	if ($debug) { print "inserted $count unique $type records.\n"; }
}

$dbh->disconnect();

exit (0);
