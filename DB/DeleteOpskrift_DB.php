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
<title>Sletter i database</title>
<meta http-equiv="refresh" content="0;URL=../index.php">
</head>
<?php
	$queryKommentar = mysqli_query($link, "Select * FROM OpskriftToComment WHERE OpskriftID=".($_POST['OpskriftID']));
	while($rowKommentar = mysqli_fetch_assoc($queryKommentar)) //En while der kører alle rækker igennem, og sletter alle kommentarer til opskriften
	{
		mysqli_query($link, "DELETE FROM Kommentar WHERE CommentID = '".($rowKommentar['CommentID'])."'");
	}
	$queryRating = mysqli_query($link, "Select * FROM OpskriftToRating WHERE OpskriftID=".($_POST['OpskriftID']));
	while($rowRating = mysqli_fetch_assoc($queryRating)) //En while der kører alle rækker igennem, og sletter alle ratings til opskriften
	{
		mysqli_query($link, "DELETE FROM Rating WHERE RatingID = '".($queryRating['RatingID'])."'");
	}
	mysqli_query($link, "DELETE FROM OpskriftToTag WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM OpskriftToComment WHERE OpskriftID='".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM OpskriftToRating WHERE OpskriftID='".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM OpskriftToType WHERE OpskriftID='".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM OpskriftToKategori WHERE OpskriftID='".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM OpskriftToUsers WHERE OpskriftID='".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM ServedWith WHERE OpskriftID='".($_POST['OpskriftID'])."'");
	mysqli_query($link, "DELETE FROM Opskrift WHERE OpskriftID='".($_POST['OpskriftID'])."'");
CloseDB();
?> 
<body>
</body>
</html>
