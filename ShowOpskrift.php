<?php
session_start();
include("../food/DB/connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../food/Functions.php"); // inkluder filen med globale funktioner.
//CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
include("../food/DB/GetAvgRating_DB.php");//Inkluder funktionen der returnerer gennemsnitlig opskrift rating, som kommatal
$link = OpenDB();
$Qsider = "Select * FROM Links WHERE Placeholder='RightMenu' ORDER BY SortOrder DESC";
$Qtyper = "Select * FROM Type ORDER BY SortOrder DESC";
$Qkategori = "Select * FROM Kategori ORDER BY SortOrder DESC";
$Qtags = "Select * FROM Tags ORDER BY SortOrder DESC";
$Qqueryopskrift = "Select * FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY CreateDate DESC";
$QqueryType = "Select * FROM OpskriftToType WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY TypeID DESC";
$QqueryTag = "Select * FROM OpskriftToTag WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY TagID DESC";
$QqueryKategori = "Select * FROM OpskriftToKategori WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY KategoriID DESC";
$QqueryKommentar = "Select * FROM OpskriftToComment WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC";
$sider = mysqli_query($link, $Qsider);
$typer = mysqli_query($link, $Qtyper);
$kategori = mysqli_query($link, $Qkategori);
$tags = mysqli_query($link, $Qtags);
$queryopskrift = mysqli_query($link, $Qqueryopskrift);
$queryType = mysqli_query($link, $QqueryType);
$queryTag = mysqli_query($link, $QqueryTag);
$queryKategori = mysqli_query($link, $QqueryKategori);
$queryKommentar = mysqli_query($link, $QqueryKommentar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../food/theme/variety/default.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../food/Editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	theme : "advanced",
	mode : "textareas",
});
function ConfirmDelete()
	{
		var r=confirm("Er du sikker på du vil slette denne opskrift?");
		return r;
	}
</script>
<title>Mettes opskrifter</title>
</head>
<body>
<div id="title">
	<h1><a href="../food/index.php">Mettes opskrifter</a></h1>
	<h2><a href="http://www.landly.dk">by Thomas Nylander Nørgaard </a></h2>
