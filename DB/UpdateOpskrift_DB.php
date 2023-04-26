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
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../ShowOpskrift.php?OpskriftID=".$_POST['OpskriftID']."\">";
echo"</head>";
//konverter tekst til HTML værdier for at fjerne specialtegn
$COverskrift = ConvertText($_POST[Overskrift]);
$CUnderoverskrift = ConvertText($_POST[Underoverskrift]);
// Opdater Database
mysqli_query($link, "UPDATE Opskrift SET Overskrift='".$COverskrift."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE Opskrift SET Underoverskrift='".$CUnderoverskrift."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE Opskrift SET Kuverter='".($_POST['Kuverter'])."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE Opskrift SET Content='".($_POST['Content'])."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE Opskrift SET Kilde='".($_POST['Kilde'])."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE Opskrift SET EditDate='20".(date("y-m-d"))."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE OpskriftToType SET TypeID='".($_POST['TypeID'])."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "UPDATE OpskriftToKategori SET KategoriID='".($_POST['KategoriID'])."' WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
mysqli_query($link, "DELETE FROM OpskriftToTag WHERE OpskriftID = '".($_POST['OpskriftID'])."'");
if (!empty($_POST[Tag]))
	{
		foreach ($_POST[Tag] as $key=>$value)
			{
				mysqli_query($link, "INSERT INTO OpskriftToTag (TagID, OpskriftID) VALUES ('$value','".($_POST['OpskriftID'])."')");
			}
	}
CloseDB($link);
?> 

<body>
</body>
</html>