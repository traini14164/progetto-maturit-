<!DOCTYPE html>
<html>
<head>
  <title>Visualizza Utenti</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body>
    <div class="login-form" style="width:55%;display:block;">
        <h2 class="text-center">Visualizza Utenti</h2>
        <form method="POST" action="homePage.php">
<?php
	include "connectToServer.php";
    if(!isset($_SESSION['matricola']) || !isset($_SESSION['password']) )
    {
      header("Location: index.php");
    }
    if($_SESSION['tipo']=="stu")
    {
    	header("Location: homePage.php");
    }
    echo '<table class="table table-responsive table-bordered table-hover" style="width:100%;box-shadow: 0px 2px 2px rgba(0,0,0,0.1);position:relative;overflow:hidden;border-collapse: collapse;border-radius:0.5em;left:50%;transform:translate(-50%);text-align:center;"><thead style="text-align:center;"><tr style="color:white;background:#4ABA70;text-align:center;"><th style="text-align:center;">Nome</th><th style="text-align:center;">Cognome</th><th style="text-align:center;">Matricola</th><th style="text-align:center;">Data di Nascita</th><th style="text-align:center;">Tipo Account</th></tr></thead><tbody>';
   	$results = $connectionToServerDB->query( 'select * from users lock in share mode;' );      
    while($row = $results->fetch_assoc()) 
    {
          extract($row);       
          echo '<td>'.$nome.'</td>';
          echo '<td>'. $cognome.'</td>';
          echo '<td>'. $matricola.'</td>';
          echo '<td>'. $data_nascita.'</td>';
          switch($tipo)
          {
          	case "adm":
            	{
                	echo '<td>amministratore</td></tr>';
                }break;
			case "doc":
            	{
                	echo '<td>docente</td></tr>';
                }break;
			case "seg":
            	{
                	echo '<td>segreteria</td></tr>';
                }break;
			case "stu":
            	{
                	echo '<td>studente</td></tr>';
                }break;
          }
    }
          echo "</tbody></table><br>";
?>
<div class="form-group clearfix">
            <button type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=1>Home Page</button>
        </div>
</form>
</div>
</body>
</html>
