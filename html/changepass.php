<?php
$oldpass = trim($_POST['oldpass']);
$newpass = trim($_POST['newpass']);
$confirmpass = trim($_POST['confirmpass']);

if($oldpass!='' && $newpass!='' && $confirmpass!='')
{

	$id = $_SESSION['sess_userid'];
	$sql = sprintf("SELECT * FROM users WHERE id='%d' ORDER BY username", $id );

	$qry = mysql_query($sql, $db);
	if($user = mysql_fetch_array($qry))
	{
		if( !ereg("^[A-Za-z0-9_\.\-]+$", $newpass, $res) )
		{
			$message = "Only A-Z, a-z, underscore, period and minussign are allowed.";
			include('loginpage.php');
			die();
		}

		$username = $user['username'];
		$password = $user['password'];
		$firstname = $user['firstname'];
		$lastname = $user['lastname'];
		$email = $user['email'];
		$auth = $user['auth'];
		if($newpass == $confirmpass && ( md5($oldpass)==$password || $oldpass==$password ))
		{
			$auth = $bits->unsetBit($auth, BIT_CHANGEPASS);
			$sql = sprintf("UPDATE users SET password='%s', auth='%d' WHERE id='%d'", md5($newpass), $auth, $id);
			if(!mysql_query($sql, $db)) echo mysql_error();
			$_SESSION['sess_auth'] = $auth;

			include("loginpage.php");
			die();
		}
	}
}
else if(AUTH_CHANGEPASS===true)
{
	require("inc/inc.header.php");
	?>
	<center>
	<br>
	<br>
	<br>
	<br>
	<br>
	<form name="passwordform" action="index.php" method="post" target="_top">
	<input type="hidden" name="logout" value="">
	<table class="bright" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td colspan="2" nowrap align="center">change password</td>
	</tr>
	<tr>
		<td class="r">old password</td><td bgcolor="#ffffff"><input type="password" name="oldpass"></td>
	</tr>
	<tr>
		<td class="r">new password</td><td bgcolor="#ffffff"><input type="password" name="newpass"></td>
	</tr>
	<tr>
		<td class="r">confirm password</td><td bgcolor="#ffffff"><input type="password" name="confirmpass"></td>
	</tr>
	<tr>
		<td colspan="2" align="right">
		<input type="submit" value="Log out" class="btn" id="btncancel" onclick="this.form.method='get'; this.form.logout.value='1'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
		<input type="submit" value="Change" class="btn" id="btnsave" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
		</td>
	</tr>
	</table>
	</form>
	<br>

	</center>
	<?php
	require("inc/inc.footer.php");
	die();
}
?>
