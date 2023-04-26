<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../Functions.php"); // inkluder filen med globale funktioner.
include("TextConv.php"); //Inkluder filen der omkoder specialtegn
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gemmer i database</title>
<meta http-equiv="refresh" content="0;URL=../index.php">
</head>
<?php
//konverter tekst til HTML værdier for at fjerne specialtegn
$CLinkText = ConvertText($_POST[LinkText]);
mysqli_query($link, "INSERT INTO Links(LinkText, URL, Target, Placeholder, SG) VALUES ('$CLinkText','$_POST[URL]','$_POST[Target]','$_POST[Placeholder]','$_POST[SG]')");
CloseDB($link);
?> 

<body>
</body>
</html>
