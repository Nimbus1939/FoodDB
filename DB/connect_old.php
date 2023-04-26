<?php
function OpenDB() //Opretter forbindelsen til MySQL databasen
 {
 $conn = mysqli_connect("localhost", "food", "Spark1Hund", "foodDev");
 /* check connection */
				if (mysqli_connect_errno())
				{
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
    else
    {
     return $conn;
    }
 }
 
function CloseDB($conn) //Lukker forbindelsen til MySQL databasen
 {
mysqli_close($conn);
 }

?>