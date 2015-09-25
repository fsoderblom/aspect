<?php
/*---------------------------------------------------------------------------*/
// Syslog database settings 
/*---------------------------------------------------------------------------*/
$syslogHost = "host";
$syslogUser = "user1";
$syslogPass = "password1";
$syslogDatabase = "db";


/*---------------------------------------------------------------------------*/
// Syslog database settings for the searchpage
/*---------------------------------------------------------------------------*/
$syslogSearchHost = "host";
$syslogSearchUser = "user2";
$syslogSearchPass = "password2";
$syslogSearchDatabase = "db";


/*---------------------------------------------------------------------------*/
// Full or partial (after domain) URL to where aspect is going to run.
//
// Example 1: http://www.mycompany.com/aspect/
// Example 2: / (standard)
// Example 3: /security/tools/aspect/
//
// DO NOT FORGET A SLASH / IN THE END.
/*---------------------------------------------------------------------------*/
define('ASPECT_ROOT', '/');


/*---------------------------------------------------------------------------*/
// Alot of bits. :) Frankly, all user settings and user rights are defined
// by bits. All settings share these bits and are saved at the same place
// in the database. Once you have started to use aspect do not change the order.
// Only add new "bits" and increase the number.
/*---------------------------------------------------------------------------*/
define('BIT_INACTIVE', 0);
define('BIT_CHANGEPASS', 1);
define('BIT_ADMIN', 2);
define('BIT_RULES', 3);
define('BIT_ALLOWSQL',  4);
define('BIT_USECURRENTDATE', 5); // not user atm


/*---------------------------------------------------------------------------*/
// Existing user rights. Defined by bits above. 
// The description can be altered or translated at any time.
/*---------------------------------------------------------------------------*/
$USER_RIGHTS = array();
$USER_RIGHTS[] = array( 'bit'=>BIT_INACTIVE, 'desc'=>'Inactive - disabled user' );
$USER_RIGHTS[] = array( 'bit'=>BIT_CHANGEPASS, 'desc'=>'Password - this user must change password next login' );
$USER_RIGHTS[] = array( 'bit'=>BIT_ADMIN, 'desc'=>'Admin - if checked this user has no restrictions' );
$USER_RIGHTS[] = array( 'bit'=>BIT_RULES, 'desc'=>'Rules - can add, modify and delete rules' );
$USER_RIGHTS[] = array( 'bit'=>BIT_ALLOWSQL, 'desc'=>'Allow SQL - Allow this user to use SQL' );


/*---------------------------------------------------------------------------*/
// Existing user settings. Defined by bits above.
// The description can be altered or translated at any time.
/*---------------------------------------------------------------------------*/
$USER_SETTINGS = array();
$USER_SETTINGS[] = array( 'bit'=>BIT_CHANGEPASS, 'desc'=>'I want to change password next login' );


?>
