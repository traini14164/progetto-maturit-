<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
                
                $row = $connectionToServerDB->query('select * from users where matricola="'.$_SESSION['matricola'].'" lock in share mode;')->fetch_assoc();
                echo $row["nome"]." ".$row["cognome"]." ".$_SESSION["matricola"];
            ?>
        </h2>
        <form action="cambioPassword.php" method="POST">         
        
            <div class="form-group">
                <input type="password" class="form-control input-lg" id="vpassword" style="border-radius: 50px;" name="vpassword" placeholder="Vecchia Password" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control input-lg" id="npassword" style="border-radius: 50px;" name="npassword" placeholder="Nuova Password" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control input-lg" id="rpassword" style="border-radius: 50px;" name="rpassword" placeholder="Ripeti Password" required="required">
            </div>
            <div class="form-group clearfix">
                <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=1>Cambia</button>
            </div>
            <div class="form-group clearfix">
                <button name ="opzione" type="button" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" onclick="window.location.href='mioProfilo.php'" value=0>indietro</button>
            </div>
             <?php
				include "connectToServer.php";
                if (isset($_POST["opzione"]))
                {
                    if($_POST['vpassword']==$_SESSION["password"])
                    {
                        if($_POST['rpassword']==$_POST['npassword'])
                        {
                            $connectionToServerDB->query("START TRANSACTION");
                            $result = $connectionToServerDB->query('update users set password=md5("'.$_POST['rpassword'].'") where matricola="'.$_SESSION['matricola'].'"');
                            transazione($result,$connectionToServerDB);
                            if($result)
                            {
                                $_SESSION['password'] = $_POST['npassword'];
                                echo 'Password modificata con successo';
                            }
                            else
                            {
                                echo 'Errore nella modifica della password';
                            }
                            $connectionToServerDB->query("CLOSE");
                        }
                        else
                        {
                            echo "Password diverse";
                        }
                    }
                    else
                    {
                        echo 'Password vecchia errata';
                    }

                }
                function transazione($result,$connectionToServerDB)
                {
                    if($result)
                    {
                        $connectionToServerDB->query("COMMIT");
                    }
                    else
                    {
                        $connectionToServerDB->query("ROLLBACK");
                    }
                }
              ?>
        </form>
    </div>
   
    </body>
</html>