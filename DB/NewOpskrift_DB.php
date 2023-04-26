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
$COverskrift = ConvertText($_POST[Overskrift]);
$CUnderoverskrift = ConvertText($_POST[Underoverskrift]);
// indsæt i Databasen
$Qoverskrift = "INSERT INTO Opskrift (Overskrift, Underoverskrift, Kuverter, Content, Kilde) VALUES ('$COverskrift','$CUnderoverskrift','$_POST[Kuverter]','$_POST[Content]','$_POST[Kilde]')";
mysqli_query($link, $Qoverskrift);
$QMaxID = "SELECT OpskriftID FROM Opskrift ORDER BY OpskriftID DESC LIMIT 0,1";
$MaxID = mysqli_query($link, $QMaxID);
$row = mysqli_fetch_assoc($MaxID);
$Qopskrifttokategori = "INSERT INTO OpskriftToKategori (KategoriID, OpskriftID) VALUES ('$_POST[Kategori]','".$row['OpskriftID']."')";
$Qopskrifttotype = "INSERT INTO OpskriftToType (TypeID, OpskriftID) VALUES ('$_POST[Type]','".$row['OpskriftID']."')";
mysqli_query($link, $Qopskrifttokategori);
mysqli_query($link, $Qopskrifttotype);
if (!empty($_POST[Tag]))
	{
		foreach ($_POST[Tag] as $key=>$value)
			{
				$Qopskrifttotag = "INSERT INTO OpskriftToTag (TagID, OpskriftID) VALUES ('$value','".$row['OpskriftID']."')";
				mysqli_query($link, $Qopskrifttotag);
			}
	}

CloseDB($link);
?> 

<body>
</body>
</html>
