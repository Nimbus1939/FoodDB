<?php
include 'connect.php';
echo "Åbner database <br>";
$conn = OpenDB();
$Qtekst = "Select * FROM Connection";
$tekst = mysqli_query($conn, $Qtekst);
printf(" Affected rows (SELECT): %d\n", mysqli_affected_rows($conn));
while($rowTekst = mysqli_fetch_assoc($tekst)) //En while der kører alle rækker igennem,
{
    echo $rowTekst['Tekst']; 
}


CloseDB($conn);
echo "Lukker Database <br>";
?>
