<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../Functions.php"); // inkluder filen med globale funktioner.
include("TextConv.php"); //Inkluder filen der omkoder specialtegn
CheckUser($_SESSION['LoggedIn']);//checker om brugeren er logget på
$link = OpenDB();
$Qsider = "Select * FROM Links WHERE Placeholder='RightMenu' ORDER BY SortOrder DESC";
$Qtyper = "Select * FROM Type ORDER BY SortOrder DESC";
$Qkategori = "Select * FROM Kategori ORDER BY SortOrder DESC";
$Qtags = "Select * FROM Tags ORDER BY SortOrder DESC";
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
<script language="javascript">
function ConfirmDelete()
	{
		var r=confirm("Er du sikker på du vil slette dette tag?");
		return r;
	}
</script>
</head>
<body>
<div id="title">
	<h1><a href="../food/index.php">Mettes opskrifter</a></h1>
	<h2><a href="http://www.landly.dk">by Thomas Nørgaard </a></h2>

</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
        	<?php
				$query = mysqli_query($link, "Select * FROM Type WHERE TypeID=".($_GET['TypeID'])." ORDER BY CreateDate DESC");
				$i=0; // tællevariable
				while($row = mysqli_fetch_assoc($query)) //En while der kører alle rækker igennem,
				{
					echo "<h2>".$row['TypeName'] . "</h2>\n";
					echo "<p>Oprettet: " . $row['CreateDate']."</p>\n";
					echo $row['Content'];
					echo "<br/>\n";
					echo "<h3>Disse opskrifter er mærket med typen:</h3>\n<ul>\n";
					$query1 = mysqli_query($link, "Select * FROM OpskriftToType WHERE TypeID=".($row['TypeID'])." ORDER BY OpskriftID DESC");
					while($row1 = mysqli_fetch_assoc($query1)) //En while der kører alle rækker igennem,
						{
						$query2 = mysqli_query($link, "Select * FROM Opskrift WHERE OpskriftID=".($row1['OpskriftID'])." ORDER BY OpskriftID DESC");
						while($row2 = mysqli_fetch_assoc($query2)) //En while der kører alle rækker igennem,
							{
							echo "<li><a href=\"ShowOpskrift.php?OpskriftID=".$row2['OpskriftID']."\">".$row2['Overskrift']."</a></LI>";
							}
						}
						echo "</ul>\n";
				}
				// formular til sletning af Type
				echo "<form onSubmit=\"return(ConfirmDelete())\" action=\"DB/DeleteTag_DB.php\" method=\"post\">\n";
				echo "<input name=\"TypeID\" type=\"hidden\" value=\"".$_GET['TypeID']."\" />\n";
				echo "<input name=\"submit\" id=\"opret-submit\" type=\"submit\" value=\"Slet Type\" />\n";
				echo "</form>\n";
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
