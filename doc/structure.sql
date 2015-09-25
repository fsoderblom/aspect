# database: syslog


# classify
CREATE TABLE classify(
	facility varchar(10) NULL,
	priority varchar(10) NULL,
	host varchar(128) NULL,
	message text NULL,
	severity int(10) unsigned NULL,
	color varchar(32) NULL,
	seq int(10) unsigned NOT NULL AUTO_INCREMENT,
	precedence int(10) unsigned NOT NULL,
	PRIMARY KEY (seq)
);

# queries
CREATE TABLE queries(
	id int(10) unsigned NOT NULL AUTO_INCREMENT,
	query text NOT NULL,
	description varchar(70) NOT NULL,
	PRIMARY KEY (id)
);

# scratch
CREATE TABLE scratch(
	id int(10) unsigned NOT NULL AUTO_INCREMENT,
	type varchar(32) NOT NULL,
	value varchar(255) NOT NULL,
	PRIMARY KEY (id)
);

# syslog
CREATE TABLE syslog(
	facility varchar(10) NULL,
	priority varchar(10) NULL,
	date date NULL,
	time time NULL,
	host varchar(128) NULL,
	message text NULL,
	seq int(10) unsigned NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (seq),
	INDEX message_index (message(100)),
	INDEX date_index (date),
	INDEX host_index (host(50))
);

# users
CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  username varchar(50) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  firstname varchar(50) default NULL,
  lastname varchar(50) default NULL,
  email varchar(50) NOT NULL default '',
  auth int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY email (email)
);