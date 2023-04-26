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
				$queryType = mysqli_query($link, "Select * FROM Type WHERE TypeID=".($_POST['TypeID'])." ORDER BY CreateDate DESC");
				while($row = mysqli_fetch_assoc($queryType)) //En while der kører alle rækker igennem,
				{
				echo"<h2>Slet typen: <a href=\"ShowType.php?TypeID=".$_POST['TypeID']."\">".$row['TypeName']."</a> </h2><br />";
				$queryOpskrift = mysqli_query($link, "Select * FROM OpskriftToType WHERE TypeID=".($row['TypeID'])." ORDER BY OpskriftID DESC");
				if (($numOpskrift = mysqli_num_rows($queryOpskrift))>0)
					{
						$queryTypeList = mysqli_query($link, "Select * FROM Type ORDER BY TypeID DESC");
						echo "Typen <a href=\"ShowType.php?TypeID=".$_POST['TypeID']."\">".$row['TypeName']."</a> kan ikke slettes, der er opskrifter der er mærket med denne type<br />";
						echo "<p>Vælg en erstatning for denne type på listen herunder hvis du ønsker at slette denne type og udskifte opmærkningen på eksisterende opskrifter til en anden type</p>";
						echo "<form action=\"DB/UpdateDeleteType_DB.php\" method=\"post\">";
						echo "<select name=\"NewTypeID\">";
						while($rowTypeList = mysqli_fetch_assoc($queryTypeList))
							{
								if ($rowTypeList['TypeID'] == $_POST['TypeID'])
									{
									continue;
									}
								else
									{
										echo "<option value=\"".$rowTypeList['TypeID']."\">".$rowTypeList['TypeName']."</option>\n";
									}
							}
						echo "</select>";
						echo "<input name=\"TypeID\" type=\"hidden\" value=\"".$_POST['TypeID']."\" />";
						echo "<br><br>\n<input id=\"opret-submit\" type=\"submit\" value=\"Opdater og slet type\" />";
						echo "</form>";
						echo "<p>Ønsker du ikke at slette typen kan du gå tilbage til typens side ved at klikke <a href=\"ShowType.php?TypeID=".$_POST['TypeID']."\">her</a> eller trykke på tilbageknappen i din browser.</p>";
					}
				else
					{
						mysqli_query($link, "DELETE FROM Type WHERE TypeID='".($_POST['TypeID'])."'");
						echo "Typen <u>".$row['TypeName']."</u> er slettet";
					}
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
