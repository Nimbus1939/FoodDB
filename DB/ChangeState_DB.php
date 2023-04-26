<?php
session_start();
$link = mysqli_connect("localhost", "food", "Spark1Hund", "food"); //forbind til PROD databasen, for at hente tilstand.
   if (mysqli_connect_errno())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Skift tilstand</title>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="refresh" content="1;URL=../index.php">
</head>
<?php
if (($_POST['Nr']) == 1) //Hvis PROD skal være aktiv database
    {
        $q1 = "UPDATE Tilstand SET ActiveState = '1' WHERE Nr = '1'";//Sæt PROD ActiveState til 1
        mysqli_query($link, $q1);
        $q2 = "UPDATE Tilstand SET ActiveState = '0' WHERE Nr = '2'"; //Sæt DEV ActiveState til 0
        mysqli_query($link, $q2);
    }
else
    {
        $q1 = "UPDATE Tilstand SET ActiveState = '0' WHERE Nr = '1'";//Sæt PROD ActiveState til 0
        mysqli_query($link, $q1);
        $q2 = "UPDATE Tilstand SET ActiveState = '1' WHERE Nr = '2'"; //Sæt DEV ActiveState til 1
        mysqli_query($link, $q2);
    }

?> 
<body>
</body>
<?php
CloseDB();
?>
</html>