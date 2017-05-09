<?php
$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
 
$pdo= new PDO($dsn, $user, $pass);

session_start();
$name = $_SESSION['bEmail']; //Email des Benutzers wird aus der Session ausgelesen
echo $name;
$result = $pdo->prepare("SELECT typ FROM Benutzer WHERE bEmail= ? "); //Typ des Benutzers wird von der DB geholt
$result->execute([$name]);
$typ = $result->fetch();
echo $typ["typ"];



if($_SESSION['bEmail'] == '')
	header('Location: login.php');
//folien fehlermeldung aktivieren


if($typ["typ"] == 1) //Typ 1 ist ein Administrator
{
    echo 1;
}

else if($typ["typ"] == 2) //Typ 2 ist ein Administrator
{
    echo 2;
}

else if($typ["typ"] == 3) //Typ 3 ist ein Administrator
{
   echo 3;
}

else
{
    echo "Benutzer ist ungültig!";
}

?>