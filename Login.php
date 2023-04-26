<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../food/theme/variety/default.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log på Mettes opskrifter</title>

</head>
<body>
<div id="title">
	<h1>Mettes opskrifter</h1>
	<h2><a href="http://www.landly.dk">by Thomas Nørgaard </a></h2>
</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
    <h2>Log på Mettes opskrifter</h2><br />
    <table>
    <form action="../food/DB/Login_DB.php" method="post">
    <tr><td>Alias:</td><td><input name="UserAlias" type="text" /></td></tr>
    <tr><td>Kodeord:</td><td><input name="Password" type="password" /></td></tr>
    <tr><td><input name="LogIn" id="opret-submit" type="submit" value="Log p&aring;" /></td><td>&nbsp;</td></tr>
    </form>
    </table><br />
    <h4>OBS! Systemet skelner mellem store og små bogstaver</h4>
    <p>Hvis du ikke er bruger, og gerne vil være det <br />så send os en mail, du har adressen.</p>
<?php

?>
    </div>
	<div id="colTwo">

	</div>
	<div style="clear: both;">&nbsp;</div>
</div>
<div id="footer">
	<p>Copyright &copy; 2010 Thomas Nørgaard. CSS Designed by <a href="http://www.freecsstemplates.org/" target="_blank"><strong>Free CSS Templates</strong></a></p>

</div>

</body>
</html>
