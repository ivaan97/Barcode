<!DOCTYPE html>
    <?php
    session_start();

    $dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
    $user="stferfab";
    $pass="mypass";
    $pdo= new PDO($dsn, $user, $pass);


    if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $temp=false;
            $bEmail = $_POST['bEmail']; 
            $password= $_POST['password']; 
            $password=md5($password); 
           
            $result= $pdo->prepare("SELECT passwort FROM Benutzer WHERE bEmail= ? ");
            $temp = $result->execute([$bEmail]);
            $password_GET = $result->fetch();
            $password_GET = $password_GET ["passwort"];

            if($temp && $password == $password_GET)
            {
                $_SESSION['bEmail'] = $bEmail;
                header("location: usercheck.php");
            }
            else 
            {
                echo "<h3 style='color:red;'>Ihre Email oder ihr Passwort ist ungültig</h3>";
            }
        }
    ?>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Login</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <nav class="light-blue">
    <div class="nav-wrapper container">
	<a id="logo-container" class="brand-logo center">easyScan</a>
    </div>
  </nav>
  
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
	<br>
		<h5 class="header center orange-text">Bitte melden sie sich an</h5>
	<br>
    </div>
  </div>
      
  <div class="row">
	<body>
	  <main>
		<center>
		   <div class="container">
			<div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
                <form class="col s12" action="login.php" method="post">
				<div class='row'>
				  <div class='input-field col s12'>
					<input class='validate' type='email' name='bEmail' id='bEmail' />
					<label for='email'>Email eingeben</label>
				  </div>
				</div>

				<div class='row'>
				  <div class='input-field col s12'>
					<input class='validate' type='password' name='password' id='password' />
					<label for='password'>Passwort eingeben</label>
				  </div>
				</div>

				<center>
					<div class='row'>
						<button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>Login</button>
					</div>
				</center>
                </form>
			</div>
		</div>
      </center>
	</main>
	</body>		
  </div>   
	  
  <footer class="page-footer orange">
    
  </footer>

  

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="js/script.js"></script>

  </body>
</html>
