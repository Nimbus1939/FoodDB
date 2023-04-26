<?php
session_start();
include("../food/DB/connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../food/Functions.php"); // inkluder filen med globale funktioner.
include("../food/DB/GetAvgRating_DB.php");//Inkluder funktionen der returnerer gennemsnitlig opskrift rating, som kommatal
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();
$Qsider = "Select * FROM Links WHERE Placeholder='RightMenu' ORDER BY SortOrder DESC";
$Qtyper = "Select * FROM Type ORDER BY SortOrder DESC";
$Qkategori = "Select * FROM Kategori ORDER BY SortOrder DESC";
$Qtags = "Select * FROM Tags ORDER BY SortOrder DESC";
$QqueryRating = "Select * FROM OpskriftToRating WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC";
$QqueryOverskrift = "Select Overskrift FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID']);
$queryRating = mysqli_query($link, $QqueryRating);
$queryOverskrift = mysqli_query($link, $QqueryOverskrift);
$sider = mysqli_query($link, $Qsider);
$typer = mysqli_query($link, $Qtyper);
$kategori = mysqli_query($link, $Qkategori);
$tags = mysqli_query($link, $Qtags);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../food/theme/variety/default.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mettes opskrifter</title>
</head>
<body>
<script type="text/javascript" src="../food/Editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	theme : "advanced",
	mode : "textareas",
	});
</script>

<div id="title">
	<h1><a href="../food/index.php">Mettes opskrifter</a></h1>
	<h2><a href="http://www.landly.dk">by Thomas Nylander Nørgaard</a></h2>

</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
        	<?php
				while($rowOverskrift = mysqli_fetch_assoc($queryOverskrift)) //En while der kører alle rækker igennem, og udskriver Ratinger
					{
						echo "<h2>Ratings for <a href=\"ShowOpskrift.php?OpskriftID=".($_GET['OpskriftID'])."\">".$rowOverskrift['Overskrift']."</a></h2>\n<p>";
					}
					//beregn og udskriv gennemsnitlig rating
					echo "Gennemsnitlig rating: ";
					$i=1;
					$GennemsnitRating = (round(GetAvgRating($_GET['OpskriftID'])));
					while ($i++<=$GennemsnitRating)
						{
							echo "<img src=\"../food/Images/gold-star.gif\">";
						}
					echo "<br/><hr/>";
					while($rowRating = mysqli_fetch_assoc($queryRating)) //En while der kører alle rækker igennem, og udskriver Ratinger
					{
						$QqueryRatingName = "Select * FROM Rating WHERE RatingID=".($rowRating['RatingID'])." ORDER BY CreateDate DESC";
						$queryRatingName = mysqli_query ($link, $QqueryRatingName);
						while($rowRatingName = mysqli_fetch_assoc($queryRatingName)) //En while der kører alle rækker igennem,
							{
								echo $rowRatingName['RatingContent'];
								$i=1; //tællervariable
								while ($i++<=$rowRatingName['Stars'])
									{
										echo "<img src=\"../food/Images/gold-star.gif\">";
									}
								echo "<p><a href=\"EditRating.php?RatingID=".$rowRatingName['RatingID']."&OpskriftID=".$_GET['OpskriftID']."\">Rediger denne rating</a><br />";
								echo "<a href=\"DB/DeleteRating_DB.php?RatingID=".$rowRatingName['RatingID']."&OpskriftID=".$_GET['OpskriftID']."\">Slet denne rating</a><br />";
								echo "<p><i>Oprettet: ".$rowRatingName['CreateDate']."</i>\n";
								if (!($rowRatingName['EditDate']==NULL))
									{
										echo "<br />Opdateret: " .$rowRatingName['EditDate']."</p><hr>\n";
									}
								else
									{
										echo "</p><hr>";
									}
							}
					}
				echo "<br/><br/>";
				//form til oprettelse af rating
				echo "<form action=\"DB/NewRating_DB.php\" method=\"post\" enctype=\"application/x-www-form-urlencoded\" name=\"NewRating\">";
          		echo "<textarea name=\"Content\" cols=\"50\" rows=\"5\"></textarea>";
				echo "<p>";
				echo "Stjerner: <br/>";
        		echo "<label>";
        		echo "<input type=\"radio\" name=\"NewRating\" value=\"0\" />";
        		echo "0 </label>";
        		echo "<label>";
        		echo "<input type=\"radio\" name=\"NewRating\" value=\"1\" />";
        		echo "1 </label>";
        		echo "<label>";
        		echo "<input type=\"radio\" name=\"NewRating\" value=\"2\" />";
        		echo "2 </label>";
        		echo "<label>";
        		echo "<input type=\"radio\" name=\"NewRating\" value=\"3\" />";
        		echo "3 </label>";
        		echo "<label>";
        		echo "<input type=\"radio\" name=\"NewRating\" value=\"4\" />";
        		echo "4 </label>";
        		echo "<label>";
        		echo "<input type=\"radio\" name=\"NewRating\" value=\"5\" />";
        		echo "5 </label>";
        		echo "<br />";
      			echo "</p>";
          		echo "<input name=\"OpskriftID\" type=\"hidden\" value=\"".($_GET['OpskriftID'])."\" />";
           		echo "<input type=\"submit\" id=\"opret-submit\" value=\"Tilføj ny\" />";
           		echo "<input name=\"Reset\" id=\"opret-reset\" type=\"Reset\" />";
				echo "</form>";
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
