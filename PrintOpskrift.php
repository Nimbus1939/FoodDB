<?php
session_start();
include("../food/DB/connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../food/Functions.php"); // inkluder filen med globale funktioner.
//CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mettes opskrifter</title>
</head>
<body onLoad="window.print();return false" topmargin="0" bgcolor="#FFFFFF" >
<?php
include("../food/DB/GetAvgRating_DB.php");//Inkluder funktionen der returnerer gennemsnitlig opskrift rating, som kommatal
?>
<h3>Udskrevet fra Mettes Opskrifter</h3>
<?php
	$query = mysqli_query($link, "Select * FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY CreateDate DESC");
	$queryType = mysqli_query($link, "Select * FROM OpskriftToType WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY TypeID DESC");
	$queryTag = mysqli_query($link, "Select * FROM OpskriftToTag WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY TagID DESC");
	$queryKategori = mysqli_query($link, "Select * FROM OpskriftToKategori WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY KategoriID DESC");
	$queryKommentar = mysqli_query($link, "Select * FROM OpskriftToComment WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC");
	
	while($row = mysqli_fetch_assoc($query)) //En while der kører alle rækker igennem,
	{
	echo "<h2>".$row['Overskrift'] . "</h2>\n";
	echo "<h3> - ".$row['Underoverskrift'] . "</h3>\n";
	echo "<p>Kuverter: ".$row['Kuverter']."<br>";
	//beregn og udskriv gennemsnitlig rating
	echo "Gennemsnitlig rating: ";
	$i=1;
	$GennemsnitRating = (round(GetAvgRating($_GET['OpskriftID'])));
	while ($i++<=$GennemsnitRating)
		{
			echo "<img src=\"../food/Images/gold-star.gif\">";
		}
	echo "<br/>";
	echo "</p>\n<p>Oprettet: " . $row['CreateDate']."\n";
	if (!($row['EditDate']==NULL))
		{
			echo "<br />Opdateret: " .$row['EditDate']."</p>\n";
		}
	else
		{
		echo "</p>";
		}
	echo $row['Content'];
	echo "<p><i>kilde: ".$row['Kilde'] . "</i></p>\n";
	while($rowType = mysqli_fetch_assoc($queryType)) //En while der kører alle rækker igennem, og udskriver type
		{
		$queryTypeName = mysqli_query($link, "Select * FROM Type WHERE TypeID=".($rowType['TypeID'])." ORDER BY TypeID DESC");
		while($rowTypeName = mysqli_fetch_assoc($queryTypeName)) //En while der kører alle rækker igennem,
			{
				echo "<h4>Type: ".$rowTypeName['TypeName']."</h4>\n";
			}
		}
	while($rowKategori = mysqli_fetch_assoc($queryKategori)) //En while der kører alle rækker igennem, og udskriver kategori
		{
		$queryKategoriName = mysqli_query($link, "Select * FROM Kategori WHERE KategoriID=".($rowKategori['KategoriID'])." ORDER BY KategoriID DESC");
		while($rowKategoriName = mysqli_fetch_assoc($queryKategoriName)) //En while der kører alle rækker igennem,
			{
				echo "<h4>Kategori: ".$rowKategoriName['KategoriName']."</h4>\n";
			}
		}
	echo "<h4>Tags: ";
	while($rowTag = mysqli_fetch_assoc($queryTag)) //En while der kører alle rækker igennem, og udskriver tags
		{
		$queryTagName = mysqli_query($link, "Select * FROM Tags WHERE TagID=".($rowTag['TagID'])." ORDER BY TagID DESC");
		while($rowTagName = mysqli_fetch_assoc($queryTagName)) //En while der kører alle rækker igennem,
			{
				echo $rowTagName['TagName'].", \n";
			}
		}
	}
	echo "</h4><br/>\n";
	echo "Kommentarer:</br><br/><hr>";
	while($rowKommentar = mysqli_fetch_assoc($queryKommentar)) //En while der kører alle rækker igennem, og udskriver Kommentarer
		{
		$queryKommentarName = mysqli_query($link, "Select * FROM Kommentar WHERE CommentID=".($rowKommentar['CommentID'])." ORDER BY CreateDate DESC");
		while($rowKommentarName = mysqli_fetch_assoc($queryKommentarName)) //En while der kører alle rækker igennem,
			{
				echo $rowKommentarName['Content'];
				echo "<p><a href=\"EditKommentar.php?CommentID=".$rowKommentar['CommentID']."&OpskriftID=".$_GET['OpskriftID']."\">Rediger denne kommentar</a><br />";
				echo "<a href=\"DB/DeleteKommentar_DB.php?CommentID=".$rowKommentar['CommentID']."&OpskriftID=".$_GET['OpskriftID']."\">Slet denne kommentar</a><br />";
				echo "<i>Oprettet: ".$rowKommentarName['CreateDate'];
				if (!($rowKommentarName['EditDate']==NULL))
					{
						echo "<br />Opdateret: " .$rowKommentarName['EditDate'];
						echo "</p><hr></i>\n";
					}
				else
					{
						echo "</p><hr></i>\n";
					}
			}
		}
	echo "</p>";
	CloseDB($link);
?>


</body>
</html>
