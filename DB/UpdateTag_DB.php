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
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../ShowTag.php?TagID=".$_POST['TagID']."\">";
echo"</head>";
//konverter tekst til HTML værdier for at fjerne specialtegn
$CTagName = ConvertText($_POST[TagName]);
//opdater database
$QTagName = "UPDATE Tags SET TagName='".$CTagName."' WHERE TagID = '".($_POST['TagID'])."'";
$QContent = "UPDATE Tags SET Content='".($_POST['Content'])."' WHERE TagID = '".($_POST['TagID'])."'";
$QEditDate = "UPDATE Tags SET EditDate='20".(date("y-m-d"))."' WHERE TagID = '".($_POST['TagID'])."'";
mysqli_query($link, $QTagName);
mysqli_query($link, $QContent);
mysqli_query($link, $QEditDate);
CloseDB($link);
?> 
</html>
