<?php
$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
 
$pdo= new PDO($dsn, $user, $pass);

session_start();
$name= $_SESSION['bEmail'];
$result= $pdo->prepare("SELECT typ FROM Benutzer WHERE bEmail= ? ");
$result->execute([$name]);
$typ = $result->fetch();

if($_SESSION['bEmail'] == '')
	header('Location: login.php');


if(isset($_POST["gast_loeschen"])){
	
	$gast_barcode = $_POST["gast_barcode"];
	
	
    $result= $pdo->prepare("DELETE FROM Gast WHERE barcode = ?");
    $temp = $result->execute([$gast_barcode]);
	if($temp){
		$status = "<h3 style='color:green;'>Konto wurde erfolgreich geloescht.</h3>";
	}else{
		print_r($db->error);
		$status = "<h3 style='color:red;'>Error - Konto konnte nicht geloescht werden</h3>";
	}
}
 
 
 
 
if(isset($_POST["gast_erstellen"])){
	$gast_barcode = $_POST["gast_barcode"];
    $gast_vorname= $_POST["gast_vorname"];
    $gast_nachname= $_POST["gast_nachname"];
    $gast_geburtsDatum= $_POST["gast_geburtsDatum"];
    $gast_eStartZeit= $_POST["gast_eStartZeit"];
    $gast_bEmail= $name;
    $gast_tischNr = $_POST["gast_tischNr"];
	$result= $pdo->prepare("INSERT INTO Gast(barcode, vorname, nachname, geburtsDatum, gIN, tischNr, bEmail) VALUES(?, ?, ?, ?, ?, ?, ?)";
	 $temp = $result->execute([$gast_barcode, $vorname, $nachname, $geburtsdatum, $gIN, $tischNr, $bEmail]);
	if($temp){
		$status = "<h3 style='color:green;'>Gast wurde erfolgreich hinzugefügt.</h3>";
	}else{
		print_r($db->error);
		$status = "<h3 style='color:red;'>Error - Konto konnte nicht erstellt werden</h3>";
	}
}

if(isset($_POST["gast_bearbeiten"])){
    $gast_barcode = $_POST["gast_barcode"];
    $gast_vorname= $_POST["gast_vorname"];
    $gast_nachname= $_POST["gast_nachname"];
    $gast_geburtsDatum= $_POST["gast_geburtsDatum"];
    $gast_eDatum= $_POST["gast_eDatum"];
    $gast_bEmail= $name;
    $gast_tischNr = $_POST["gast_tischNr"];
    $result= $pdo->prepare("UPDATE TABLE Gast(barcode, vorname, nachname, geburtsDatum, gIN, tischNr, bEmail) VALUES(?, ?, ?, ?, ?, ?, ?)";
}




  if (isset($_GET['l'])) {
    session_destroy();
	header('Location: login.php');
	
  }


}
?>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<center>
<div id="alles">
<form action="myAccount.php" method="post">
<h3>Willkommen <?php echo $name ?> (<a href='myAccount.php?l=true'>Logout</a>)</h3>
<hr>
<h3>OPERATIONEN</h3>

<h4>Neues Konto</h4>
<form action="" method="post">
    <input type="submit" name="kontoerstellen" value="Neues Konto erstellen" /> 
</form>
<br>
<h4>Konto löschen</h4>
<form action="" method="post">
	Welches? (iban) <input type="text" name="ibanloeschen"></input><br>
    <input type="submit" name="kontoloeschen" value="Konto löschen" /> 
</form>
<!--a href='myAccount.php?n=true'>Neues Konto erstellen</a-->
<br>
<h4>Zahlung tätigen</h4>
<form action="" method="post">
	An: (IBAN) <input type="text" name="iban" /><br>
	Wieviel: <input type="text" name="amount" /><br>
	Von Konto (IBAN): <input type="text" name="iban2"/><br>
    <input type="submit" name="submit" value="Zahlung senden" /> 
</form><br>
<h4>Abheben/Aufladen</h4>
<form action="" method="post">
	Abheben: <input type="text" name="minus"/><br>
	Von: (IBAN) <input type="text" name="iban3"/><br>
    <input type="submit" name="submit" value="Zahlung senden" /> 
</form><br>

<form action="" method="post">
	Aufladen:(positiver Betrag) <input type="text" name="plus"/><br>
	Von: (IBAN) <input type="text" name="iban3"/><br>
    <input type="submit" name="submit" value="Zahlung senden" /> 
</form><br><br>

<h3>Deine Konten:</h3>
</div>
</center>
</body>

<?php
	echo "<center>";
	global $db;
	global $name;
	$erg= $db->query("select * from konto where username = '$name'");
	
	$erg1= $db->query("select * from admin where username = '$name'");
	
	while($zeile1= $erg1->fetch_object()){
	echo "<pre>";
	echo "<b>MEIN Kreditrahmen: "; print_r($zeile1->kreditrahmen); echo "<br></b>";
	echo "</pre>";
	}


	while($zeile= $erg->fetch_object()){
	echo "<pre>";
	echo "USER: <i>"; print_r($zeile->username); echo "</i><br>";
	echo "KONTOSTAND: <i>"; print_r($zeile->kontostand); echo "</i><br>";
	echo "IBAN: <i>"; print_r($zeile->iban);echo "</i>";
	echo "</pre>";
	
	}
	echo "</center>";

	
?>

</form>

