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
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../ShowRatings.php?OpskriftID=".$_POST['OpskriftID']."\">";
echo"</head>";
$queryStars = mysqli_query($link, "Select * FROM Rating WHERE RatingID='".($_POST['RatingID'])."' ORDER BY CreateDate DESC");
while($rowStars = mysqli_fetch_assoc($queryStars)) //En while der kører alle rækker igennem
	{
		if (!($rowStars['Stars'] == $_POST['NewRating']) AND (!($_POST['NewRating'] == NULL)))
			{
				mysqli_query($link, "UPDATE Rating SET Stars='".($_POST['NewRating'])."' WHERE RatingID = '".($_POST['RatingID'])."'");
			}
	}
mysqli_query($link, "UPDATE Rating SET RatingContent='".($_POST['RatingContent'])."' WHERE RatingID = '".($_POST['RatingID'])."'");
mysqli_query($link, "UPDATE Rating SET EditDate='20".(date("y-m-d"))."' WHERE RatingID = '".($_POST['RatingID'])."'");
CloseDB($link);
?> 

</html>
