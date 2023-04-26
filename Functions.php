<?php
session_start();
//include("connect.php"); //Inkluder filen der administrerer forbinder til databasen

function CheckUser($LoggedIn) 
{
	if (!($LoggedIn == true))
		{
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=../food/Login.php\">\n";
		}
}
?>