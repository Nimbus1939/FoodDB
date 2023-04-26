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
<title>Rediger en Opskrift</title>
</head>
<body>
<?php
$tag = mysqli_query($link, "Select * FROM Tags ORDER BY CreateDate DESC");
$type = mysqli_query($link, "Select * FROM Type ORDER BY CreateDate DESC");
$kategori = mysqli_query($link, "Select * FROM Kategori ORDER BY CreateDate DESC");
$opskrift = mysqli_query($link, "Select * FROM Opskrift WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY CreateDate DESC ");
$opskriftToType = mysqli_query($link, "Select * FROM OpskriftToType WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC ");
$opskriftToKategori = mysqli_query($link, "Select * FROM OpskriftToKategori WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC ");
$opskriftToTag = mysqli_query($link, "Select * FROM OpskriftToTag WHERE OpskriftID=".($_GET['OpskriftID'])." ORDER BY OpskriftID DESC ");
$selectTagArray=array();
while ($rowSelectTag = mysqli_fetch_assoc($opskriftToTag)) // lægger alle tag-værdierne fra OpskriftToTag ind i et array
	{
			array_push($selectTagArray,$rowSelectTag['TagID']);
	}
?>
<div id="title">
	<h1><a href="../food/index.php">Mettes opskrifter</a></h1>
	<h2><a href="http://www.landly.dk">by Thomas Nylander Nørgaard </a></h2>

</div>
<div id="header">
</div>
<div id="content">
    <div id="colOne">
        <h2> Rediger en Opskrift</h2>
            <p> På denne side kan du redigere en Opskrift.</p>
            <div id="opret">
				<?php
					while($rowOpskrift = mysqli_fetch_assoc($opskrift))
						{
							echo " <form method=\"post\" action=\"../food/DB/UpdateOpskrift_DB.php\">\n";
							echo "<p>\n";
							echo "<input name=\"OpskriftID\" type=\"hidden\" value=\"".$_GET['OpskriftID']."\" />\n";
							echo "<label><h3>Overskrift</h3></label><br />\n";
							echo "<input name=\"Overskrift\" type=\"text\" size=\"50\" maxlength=\"50\" value=\"".$rowOpskrift['Overskrift']."\" /> <br /><br />\n";
							echo "<label><h3>Underoverskrift</h3></label><br />\n";
							echo "<input name=\"Underoverskrift\" type=\"text\" size=\"50\" maxlength=\"50\" value=\"".$rowOpskrift['Underoverskrift']."\" /> <br /><br />\n";
							echo "<label><h3>Kuverter</h3></label><br />\n";
							echo "<input name=\"Kuverter\" type=\"text\" size=\"50\" maxlength=\"50\" value=\"".$rowOpskrift['Kuverter']."\" /> <br /><br />\n";
							echo "<label><h3>Indhold</h3></label><br />\n";
							echo "<textarea name=\"Content\" cols=\"50\" rows=\"15\"> ".$rowOpskrift['Content']."</textarea><br /><br />\n";
							echo "<label><h3>Kilde</h3></label><br />\n";
							echo "<input name=\"Kilde\" type=\"text\" size=\"50\" maxlength=\"50\" value=\"".$rowOpskrift['Kilde']."\" /> <br /><br />\n";
							echo "<table border = \"0px\" width=\"100%\">\n";
							echo "<tr><td id=\"ContentTable\"><h3>Kategori</h3></td><td id=\"ContentTable\"><h3>Type</h3></td></tr>\n";
							echo "<tr><td id=\"ContentTable\">\n";
							echo "<select name=\"KategoriID\">\n";
						}
						while($rowSelectKategori = mysqli_fetch_assoc($opskriftToKategori))
							{
								while($row = mysqli_fetch_assoc($kategori))
									{
											if (($rowSelectKategori['KategoriID']) == ($row['KategoriID']))
												{
													echo "<option SELECTED value=\"".$row['KategoriID']."\">".$row['KategoriName']."</option>\n";
												}
											else
												{
													echo "<option value=\"".$row['KategoriID']."\">".$row['KategoriName']."</option>\n";
												}
									}
							}
                        echo "</td><td id=\"ContentTable\">\n";
                        echo "</select>\n";
                        echo "<select name=\"TypeID\">\n";
							while($rowSelectType = mysqli_fetch_assoc($opskriftToType))
								{
									while($row = mysqli_fetch_assoc($type))
										{
											if (($rowSelectType['TypeID']) == ($row['TypeID']))
												{
													echo "<option SELECTED value=\"".$row['TypeID']."\">".$row['TypeName']."</option>\n";
												}
											else
												{
													echo "<option value=\"".$row['TypeID']."\">".$row['TypeName']."</option>\n";
												}
										}
								}
                        echo "</select></td></tr>\n";
                        echo "<tr><td colspan=\"2\" id=\"ContentTable\"><h3>Tags</h3></td></tr>\n";
                        echo "<tr>\n";
						while($row = mysqli_fetch_assoc($tag))
							{
								$i++;
								$t++;
								if (in_array($row['TagID'],$selectTagArray))
									{
										if ($i<=1)
											{
												echo "<td><input CHECKED name=\"Tag[]\" type=\"checkbox\" value=\"".$row['TagID']."\"> ".$row['TagName']."</td>\n";
											}
										else
											{
												echo "<td><input CHECKED name=\"Tag[]\" type=\"checkbox\" value=\"".$row['TagID']."\"> ".$row['TagName']."</td>\n";
												echo "</tr>\n<tr>\n"; //slut table row og start en ny
												$i=0;
											}
									}
								else
										{
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
							}
									if ($t%2==1)
										{
											echo "<td>&nbsp;</td>";
										}
                        echo "</tr>\n";
                        echo "</table>\n";
                        echo "<input type=\"submit\" id=\"opret-submit\" value=\"Opdater\" />\n";
						echo "</p>\n";
						echo "</form>\n";
				?>
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
