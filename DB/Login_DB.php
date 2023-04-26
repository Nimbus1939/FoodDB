<?php
session_start();
include("connect.php"); //Inkluder filen der administrerer forbinder til databasen
include("TextConv.php"); //Inkluder filen der omkoder specialtegn
$link = OpenDB();
$Qusers = "Select * FROM Users WHERE UserAlias LIKE '".$_POST['UserAlias']."'";
$users = mysqli_query($link, $Qusers);

// find bruger og sæt rettigheder i sessionen
while($rowuser = mysqli_fetch_assoc($users)) //En while der kører alle rækker igennem,
	{
		if ($rowuser['UserAlias']==$_POST[UserAlias] && $rowuser['UserPass']==$_POST[Password])
			{
				$Qsetdate = "UPDATE Users SET LastLogin='20".(date("y-m-d"))."' WHERE UserID = '".$rowuser['UserID']."'";
				$setdate = mysqli_query($link, $Qsetdate);
				// sæt sessions variabler
				$_SESSION['UserID'] = $rowuser['UserID'];
				$_SESSION['Role'] = $rowuser['Role'];
				$_SESSION['LoggedIn'] = true;
				// send bruger til forsiden
				echo "login OK";
				echo "<meta http-equiv=\"refresh\" content=\"1;URL=../index.php\">\n";
				break;
			}
		else
			{
				// send bruger til Loginsiden
				echo "login ikke OK";
				echo "<meta http-equiv=\"refresh\" content=\"1;URL=../Login.php\">\n";
				$_SESSION[LoggedIn] = false;
			}
	}
CloseDB($link);
?>