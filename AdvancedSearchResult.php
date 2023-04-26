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
<title>Søgeresultat</title>
</head>
<body>
<?php
//funktion til at rense tag array for de værdier der ikke optræder i alle itterationer
function Rens($temp)
	{
		global $i;
		if ($temp === $i)
			{
				return TRUE;
			}
		else
			{
				return FALSE;
			}
	}
//Opbygning af søge arrays start
$tagRaw = array(); // de rå værdier for søgning after opskrifter med tags
$tagCount = array(); // optællings array for tags
$tagFilter = array(); // det filtrerede søgeresultat efter tags
$globalResult = array();//Det samlede søgeresultat
//Opbygning af søge arrays slut

//opbygning af Søge sætninger start
//søgning i overskrift
if (!($_POST['Overskrift']== NULL))
	{
		//echo "<br>der er søgt på Overskrift ".$_POST['Overskrift'];
		$QresultOverskrift = "Select OpskriftID FROM Opskrift Where Overskrift LIKE '%".$_POST['Overskrift']."%' ORDER BY OpskriftID DESC";
		$resultOverskrift = mysqli_query($link, $QresultOverskrift);
		while ($rowOverskrift = mysqli_fetch_assoc($resultOverskrift))
			{
				array_push($globalResult,$rowOverskrift['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
			}
	}
//søgning i Underoverskrift
if (!($_POST['Underoverskrift']== NULL))
	{
		//echo "<br>der er søgt på Underoverskrift ".$_POST['Underoverskrift'];
		$QresultUnderoverskrift = "Select OpskriftID FROM Opskrift Where Underoverskrift LIKE '%".$_POST['Underoverskrift']."%' ORDER BY OpskriftID DESC";
		$resultUnderoverskrift = mysqli_query($link, $QresultUnderoverskrift);
		while ($rowUnderoverskrift = mysqli_fetch_assoc($resultUnderoverskrift))
			{
				array_push($globalResult,$rowUnderoverskrift['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
			}
	}
//søgning i Kuverter
if (!($_POST['Kuverter']== NULL))
	{
		//echo "<br>der er søgt på Kuverter ".$_POST['Kuverter'];
		$QresultKuverter = "Select OpskriftID FROM Opskrift Where Kuverter LIKE '%".$_POST['Kuverter']."%' ORDER BY OpskriftID DESC";
		$resultKuverter = mysqli_query($link, $QresultKuverter);
		while ($rowKuverter = mysqli_fetch_assoc($resultKuverter))
			{
				array_push($globalResult,$rowKuverter['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
			}
	}
//søgning i Kilde
if (!($_POST['Kilde']== NULL))
	{
		//echo "<br>der er søgt på Kilde ".$_POST['Kilde'];
		$QresultKilde = "Select OpskriftID FROM Opskrift Where Kilde LIKE '%".$_POST['Kilde']."%' ORDER BY OpskriftID DESC";
		$resultKilde = mysqli_query($link, $QresultKilde);
		while ($rowKilde = mysqli_fetch_assoc($resultKilde))
			{
				array_push($globalResult,$rowKilde['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
			}
	}
//søgning i Kategori
if (!($_POST['Kategori']== NULL))
	{
		//echo "<br>der er søgt på Kategori ".$_POST['Kategori'];
		$QresultKategori = "Select OpskriftID FROM OpskriftToKategori Where KategoriID= '".$_POST['Kategori']."' ORDER BY OpskriftID DESC";
		$resultKategori = mysql_query($link, $QresultKategori);
		while ($rowKategori = mysqli_fetch_assoc($resultKategori))
			{
				array_push($globalResult,$rowKategori['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
			}
	}
//søgning i Type
if (!($_POST['Type']== NULL))
	{
		//echo "<br>der er søgt på Type ".$_POST['Type'];
		$QresultType = "Select OpskriftID FROM OpskriftToType Where TypeID = '".$_POST['Type']."'";
		$resultType = mysqli_query($link, $QresultType);
		while ($rowType = mysqli_fetch_assoc($resultType))
			{
				array_push($globalResult,$rowType['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
			}
	}
//søgning i stjerner
if (!($_POST['NewRating']== NULL))
	{
		//echo "<br>der er søgt på Rating ".$_POST['NewRating'];
		$QresultStjerner = "Select RatingID FROM Rating Where Stars ='".$_POST['NewRating']."'";
		$resultStjerner = mysqli_query($link, $QresultStjerner);
		while ($rowStjerner = mysqli_fetch_assoc($resultStjerner))
			{
				$QresultStars = "Select OpskriftID FROM OpskriftToRating Where RatingID= '".$rowStjerner['RatingID']."' ORDER BY OpskriftID DESC";
				$resultStars = mysqli_query($link, $QresultStars);
				while ($rowStars = mysqli_fetch_assoc($resultStars))
					{
						array_push($globalResult,$rowStars['OpskriftID']); // lægger de rå resultater ind i det globale resultat array
					}
			}
	}
// søgning i tags
if (count($_POST['Tag'])>0)
	{
	//echo "<br>der er søgt på Tags";
	//print_r($_POST['Tag']);
	$i=0; // tællevariable til antal gennemløb af foreach løkken
	foreach ($_POST['Tag'] as $value)
		{
			$QresultTags = "Select OpskriftID FROM OpskriftToTag Where TagID ='".$value."'";
			$resultTags = mysqli_query($link, $QresultTags);
			while ($row = mysqli_fetch_assoc($resultTags))
				{
					array_push($tagRaw,$row['OpskriftID']); // lægger de rå resultater ind i et array
				}
			$i++;
		}
	$tagCount=(array_count_values($tagRaw));
	$tagFilter=(array_filter($tagCount,Rens) );
	foreach(array_keys($tagFilter) as $value)
		{
			array_push($globalResult,$value); // lægger de rå resultater ind i det globale resultat array
		}
	}
	//echo "<br>Søgeresultat: ";
	//print_r(array_flip($globalResult));
//opbygning af Søge sætninger slut
echo "<div id=\"title\">\n";
	echo "<h1><a href=\"../food/index.php\">Mettes opskrifter</a></h1>\n";
	echo "<h2><a href=\"http://www.landly.dk\">by Thomas Nørgaard </a></h2>\n";
echo "</div>\n";
echo "<div id=\"header\">\n";
echo "</div>\n";
echo "<div id=\"content\">\n";
    echo "<div id=\"colOne\">\n";
        echo "<h2> Søgeresultat</h2>\n";
        echo "<ul>\n";
			if (count($globalResult)== 0)
				{
					if (count($tagCount)>0)
						{
							echo "<p>Der blev ikke fundet nogen resultater der matchede din søgning, men disse matchede 1 eller flere at de tags du søgte på</p";
							foreach(array_keys($tagCount) as $value)
								{
									$QlistOverskrift = "Select * FROM Opskrift Where OpskriftID='".$value."' ORDER BY OpskriftID DESC";
									$listOverskrift = mysqli_query($link, $QlistOverskrift);
									while ($rowOverskriftList = mysqli_fetch_assoc($listOverskrift))
										{
											echo "<li><a href=\"ShowOpskrift.php?OpskriftID=".$rowOverskriftList['OpskriftID']."\">".$rowOverskriftList['Overskrift']."</a></LI>";
										}
								}
							
						}
					else
						{
							echo "<p>Der blev ikke fundet nogen resultater der matchede din søgning</p>";
						}
				}
			else
				{
					foreach(array_keys(array_flip($globalResult)) as $value)
						{
							$QlistOverskrift = "Select * FROM Opskrift Where OpskriftID='".$value."' ORDER BY OpskriftID DESC";
							$listOverskrift = mysqli_query($link, $QlistOverskrift);
							while ($rowOverskriftList = mysqli_fetch_assoc($listOverskrift))
								{
									echo "<li><a href=\"ShowOpskrift.php?OpskriftID=".$rowOverskriftList['OpskriftID']."\">".$rowOverskriftList['Overskrift']."</a></LI>";
								}
						}
				}
			?>
            </ul>
            <p><a href="AdvancedSearch.php">Søg igen</a></p><br />
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
