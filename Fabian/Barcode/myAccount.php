<?php
$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
 
$pdo= new PDO($dsn, $user, $pass);

session_start();
$name= $_SESSION['bEmail'];
$result= $pdo->prepare("SELECT typ FROM Maturant WHERE bEmail= ? ");
$result->execute($name);
$typ = $result->fetch();

if($_SESSION['bEmail'] == '')
	header('Location: login.php');

if($typ == 1)
{
    header('Location: administrator.php')
}

if($typ == 2)
{
    header('Location: angestellter.php')
}

if($typ == 1)
{
    header('Location: anwender.php')
}



 if(isset($_POST["kontoloeschen"])){
	global $name;
	global $db;
	$iban = $_POST["ibanloeschen"];
	
	$sql="DELETE FROM konto WHERE iban = '$iban'";
	if(mysqli_query($db,$sql)){
		$status = "<h3 style='color:green;'>Konto wurde erfolgreich erstellt.</h3>";
	}else{
		print_r($db->error);
		$status = "<h3 style='color:red;'>Error - Konto konnte nicht erstellt werden</h3>";
	}
}
 
 
 
 
if(isset($_POST["kontoerstellen"])){
	global $name;
	global $db;
	$length = 34;
	$iban = 'IT '. substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	
	$sql="insert into konto(username, kontostand, iban) VALUES('$name', 0, '$iban')";
	if(mysqli_query($db,$sql)){
		$status = "<h3 style='color:green;'>Konto wurde erfolgreich erstellt.</h3>";
	}else{
		print_r($db->error);
		$status = "<h3 style='color:red;'>Error - Konto konnte nicht erstellt werden</h3>";
	}
}



if (isset($_POST["iban"]) && isset($_POST["amount"]) && isset($_POST["iban2"])) {

	$iban = $_POST["iban"];
	$amount = $_POST["amount"];
	$iban2 = $_POST["iban2"];
	
	try {
		mysqli_query($db,"START TRANSACTION");

		mysqli_query($db,"UPDATE konto SET kontostand = kontostand + $amount WHERE iban='$iban'");
		mysqli_query($db,"UPDATE konto SET kontostand = kontostand - $amount WHERE iban='$iban2'");

		$db->commit();
	} catch (Exception $e) {
		$db->rollback();
	}
}


  if (isset($_GET['l'])) {
    session_destroy();
	header('Location: login.php');
	
  }


if(isset($_POST["plus"])){
		$plus = $_POST["plus"];
		$iban = $_POST["iban3"];
		mysqli_query($db,"UPDATE konto SET kontostand = kontostand + $plus WHERE iban='$iban'");
	}
	
if(isset($_POST["minus"])){
		$minus = $_POST["minus"];
		$iban = $_POST["iban3"];
		
		$erg= $db->query("select * from konto k join admin a on k.username = a.username");

		
		while($zeile= $erg->fetch_object()){
		if($iban == $zeile->iban){
			$betragNachher=$zeile->kontostand - $minus;
					if($betragNachher < $zeile->kreditrahmen){
						echo "<h3 style='color:red;'>ERROR - Kreditrahmen überschritten</h3>";
					}else{
						mysqli_query($db,"UPDATE konto SET kontostand = kontostand - $minus WHERE iban='$iban'");
						
					}			
		}
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
	An: (IBAN) <input type="text" name="iban"></input><br>
	Wieviel: <input type="text" name="amount"></input><br>
	Von Konto (IBAN): <input type="text" name="iban2"></input><br>
    <input type="submit" name="submit" value="Zahlung senden" /> 
</form><br>
<h4>Abheben/Aufladen</h4>
<form action="" method="post">
	Abheben: <input type="text" name="minus"></input><br>
	Von: (IBAN) <input type="text" name="iban3"></input><br>
    <input type="submit" name="submit" value="Zahlung senden" /> 
</form><br>

<form action="" method="post">
	Aufladen:(positiver Betrag) <input type="text" name="plus"></input><br>
	Von: (IBAN) <input type="text" name="iban3"></input><br>
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

