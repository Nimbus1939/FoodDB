<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer og forbinder til databasen
include("../Functions.php"); // inkluder filen med globale funktioner.
include("TextConv.php"); //Inkluder filen der omkoder specialtegn
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();//åbner database
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gemmer i database</title>
<?php
echo "<meta http-equiv=\"refresh\" content=\"0;URL=../SortOrderEdit.php?Placeholder=".$_POST['Placeholder']."\">";
echo"</head>";
Switch ($_POST['Placeholder'])
	{
		case "Typer":
				foreach ($_POST['LinkID'] as $value)
				{
					//echo "<br>UPDATE Type SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE TypeID = '".$value."'";
					mysqli_query($link, "UPDATE Type SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE TypeID = '".$value."'");
					next($_POST['NewSortOrder']);
				}
				break;
		case "Kategorier":
				foreach ($_POST['LinkID'] as $value)
				{
					//echo "<br>UPDATE Kategori SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE KategoriID = '".$value."'";
					mysqli_query($link, "UPDATE Kategori SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE KategoriID = '".$value."'");
					next($_POST['NewSortOrder']);
				}
				break;
		case "Tags":
				foreach ($_POST['LinkID'] as $value)
				{
					//echo "<br>UPDATE Tags SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE TagID = '".$value."'";
					mysqli_query($link, "UPDATE Tags SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE TagID = '".$value."'");
					next($_POST['NewSortOrder']);
				}
				break;
		default:
			foreach ($_POST['LinkID'] as $value)
				{
					//echo "<br>UPDATE Links SET SortOrder='".(current($_POST['NewSortOrder']))."' WHERE LinkID = '".$value."'";
					mysqli_query($link, "UPDATE Links SET Sortorder='".(current($_POST['NewSortOrder']))."' WHERE LinkID = '".$value."'");
					next($_POST['NewSortOrder']);
				}
	}
	
CloseDB($link);
?> 

</html>
