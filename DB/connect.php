<?php
function OpenDB() //Opretter forbindelsen til MySQL databasen
 {
 $conn = mysqli_connect("localhost", "food", "Spark1Hund", CheckState());
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
function CheckState() //undersøger hvilken tilstand systemer er i DEV/PROD
 {
   $link = mysqli_connect("localhost", "food", "Spark1Hund", "food"); //forbind til PROD databasen, for at hente tilstand.
   if (mysqli_connect_errno())
				{
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
    }
    else
    {
      $Qstate = "Select * FROM Tilstand";
      $state = mysqli_query($link, $Qstate);
      while($rowstate = mysqli_fetch_assoc($state)) //En while der kører alle rækker igennem,
       {					
         if ($rowstate['ActiveState'] == 1)//Når der findes en post i ActiveState tabellen der er = 1, returneres det tilhørende databasenavn.
         {
          $tilstand = $rowstate['DBName'];
          if ($tilstand == "foodDev") // Hvis database er i UDV tilstand farves baggrund lyseblå, og der sættes en tekst med DBnavn og en overskrift på alle sider
          {
           echo "<html><h2>";
           echo "<br/><center>--- !!! UDVIKLINGSTILSTAND !!! ---<center/> <br>";
           echo "<body style=background-color:powderblue;>";
           echo "</h2></html>";
          }
         }
       }
      return $tilstand;
    }
 }
 
?>