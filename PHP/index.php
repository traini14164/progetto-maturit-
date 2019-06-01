<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gestione Utenti</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<!--<script>
$(document).ready(function()
{
    $("#signin").click(function ()
                       {
      var funz = 'signin';
      var cognome_ajax = $('#cognome').val();
      var matricola_ajax = $('#matricola').val();
      var password_ajax = $('#password').val();
      $.ajax
      ({
        type:'POST',
        url:'funzioniAjax.php',
        data: {f: funz,cognome: cognome_ajax,matricola: matricola_ajax,password: password_ajax},
        success:function(html)
        {
          	$('#credenzialiErrate').html(html);
        }
      });
    });
 });
</script>-->
<?php
	session_start();
	session_destroy();
    include 'connectToServer.php';
?>
<body>
    <div class="login-form">
        <h2 class="text-center">User Login</h2>
        <form method="POST">
            <div class="avatar">
                <img src="./immagini/avatar.png" alt="Avatar">
            </div>
            <div class="form-group">
                <input type="text" class="form-control input-lg" id="cognome" style="border-radius: 50px;" name="cognome" placeholder="Cognome" required="required">	
            </div>
            <div class="form-group">
                <input type="text" class="form-control input-lg" id="matricola" style="border-radius: 50px;" name="matricola" placeholder="Matricola" required="required">	
            </div>
            <div class="form-group">
                <input type="password" class="form-control input-lg" id="password" style="border-radius: 50px;" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group clearfix">
                <button type="submit" class="btn btn-primary btn-lg" id="signin" style="position:relative;left:50%;transform: translate(-50%);">Sign in</button>
            </div>
            <div id="credenzialiErrate">
            	<?php
                	if(isset($_POST['matricola']) && isset($_POST['password']) && isset($_POST['cognome']))
                    {
                        if($connectionToServerDB->query('select * from users where matricola="'.$_POST['matricola'].'" and password=md5("'.$_POST['password'].'") and cognome="'.$_POST['cognome'].'" lock in share mode;')->num_rows == 0)
                        {
                            echo '<p style="color:red">Cognome, Matricola o Password errati</p>';
                        }
                    }
                ?>
            </div>
        </form>
        <?php
        	if(isset($_POST['matricola']) && isset($_POST['password']) && isset($_POST['cognome']))
            {
                if($connectionToServerDB->query('select * from users where matricola="'.$_POST['matricola'].'" and password=md5("'.$_POST['password'].'") and cognome="'.$_POST['cognome'].'" lock in share mode;')->num_rows > 0)
                {
                  $_SESSION['matricola'] = $_POST['matricola'];
                  $_SESSION['password'] = $_POST['password'];
                  header("Location: homePage.php");
               	}
            }
        ?>
</body>
</html>