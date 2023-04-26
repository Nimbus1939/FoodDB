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
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../ShowOpskrift.php?OpskriftID=".$_GET['OpskriftID']."\">";
echo "</head>";
	//echo "DELETE FROM OpskriftToComment WHERE OpskriftID = '".$_GET['OpskriftID']."'";
	//echo "DELETE FROM Kommentar WHERE CommentID='".$_GET['CommentID']."'";
	mysqli_query($link, "DELETE FROM OpskriftToComment WHERE CommentID='".$_GET['CommentID']."'");
	mysqli_query($link, "DELETE FROM Kommentar WHERE CommentID='".$_GET['CommentID']."'");
CloseDB($link);
?> 

<body>
</body>
</html>
