<?php
session_start();

$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
$pdo= new PDO($dsn, $user, $pass);


if($_SERVER["REQUEST_METHOD"] == "POST")
{
$bEmail = $_POST['bEmail']; 
$password= $_POST['password']; 
$password=md5($password); 
$result= $pdo->prepare("SELECT bEmail FROM Benutzer WHERE bEmail= ? and passwort= ? ");
$temp = $result->execute([$email, $password]);


if($temp)
{
$_SESSION['bEmail'] = $bEmail;
header("location: usercheck.php");
}
else 
{
echo "<h3 style='color:red;'>Your Login Name or Password is invalid</h3>";
}
}
?>
<html>
    <head>
        
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        
        <center>
            <div id="alles">
                <form action="login.php" method="post">
                    <h3>Anmelden</h3>
                    <label>E-Mail :</label>
                    <input type="email" name="bEmail"/><br />
                    <label>Password :</label>
                    <input type="password" name="password"/><br/>
                    <input type="submit" value=" Anmelden "/>
                    <input type="submit" value=" Registrieren " onclick="button(2)"/><br />
                </form>
            </div>
        </center>
    </body>
</html>