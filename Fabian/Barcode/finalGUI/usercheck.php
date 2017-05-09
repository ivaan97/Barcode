<?php
$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
 
$pdo= new PDO($dsn, $user, $pass);

session_start();
$name = $_SESSION['bEmail'];
echo $name;
$result = $pdo->prepare("SELECT typ FROM Benutzer WHERE bEmail= ? ");
$result->execute([$name]);
$typ = $result->fetch();
echo $typ["typ"];



if($_SESSION['bEmail'] == '')
	header('Location: login.php');
//folien fehlermeldung aktivieren


if($typ["typ"] == 1)
{
    echo 1;
}

else if($typ["typ"] == 2)
{
    echo 2;
}

else if($typ["typ"] == 3)
{
   echo 3;
}

else
{
    echo "Benutzer ist ungültig!";
}

?>