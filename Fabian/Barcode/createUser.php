<?php
 
$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
 
$pdo= new PDO($dsn, $user, $pass);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
// Username und Passwort vom Formular
$bEmail =$_POST['bEmail']; 
$password =$_POST['password'];
$vorname =$_POST['vorname']; 
$nachname =$_POST['nachname']; 
echo "$bEmail, $password, $vorname, $nachname";
$password =md5($password); // Passwort mit MD5 verschlüsseln

$result=$pdo->prepare("INSERT INTO Benutzer(bEmail,passwort,vorname,nachname) VALUES (?, ?, ?, ?)");
$temp=$result->execute([$bEmail, $password, $vorname, $nachname]);
    
   
    
    if($temp)
    {
        echo "<h3 style='color:green;'>Registration successfull - <a href='login.php'>Zum Login</a></h3>";
    }
    else
    {
        echo "<h3 style='color:red;'>Registration not successfull - <a href='login.php'>Zum Login</a></h3>";
    } 
}

?>

<head>
</head>
<link rel="stylesheet" href="style.css">
<body>
    <center>
        <div id="alles">
            <form action="createUser.php" method="post">
                <h3>Create User</h3>
                <label>E-Mail:</label>
                <input type="email" name="bEmail"/><br />

                <label>Password :</label>
                <input type="password" name="password"/><br/>

                <label>Vorname :</label>
                <input type="text" name="vorname"/><br />
                
                <label>Nachname :</label>
                <input type="text" name="nachname"/><br />


                <input type="submit" value=" Benutzer erstellen "/><br />
            </form>
        </div>
    </center>
</body>

