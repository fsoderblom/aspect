<?php
include("inc.config.php");
include("class/bits.class.php");

if(defined('_INIT_LOADED'))
{
}
else
{

define('_INIT_LOADED', true);

/*---------------------------------------------------------------------------*/
// 16 websafe colors who HAS NAMES! This is very important. Must match with
// names in image.php aswell as work in browsers. Like bgcolor="name" rather
// than bgcolor="#hexcode"
/*---------------------------------------------------------------------------*/
$colors = array("green",
				"aqua",
				"black",
				"blue",
				"fuchsia",
				"gray",
				"lime",
				"maroon",
				"navy",
				"olive",
				"purple",
				"red",
				"silver",
				"teal",
				"white",
				"yellow",
				"orange");



/*---------------------------------------------------------------------------*/
// syslog database startup : variables found in inc.config.php 
/*---------------------------------------------------------------------------*/

if($search) {
	$db = mysql_connect($syslogSearchHost, $syslogSearchUser, $syslogSearchPass) or die("Searchuser: cannot connect to database");
	mysql_select_db($syslogSearchDatabase, $db) or die("Searchuser: cannot select database");
} else {
	$db = mysql_connect($syslogHost, $syslogUser, $syslogPass) or die("Normal user: cannot connect to database");
	mysql_select_db($syslogDatabase, $db) or die("Normal user: cannot select database");
}

/*---------------------------------------------------------------------------*/
// determine MySQL version
/*---------------------------------------------------------------------------*/

$ver = mysql_query("SELECT VERSION()", $db);
$rowfetch = mysql_fetch_array($ver);
$MySQL_Version = substr($rowfetch[0], 0, 1);
$MySQL_Minor_version = substr($rowfetch[0], 2, 1);
$MySQL_Major_version = substr($rowfetch[0], 0, 1);


/*---------------------------------------------------------------------------*/
// Session startup + authentication 
/*---------------------------------------------------------------------------*/
session_start();

if( $_GET['logout'] == '1' )
{
	session_unset();
}

// Unless trying to login, show loginform unless we have sessionflags!
if( $_POST['login'] == '' && $_SESSION['sess_auth'] == '' )
{
	include('loginpage.php');
}

// The user is maybe trying to login? 
else if( $_POST['login'] == '1')
{
	// Basic SQL injection protection.
	$un = substr($_POST['username'], 0, 50);
	$ps = substr($_POST['password'], 0, 50);
	if( !ereg("^[A-Za-z0-9_\.\-]+$", $un, $res) || !ereg("^[A-Za-z0-9_\.\-]+$", $ps, $res) )
	{
		include('loginpage.php');
	}

	$sql = sprintf("SELECT id, auth, password FROM users WHERE username = '%s'", $un);
	$qry = mysql_query($sql, $db);
	if($users = mysql_fetch_array($qry))
	{
		if($users['password'] == md5($ps) || $users['password'] == $ps) // support plain text passwords
		{
			if(is_numeric($users['auth']))
			{
				$_SESSION['sess_userid'] = $users['id'];
				$_SESSION['sess_auth'] = $users['auth'];
			}
		}
	}
	else
	{
		include('loginpage.php');
	}
}

/*---------------------------------------------------------------------------*/
// Initialize some objects and variables we often use
/*---------------------------------------------------------------------------*/
$bits = new bits();

define('AUTH_INACTIVE', $bits->checkBit($_SESSION['sess_auth'], BIT_INACTIVE) );
define('AUTH_CHANGEPASS', $bits->checkBit($_SESSION['sess_auth'], BIT_CHANGEPASS) );
define('AUTH_ADMIN', $bits->checkBit($_SESSION['sess_auth'], BIT_ADMIN) );
define('AUTH_RULES', $bits->checkBit($_SESSION['sess_auth'], BIT_RULES) );
define('AUTH_ALLOWSQL', $bits->checkBit($_SESSION['sess_auth'], BIT_ALLOWSQL) );


/*---------------------------------------------------------------------------*/
// Do some checks.. Need to change pass? Is he/she even allowed here?
/*---------------------------------------------------------------------------*/
if(AUTH_INACTIVE===true)
{
	include('loginpage.php');
}

if(AUTH_CHANGEPASS===true)
{
	include('changepass.php');
}


/*---------------------------------------------------------------------------*/
// set up the mapsize and gridsize
/*---------------------------------------------------------------------------*/
if($_GET['mapSize'] != "") {
	$_SESSION["mapSize"] = $_GET["mapSize"];
}

switch($_SESSION['mapSize'])
{
	case 1:
		$imageSize = 260;
		$gridSize = 4;
	break;
	
	case 2:
		$imageSize = 600;
		$gridSize = 6;
	break;
	
	case 3:
		$imageSize = 600;
		$gridSize = 8;
	break;
	
	case 4:
		$imageSize = 400;
		$gridSize = 20;
	break;
	
	case 5:
		$imageSize = 500;
		$gridSize = 5;
	break;

	default:
		$imageSize = 400;
		$gridSize = 8;
	break;
}

$area = $imageSize / $gridSize;
$area *= $area; 


function req()
{
	echo '<font style="color:red">&nbsp;*</font>';
}

}
?>
