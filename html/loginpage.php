<?php
require("inc/inc.header.php");
?>
<center>
<br/>
<br/>
<br/>
<img src="images/aspect1.gif" />
<br/>
<br/>
<form name="loginform" action="index.php" method="post">
<input type="hidden" name="login" value="1">
<table class="bright" border="0" cellspacing="0" cellpadding="2">
<tr>
	<td colspan="2" nowrap align="center">a s p e c t : : l o g i n</td>
</tr>
<tr>
	<td class="r">username</td><td bgcolor="#ffffff"><input type="text" name="username"></td>
</tr>
<tr>
	<td class="r">password</td><td bgcolor="#ffffff"><input type="password" name="password"></td>
</tr>
<tr>
	<td colspan="2" align="right"><input type="submit" value="Log in" class="btn" id="btnlogin" onMouseOver="LightOn(this)" onMouseOut="LightOff(this)"></td>
</tr>
</table>
</form>
<?php
if($message != '') echo '<br><p class="notice">'.$message.'</p>';
if(AUTH_INACTIVE===true) echo '<br><p class="notice">Account disabled</p>';
?>
<br/>
<pre><strong>Aspect</strong> \As'pect\, n. (A['e]ronautics)
   A view of a plane from a given direction, usually from above;
   more exactly, the manner of presentation of a plane to a
   fluid through which it is moving or to a current. If an
   immersed plane meets a current of fluid long side foremost,
   or in broadside aspect, it sustains more pressure than when
   placed short side foremost. Hence, long narrow wings are more
   effective than short broad ones of the same area.
</pre>

	Source: <em>Webster's Revised Unabridged Dictionary (1913)</em>

</center>
<?php
require("inc/inc.footer.php");
die();
?>
