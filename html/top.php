<?php
require("inc/inc.init.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>:: a s p e c t ::</title>
<link rel="stylesheet" href="aspect.css">
</head>
<body class="top">

<table border="0" width="100%">
<tr>
	<td>&nbsp;
		<a href="index_aspect.php" class="menu" target="bf">legend</a>&nbsp;::&nbsp;
		<a href="rules.php" class="menu" target="bf">view rules</a>&nbsp;::&nbsp;

		<?php if(AUTH_ADMIN===true || AUTH_ALLOWSQL===true) {?>
		<a href="modules/search/search.php" class="menu" target="bf">search</a>&nbsp;::&nbsp;
		<?php } ?>

		<?php if(AUTH_ADMIN===true) {?>
		<a href="useradmin.php" class="menu" target="bf">user admin</a>&nbsp;::&nbsp;
		<?php } ?>

		<a href="mypage.php" class="menu" target="bf">my page</a>&nbsp;::&nbsp;
		<a href="index.php?logout=1" class="menu" target="_top">logout</a>&nbsp;
	</td>

	<td align="right">
		<a href="index.php" target="_top"><img src="images/aspect2.gif" width="50%" height="50%" align="right" border="no"></a>
	</td>
</tr>
</table>&nbsp;

</body>
</html>
