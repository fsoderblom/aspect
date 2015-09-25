<?php
require("inc/inc.init.php");
include("inc/inc.header.php");

// Empty variables (if php.ini is badly configured these variables are filled automaticly from _GET & $_POST)
$id = '';
$username = '';
$password = '';
$firstname = '';
$lastname = '';
$email = '';
$auth = '';



// -------------------------
// Save a user
// -------------------------
if($_POST['act']=='save')
{

	// get the posted values
	$id = $_POST['id'];
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	
	 // calculate new auth value
	$auth = $_SESSION['sess_auth'];
	foreach($USER_SETTINGS as $arr) // uncheck all current USER_SETTINGS bits. Resets are done again below.
	{
		$auth = $bits->unsetBit($auth, $arr['bit']);
	}
	foreach($_POST as $nam=>$val) // re-set chosen bits again.
	{
		if(strpos($nam,'usersetting')!==false) { $auth = $bits->setBit( $auth, substr($nam,12)); }
	}

	// save by updating the user.
	if($_POST['id'] != '' && $email != '')
	{
		$sql = sprintf("UPDATE users SET firstname='%s', lastname='%s', email='%s', auth='%d' WHERE id='%d'", 
			$firstname, $lastname, $email, $auth, $id);
		if(!mysql_query($sql, $db)) { $message = 'user not updated'; } else { $message = 'User updated'; }
	}
	else $message = 'User not saved/updated. Check fields!';


}

// -------------------------
// Load current user
// -------------------------

$id = $_SESSION['sess_userid'];

$sql = sprintf("SELECT * FROM users WHERE id='%d' ORDER BY username", $id );
$qry = mysql_query($sql, $db);
if($user = mysql_fetch_array($qry))
{
	$id = $user['id'];
	$username = $user['username'];
	$password = $user['password'];
	$firstname = $user['firstname'];
	$lastname = $user['lastname'];
	$email = $user['email'];
	$auth = $user['auth'];
}

?>

<?php // = FORM START ========== ?>

<form name="mypage" method="post" action="mypage.php">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="act" value="">

<br>
<p class="flerp2">My page</p>
<br>

<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<th class="r">username</th>
		<td><?php echo $username?></td>
	</tr>
	<tr>
		<th class="r">e-mail</th>
		<td><input type="text" name="email" value="<?php echo $email?>"><?php req();?></td>
	</tr>
	<tr>
		<th class="r">first name</th>
		<td><input type="text" name="firstname" value="<?php echo $firstname?>"></td>
	</tr>
	<tr>
		<th class="r">last name</th>
		<td><input type="text" name="lastname" value="<?php echo $lastname?>"></td>
	</tr>
	<tr>
		<th class="r">options</th>
		<td>
			<?php
			$bits = new bits();
			foreach($USER_SETTINGS as $arr)
			{
				$checked = $bits->checkBit($auth, $arr['bit']) ? 'checked' : '';
				?>
				<input type="checkbox" class="chkbox" name="usersetting-<?php echo $arr['bit']?>" <?php echo $checked?>><?php echo $arr['desc']?><br>
				<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<th class="r">&nbsp;</th>
		<td>
			<input type="submit" class="btn" id="btnsave" value="save" onclick="this.form.act.value='save'" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php if($message!='') echo '<p class="notice">'.$message.'</p>'; ?>&nbsp;</td>
	</tr>

</table>
</form>
<?php // = FORM END ========== ?>



<?php
include("inc/inc.footer.php");
?>
