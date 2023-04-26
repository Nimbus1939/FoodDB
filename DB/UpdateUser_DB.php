<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../Functions.php"); // inkluder filen med globale funktioner.
include("TextConv.php"); //Inkluder filen der omkoder specialtegn
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gemmer i database</title>
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../ShowUser.php?UserID=".$_POST['UserID']."\">";
echo"</head>";
//konverter tekst til HTML værdier for at fjerne specialtegn
$CUserName = ConvertText($_POST[UserName]);
$CUserAlias = ConvertText($_POST[UserAlias]);
$CPass = ConvertText($_POST[Pass]);
$CRemarks = ConvertText($_POST[Remarks]);
//Opdater Database
mysqli_query($link, "UPDATE Users SET UserName='".$CUserName."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET UserAlias='".$CUserAlias."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET UserMail='".($_POST['Mail'])."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET UserPass='".$CPass."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET EditDate='20".(date("y-m-d"))."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET Sex='".($_POST['Sex'])."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET Role='".($_POST['Rolle'])."' WHERE UserID = '".($_POST['UserID'])."'");
mysqli_query($link, "UPDATE Users SET Remarks='".$CRemarks."' WHERE UserID = '".($_POST['UserID'])."'");
CloseDB($link);
?> 

<body>
</body>
</html>