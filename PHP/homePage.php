<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home Page</title>
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
            $_SESSION['nome'] = $row["nome"];
            $_SESSION['cognome'] = $row["cognome"];
            $_SESSION['data_nascita'] = $row["data_nascita"];
            $_SESSION['tipo'] = $row["tipo"];
        	echo $row["nome"]." ".$row["cognome"]." ".$_SESSION["matricola"];
		?>
    </h2>
    <form action="homePage.php" method="post">
        <div class="form-group clearfix">
			<button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=3>Profilo</button>
		</div>
        <?php
        	if($row["tipo"] == "adm" || $row["tipo"] == "seg" || $row["tipo"] == "doc")
            {
            	echo '<div class="form-group clearfix">
                          <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=1>Visualizza Utenti</button>
                      </div>';
            }
            if($row["tipo"] == "adm" || $row["tipo"] == "seg")
            {
                echo '<div class="form-group clearfix">
                          <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=2>Inserisci Nuovi Utenti</button>
                      </div>';
            }
            if($row["tipo"] == "adm")
            {
                echo '<div class="form-group clearfix">
                          <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=4>Elimina Utenti</button>
                      </div>';
            }
        ?>
        <div class="form-group clearfix">
            <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=0>Sign out</button>
        </div>
    </form>
</div>
<?php
if (isset($_POST["opzione"]))
{
  switch ($_POST["opzione"])
  {
  	  case 0:
      {
          header("Location:index.php");
      }break;
      case 1:
      {
          header("Location:visualizza.php");
      }break;

      case 2:
      {
          header("Location:inserisci.php");
      }break;
      
      case 3:
      {
          header("Location:mioProfilo.php");
      }break;
      
      case 4:
      {
          header("Location:elimina.php");
      }break;
  }
}
?>
</body>
</html>