</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
       		<?php
				$Qqueryopskrift = "Select * FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY CreateDate DESC";
				$QqueryType = "Select * FROM OpskriftToType WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY TypeID DESC";
				$QqueryTag = "Select * FROM OpskriftToTag WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY TagID DESC";
				$QqueryKategori = "Select * FROM OpskriftToKategori WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY KategoriID DESC";
				$QqueryKommentar = "Select * FROM OpskriftToComment WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC";
				//$queryServedWith = mysqli_query("Select * FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY CreateDate DESC") OR DIE(mysql_error());
				//$queryUsers = mysqli_query("Select * FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY CreateDate DESC") OR DIE(mysql_error());
				echo "<A href=\"PrintOpskrift.php?OpskriftID=".$_GET['OpskriftID']."\" target=\"_blank\"><img src=\"Images/print_ikon.gif\" border=\"0\" /> </a>";
				while($row = mysqli_fetch_assoc($queryopskrift)) //En while der kører alle rækker igennem,
				{
				echo "<h2>".$row['Overskrift'] . "</h2>\n";
				echo "<h3> - ".$row['Underoverskrift'] . "</h3>\n";
				echo "<p>Kuverter: ".$row['Kuverter'] . "<br/>";
					//beregn og udskriv gennemsnitlig rating
					echo "Gennemsnitlig rating: ";
					$i=1;
					$GennemsnitRating = (round(GetAvgRating($_GET['OpskriftID'])));
					while ($i++<=$GennemsnitRating)
						{
							echo "<img src=\"../food/Images/gold-star.gif\">";
						}
					echo "<br/>";
				echo "<A href=\"ShowRatings.php?OpskriftID=".$_GET['OpskriftID']."\"> Vis alle ratings</a><hr/>";
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
					$QqueryTypeName = "Select * FROM Type WHERE TypeID=".($rowType['TypeID'])." ORDER BY TypeID DESC";
					$queryTypeName = mysqli_query($link, $QqueryTypeName);
					while($rowTypeName = mysqli_fetch_assoc($queryTypeName)) //En while der kører alle rækker igennem,
						{
							echo "<h4>Type: <a href=\"ShowType.php?TypeID=".$rowTypeName['TypeID']."\">".$rowTypeName['TypeName']."</a></h4>\n";
						}
					}
				while($rowKategori = mysqli_fetch_assoc($queryKategori)) //En while der kører alle rækker igennem, og udskriver kategori
					{
					$QqueryKategoriName = "Select * FROM Kategori WHERE KategoriID=".($rowKategori['KategoriID'])." ORDER BY KategoriID DESC";
					$queryKategoriName = mysqli_query($link, $QqueryKategoriName);
					while($rowKategoriName = mysqli_fetch_assoc($queryKategoriName)) //En while der kører alle rækker igennem,
						{
							echo "<h4>Kategori: <a href=\"ShowKategori.php?KategoriID=".$rowKategoriName['KategoriID']."\">".$rowKategoriName['KategoriName']."</a></h4>\n";
						}
					}
				echo "<h4>Tags: ";
				while($rowTag = mysqli_fetch_assoc($queryTag)) //En while der kører alle rækker igennem, og udskriver tags
					{
					$QqueryTagName = "Select * FROM Tags WHERE TagID=".($rowTag['TagID'])." ORDER BY TagID DESC";
					$queryTagName = mysqli_query($link, $QqueryTagName);
					while($rowTagName = mysqli_fetch_assoc($queryTagName)) //En while der kører alle rækker igennem,
						{
							echo "<a href=\"ShowTag.php?TagID=".$rowTagName['TagID']."\">".$rowTagName['TagName']."</a>, \n";
						}
					}
				}
				echo "</h4><br/>\n";
				echo $_COOKIE['Login'];				
				echo "Kommentarer:</br><br/><hr>";
				while($rowKommentar = mysqli_fetch_assoc($queryKommentar)) //En while der kører alle rækker igennem, og udskriver Kommentarer
					{
					$QqueryKommentarName = "Select * FROM Kommentar WHERE CommentID=".($rowKommentar['CommentID'])." ORDER BY CreateDate DESC";
					$queryKommentarName = mysqli_query($link, $QqueryKommentarName);
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
				//form til oprettelse af kommentar
				echo "<form action=\"DB/NewKommentar_DB.php\" method=\"post\" enctype=\"application/x-www-form-urlencoded\" name=\"NewKommentar\">";
          		echo "<textarea name=\"Content\" cols=\"50\" rows=\"5\"></textarea><br />";
          		echo "<input name=\"OpskriftID\" type=\"hidden\" value=\"".($_GET['OpskriftID'])."\" />";
           		echo "<input type=\"submit\" id=\"opret-submit\" value=\"Tilføj ny\" />";
           		echo "<input name=\"Reset\" id=\"opret-reset\" type=\"Reset\" />";
				echo "</form>";
				echo "<hr>";
				echo "</p>";
				// formular til sletning af Opskrift
				echo "<form onSubmit=\"return(ConfirmDelete())\" action=\"DB/DeleteOpskrift_DB.php\" method=\"post\">\n";
				echo "<input name=\"OpskriftID\" type=\"hidden\" value=\"".$_GET['OpskriftID']."\" />\n";
				echo "<input name=\"submit\" id=\"opret-submit\" type=\"submit\" value=\"Slet Opskrift\" />\n";
				echo "</form>\n";
				echo "<p> Du kan også vælge at redigere i denne opkrift.<br /> Dette gøres ved at klikke <a href=\"EditOpskrift.php?OpskriftID=".$_GET['OpskriftID']."\"> HER </a>";
			?>

    </div>
	<div id="colTwo">
		<ul>
			<li>
				<form method="post" action="SearchResult.php">
					<div>
						<input type="text" id="textfield1" name="textfield1" value="" size="18" />
						<input type="submit" id="submit1" name="submit1" value="Søg" />
					</div>
				</form>
			</li>
			<li>
				<h2>Sider</h2>
				<ul>
					<?php
						while($rowsider = mysqli_fetch_assoc($sider)) //En while der kører alle rækker igennem
						{
							if ($rowsider['SG']>= $_SESSION['Role'])
							{
								echo "<LI><A href=\"".$rowsider['URL']."\" Target=\"_".$rowsider['Target']."\">".$rowsider['LinkText']."</a></LI>\n";
							}
						}
                    ?>
				</ul>
			</li>
			<li>
				<h2>Typer</h2>
				<ul>
					<?php
						while($rowtyper = mysqli_fetch_assoc($typer)) //En while der kører alle rækker igennem
						{
						echo "<LI><A href=\"../food/ShowType.php?TypeID=".$rowtyper['TypeID']."\">".$rowtyper['TypeName']."</a></LI>\n";
						}
                    ?>					
				</ul>
			</li>
			<li>
				<h2>Kategorier</h2>
				<ul>
					<?php
						while($rowkategori = mysqli_fetch_assoc($kategori)) //En while der kører alle rækker igennem
						{
						echo "<LI><A href=\"../food/ShowKategori.php?KategoriID=".$rowkategori['KategoriID']."\">".$rowkategori['KategoriName']."</a></LI>\n";
						}
                    ?>
				</ul>
			</li>
			<li>
				<h2>Tags</h2>
				<ul>
					<?php
						while($rowtags = mysqli_fetch_assoc($tags)) //En while der kører alle rækker igennem
						{
						echo "<LI><A href=\"../food/ShowTag.php?TagID=".$rowtags['TagID']."\">".$rowtags['TagName']."</a></LI>\n";
						}
                    ?>
				</ul>
			</li>
			<li>
				<h2></h2>
				<ul>
					<li></li>
				</ul>
			</li>
		</ul>
	</div>
	<div style="clear: both;">&nbsp;</div>
</div>
<div id="footer">
	<p>Copyright &copy; 2010-2020 Thomas Nylander Nørgaard. CSS Designed by <a href="http://www.freecsstemplates.org/" target="_blank"><strong>Free CSS Templates</strong></a></p>

</div>

</body>
<?PHP
CloseDB($link);
?>
</html>
