<?php
session_start();
include("../food/DB/connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("../food/Functions.php"); // inkluder filen med globale funktioner.
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
<title>Vis brugeroplysninger</title>
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
			$Qqueryuser = "Select * FROM Users WHERE UserID=".($_GET['UserID'])." ORDER BY CreateDate DESC";
			$query = mysqli_query($link, $Qqueryuser);
			echo"<h2>Vis brugeroplysninger</h2>";
			echo"<table width=\"100%\" border=\"0\">";
            while($row = mysqli_fetch_assoc($query)) //En while der kører alle rækker igennem
            {
            echo "<tr><td>Navn </td><td>".$row['UserName']."</td></tr>\n";
            echo "<tr><td>Alias </td><td>".$row['UserAlias']."</td></tr>\n";
			echo "<tr><td>Køn </td><td>".$row['Sex']."</td></tr>\n";
            echo "<tr><td>Mail </td><td><a href=\"mailto:".$row['UserMail']."\">".$row['UserMail']."</a></td></tr>\n";
			$QqueryRole = "Select * FROM Roles WHERE RolleID=".($row['Role'])." ORDER BY RolleID DESC";
			$queryRole = mysqli_query($link, $QqueryRole);
			while($rowRole = mysqli_fetch_assoc($queryRole)) //En while der kører alle rækker igennem
            	{
					echo "<tr><td>Rolle </td><td>".$rowRole['RolleName']."</td></tr>\n";
				}
            echo "<tr><td>Oprettet </td><td>".$row['CreateDate']."</td></tr>\n";
            echo "<tr><td>Redigeret </td><td>".$row['EditDate']."</td></tr>\n";
            echo "<tr><td>Sidste login </td><td>".$row['LastLogin']."</td></tr>\n";
            echo "<tr><td>Bemærkninger </td><td>&nbsp;</td></tr>\n";
			echo "<tr><td colspan=\"2\">".$row['Remarks']."</td></tr>\n";
            }
			echo "</table>";
			echo "<a href=\"EditUser.php?UserID=".($_GET['UserID'])."\">Rediger denne bruger</a> <br>\n";
        ?>
        <a href="../food/ShowUsers.php">Vis alle brugere</a>
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
