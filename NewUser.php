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
<title>Opret Ny bruger</title>
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
        <h2>Opret en ny bruger</h2>
        <p>På denne side kan du oprette nye brugere.</p>
            <form action="../food/DB/NewUser_DB.php" method="post" enctype="application/x-www-form-urlencoded" name="NewUser">
            <label>Navn</label><br />
            <input name="UserName" type="text" size="50" maxlength="50" /><br /><br />
            <label>Alias</label><br />
            <input name="UserAlias" type="text" size="50" maxlength="50" /><br /><br />
            <label>Mail</label><br />
            <input name="Mail" type="text" size="50" maxlength="50" /><br /><br />
            <label>Password</label><br />
            <input name="Pass" type="password" size="50" maxlength="50" /><br /><br />
            <label>Køn:</label><br />
              <label>
                <input type="radio" name="Sex" value="Mand" id="Sex_0" />
                Mand</label>
              <br />
              <label>
                <input type="radio" name="Sex" value="Kvinde" id="Sex_1" />
                Kvinde</label>
              <br /><br />
              <label>Rolle:</label><br />
                <label>
                  <input type="radio" name="Rolle" value="1" id="Rolle1" />
                  Administrator</label>
                <br />
                <label>
                <input type="radio" name="Rolle" value="5" id="RadioGroup1_1" />
                 Bruger</label> 
                <br />
                <label>
                  <input type="radio" name="Rolle" value="10" id="RadioGroup1_2" />
                  Gæst</label><br /><br />
                    <label>Bemærkninger</label>
                    <textarea name="Remarks" cols="50" rows="15"></textarea><br />
                  <input type="submit" id="opret-submit" value="Opret" />
                  <input name="Reset" id="opret-reset" type="Reset" />
            </form>   
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
