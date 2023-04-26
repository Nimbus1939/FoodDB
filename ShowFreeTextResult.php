<?php
session_start();
include("../food/DB/connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../food/Functions.php"); // inkluder filen med globale funktioner.
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();
$Qpost = "Select * FROM Posts ORDER BY CreateDate DESC";
$Qsider = "Select * FROM Links WHERE Placeholder='RightMenu' ORDER BY SortOrder DESC";
$Qtyper = "Select * FROM Type ORDER BY SortOrder DESC";
$Qkategori = "Select * FROM Kategori ORDER BY SortOrder DESC";
$Qtags = "Select * FROM Tags ORDER BY SortOrder DESC";
$post = mysqli_query($link, $Qpost);
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
<div id="title">
	<h1><a href="../food/index.php">Mettes opskrifter</a></h1>
	<h2><a href="http://www.landly.dk">by Thomas Nylander Nørgaard </a></h2>

</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
        <h2>Resultat af fritekstsøgning</h2><br/>
        <?php
			echo "<br>Du søgte efter: ".$_POST['SearchText'];
			if (!($_POST['Content'] == NULL))
				{
					$queryContent = mysqli_query($link, "Select * FROM Opskrift Where Content LIKE '%".$_POST['SearchText']."%' ORDER BY OpskriftID DESC");
					echo "<p>Søgeresultat for søgning i opskriftindhold</p><ul>";
					while ($rowContent = mysqli_fetch_assoc($queryContent))
						{
							echo "<li><a href=\"ShowOpskrift.php?OpskriftID=".$rowContent['OpskriftID']."\">".$rowContent['Overskrift']."</a></LI>";
						}
					echo "</ul>";
				}
			if (!($_POST['Kommentar'] == NULL))
				{
					echo "<p>Søgeresultat for søgning i kommentarer</p><ul>";
					$queryKommentar = mysqli_query($link, "Select CommentID FROM Kommentar Where Content LIKE '%".$_POST['SearchText']."%' ORDER BY CommentID DESC");
					while ($rowKommentar = mysqli_fetch_assoc($queryKommentar))
						{
							$queryOpskriftToComment = mysqli_query($link, "Select OpskriftID FROM OpskriftToComment Where CommentID='".$rowKommentar['CommentID']."' ORDER BY OpskriftID DESC");
							while($rowOpskriftToComment = mysqli_fetch_assoc($queryOpskriftToComment))
								{
									$queryContent = mysqli_query($link, "Select * FROM Opskrift Where OpskriftID='".$rowOpskriftToComment['OpskriftID']."' ORDER BY OpskriftID DESC");
									while ($rowContent = mysqli_fetch_assoc($queryContent))
										{
											echo "<li><a href=\"ShowOpskrift.php?OpskriftID=".$rowContent['OpskriftID']."\">".$rowContent['Overskrift']."</a></LI>";
										}
								}
						}
					echo "</ul>";
				}
			if (!($_POST['Rating'] == NULL))
				{
					echo "<p>Søgeresultat for søgning i ratings</p><ul>";
					$queryRating = mysqli_query($link, "Select RatingID FROM Rating Where RatingContent LIKE '%".$_POST['SearchText']."%' ORDER BY RatingID DESC");
					while ($rowRating = mysqli_fetch_assoc($queryRating))
						{
							$queryOpskriftToRating = mysqli_query($link, "Select OpskriftID FROM OpskriftToRating Where RatingID='".$rowRating['RatingID']."' ORDER BY OpskriftID DESC");
							while($rowOpskriftToRating = mysqli_fetch_assoc($queryOpskriftToRating))
								{
									$queryContent = mysqli_query($link, "Select * FROM Opskrift Where OpskriftID='".$rowOpskriftToRating['OpskriftID']."' ORDER BY OpskriftID DESC");
									while ($rowContent = mysqli_fetch_assoc($queryContent))
										{
											echo "<li><a href=\"ShowOpskrift.php?OpskriftID=".$rowContent['OpskriftID']."\">".$rowContent['Overskrift']."</a></LI>";
										}
								}
						}
					echo "</ul>";
				}
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
