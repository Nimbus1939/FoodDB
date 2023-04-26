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
<body>
<?php
//konverter tekst til HTML værdier for at fjerne specialtegn
$CUserName = ConvertText($_POST[UserName]);
$CPass = ConvertText($_POST[Pass]);
$CUserAlias = ConvertText($_POST[UserAlias]);
$CRemarks = ConvertText($_POST[Remarks]);
// Gem i database
//echo "SQL: INSERT INTO Users (UserName, Sex, UserPass, UserMail, Role, UserAlias, Remarks) VALUES ('$CUserName','$_POST[Sex]','$CPass','$_POST[Mail]','$_POST[Rolle]','$CUserAlias','$CRemarks')";
mysqli_query($link, "INSERT INTO Users (UserName, Sex, UserPass, UserMail, Role, UserAlias, Remarks) VALUES ('$CUserName','$_POST[Sex]','$CPass','$_POST[Mail]','$_POST[Rolle]','$CUserAlias','$CRemarks')");
CloseDB($link);
?> 
</body>
</html>
