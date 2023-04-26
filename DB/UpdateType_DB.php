<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../Functions.php"); // inkluder filen med globale funktioner.
include("TextConv.php"); //Inkluder filen der omkoder specialtegn
//CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gemmer i database</title>
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../ShowType.php?TypeID=".$_POST['TypeID']."\">";
echo"</head>";
//konverter tekst til HTML værdier for at fjerne specialtegn
$CTypeName = ConvertText($_POST[TypeName]);
// Opdater Database
mysqli_query($link, "UPDATE Type SET TypeName='".$CTypeName."' WHERE TypeID = '".($_POST['TypeID'])."'");
mysqli_query($link, "UPDATE Type SET Content='".($_POST['Content'])."' WHERE TypeID = '".($_POST['TypeID'])."'");
mysqli_query($link, "UPDATE Type SET EditDate='20".(date("y-m-d"))."' WHERE TypeID = '".($_POST['TypeID'])."'");
//Luk Database  
CloseDB($link);
?> 
</html>
