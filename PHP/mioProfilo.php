<!DOCTYPE html>
<html lang="en">
<head>
  <title>Il Mio Profilo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
    <?php
        include 'connectToServer.php';
        if(!isset($_SESSION['matricola']) || !isset($_SESSION['password']) )
        {
            header("Location: index.php");
        }
    ?>
    <body>
    <div class="login-form">
        <h2 class="text-center">
            <?php
                echo $_SESSION["nome"]." ".$_SESSION["cognome"]." ".$_SESSION["matricola"];
            ?>
        </h2>
        <form action="inserisci.php" method="POST">  
        <p>Nome:<br>
        </p>
        <div class="form-group">
                <input type="text" class="form-control input-lg" id="nome" style="border-radius: 50px;" name="nome" value="<?php echo $_SESSION['nome']?>" readonly="readonly">
        </div>
        <p>Cognome:<br>
        </p>
        <div class="form-group">
                <input type="text" class="form-control input-lg" id="matricola" style="border-radius: 50px;" name="cognome" value="<?php echo $_SESSION['cognome']?>" readonly="readonly">
        </div>
        <p>Matricola:<br>
        </p>
        <div class="form-group">
                <input type="text" class="form-control input-lg" id="nome" style="border-radius: 50px;" name="matricola" value="<?php echo $_SESSION['matricola']?>" readonly="readonly">
        </div>
		 <p>Data Nascita:<br>
        </p>
        <div class="form-group">
                <input type="date" class="form-control input-lg" id="matricola" style="border-radius: 50px;" name="data" value="<?php echo $_SESSION['data_nascita']?>" readonly="readonly">
        </div>
        <p>Tipo:<br>
        </p>
        <div class="form-group">
                <input type="text" class="form-control input-lg" id="nome" style="border-radius: 50px;" name="matricola" value="<?php 
                    switch($_SESSION['tipo'])
                      {
                        case "adm":
                            {
                                echo 'Amministratore';
                            }break;
                        case "doc":
                            {
                                echo 'Docente';
                            }break;
                        case "seg":
                            {
                                echo 'Segreteria';
                            }break;
                        case "stu":
                            {
                                echo 'Studente';
                            }break;
          			}
          ?>" readonly="readonly">
        </div>
      
            <div class="form-group clearfix">
                <button name ="opzione" type="button" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" onclick="window.location.href='cambioPassword.php'" value=1>Cambia Password</button>
            </div>
            <div class="form-group clearfix">
                <button name ="opzione" type="button" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" onclick="window.location.href='homePage.php'" value=0>Home Page</button>
            </div>
             <?php
    if (isset($_POST["opzione"]))
    {
        switch ($_POST["opzione"])
        {
            case 1:
            {
                if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['matricola']) && isset($_POST['password']) && isset($_POST['data']) && isset($_POST['tipo']))
                {
                    if($connectionToServerDB->query('insert into users (matricola,nome,cognome,password,data_nascita,tipo) values ("'.$_POST['matricola'].'","'.$_POST['nome'].'","'.$_POST['cognome'].'",md5("'.$_POST['password'].'"),"'.$_POST['data'].'","'.$_POST['tipo'].'")'))
                    {
                        echo '<p style="color:green">Studente inserito con successo</p>';
                    }
                    else
                    {
                        echo '<p style="color:red">Errore nell\' inserimento dello studente</p>'; 
                    }
                }
            }break;
        }
    }
    ?>
        </form>
    </div>
   
    </body>
</html>