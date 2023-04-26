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
<script type="text/javascript" src="../food/Editor/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
	theme : "advanced",
	mode : "textareas",
	
});
</script>
<title>Opret en ny Opskrift</title>
</head>
<body>
<?php
?>
<div id="title">
	<h1><a href="../food/index.php">Mettes opskrifter</a></h1>
	<h2><a href="http://www.landly.dk">by Thomas Nørgaard </a></h2>

</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
        <h2> Opret en ny Opskrift</h2>
            <p> På denne side kan du oprette en ny Opskrift.</p>
            <div id="opret">
                <form method="post" action="../food/DB/NewOpskrift_DB.php">
                    <p>
                        <label><h3>Overskrift</h3></label><br />
                        <input name="Overskrift" type="text" size="50" maxlength="50" /> <br /><br />
                        <label><h3>Underoverskrift</h3></label><br />
                        <input name="Underoverskrift" type="text" size="50" maxlength="50" /> <br /><br />
                        <label><h3>Kuverter</h3></label><br />
                        <input name="Kuverter" type="text" size="50" maxlength="50" /> <br /><br />
                        <label><h3>Indhold</h3></label><br />
                        <textarea name="Content" cols="50" rows="15"></textarea><br /><br />
                        <label><h3>Kilde</h3></label><br />
                        <input name="Kilde" type="text" size="50" maxlength="50" /> <br /><br />
                        <table border = "0px" width="100%">
                        <tr><td id="ContentTable"><h3>Kategori</h3></td><td id="ContentTable"><h3>Type</h3></td></tr>
                        <tr><td id="ContentTable">
                        <select name="Kategori">
                        <?php
							while($row = mysqli_fetch_assoc($kategori))
								{
									echo "<option value=\"".$row['KategoriID']."\">".$row['KategoriName']."</option>\n";
								}
						mysqli_data_seek($kategori, 0);//Gå tilbage til record 0 i datasæt
						?>
                        </td><td id="ContentTable">
                        </select>
                         <select name="Type">
                        <?php
							while($row = mysqli_fetch_assoc($typer))
								{
									echo "<option value=\"".$row['TypeID']."\">".$row['TypeName']."</option>\n";
								}
						mysqli_data_seek($typer, 0);//Gå tilbage til record 0 i datasæt
						?>
                        </select></td></tr>
                        <tr><td colspan="2" id="ContentTable"><h3>Tags</h3></td></tr>
                        <tr>
                        <?php
							while($row = mysqli_fetch_assoc($tags))
								{
								$i++;
								$t++;
									if ($i<=1)
										{
											echo "<td><input name=\"Tag[]\" type=\"checkbox\" value=\"".$row['TagID']."\"> ".$row['TagName']."</td>\n";
										}
									else
										{
											echo "<td><input name=\"Tag[]\" type=\"checkbox\" value=\"".$row['TagID']."\"> ".$row['TagName']."</td>\n";
											echo "</tr>\n<tr>\n"; //slut table row og start en ny
											$i=0;
										}
										

								}
								if ($t%2==1)
									{
										echo "<td>&nbsp;</td>";
									}
						mysqli_data_seek($tags, 0);//Gå tilbage til record 0 i datasæt
						?>
                        </tr>
                        </table>
                        <input type="submit" id="opret-submit" value="Opret" />
                        <input name="Reset" id="opret-reset" type="Reset" />
                    </p>
                </form>
           </div>
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
