<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../Functions.php"); // inkluder filen med globale funktioner.
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sletter i database</title>
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../SelectLink.php\">";
echo "</head>";
$link = OpenDB();
mysqli_query($link, "DELETE FROM Links WHERE LinkID='".$_GET['LinkID']."'");
CloseDB($link);
?> 

<body>
</body>
</html>
