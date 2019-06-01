<!DOCTYPE html>
<html>
    <head>
    <title>Elimina Utenti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
        var y = new document.getElementById();
        function recordSelezionato(x,m)
        {
            if (typeof y !== 'undefined')
            {
                y.style.backgroundColor = "white";
            }
            y = x;
            x.style.backgroundColor = "#dadfe8";
            var bottone = document.getElementById("sostituisci");
            bottone.innerHTML ='<div class="form-group clearfix"> <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=1>Elimina</button></div>';
            document.getElementById("riga").value = m;
        }
        </script>
    </head>

    <body>
        <div class="login-form" style="width:55%;">
            <h2 class="text-center">Elimina Utenti</h2>
            <form method="POST" action="elimina.php">
                <?php
                    include "connectToServer.php";
                    if(!isset($_SESSION['matricola']) || !isset($_SESSION['password']) )
                    {
                        header("Location: index.php");
                    }
                    if($_SESSION['tipo'] != "adm")
                    {
                        header("Location: homePage.php");
                    }
                    echo '<table id="tabella" class="table table-responsive table-bordered table-hover" style="width:100%;box-shadow: 0px 2px 2px rgba(0,0,0,0.1);overflow:hidden;border-collapse: collapse;border-radius:0.5em;position:relative;left:50%;transform:translate(-50%);text-align:center;"><thead style="text-align:center;"><tr style="color:white;background:#4ABA70;text-align:center;"><th style="text-align:center;">Nome</th><th style="text-align:center;">Cognome</th><th style="text-align:center;">Matricola</th><th style="text-align:center;">Data di Nascita</th><th style="text-align:center;">Tipo Account</th></tr></thead><tbody>';
                    $results = $connectionToServerDB->query( 'select * from users lock in share mode;;' );
                    while($row = $results->fetch_assoc()) 
                    {
                        extract($row);
                        if($matricola != $_SESSION['matricola'])
                        {
                        	echo '<tr name="record" onclick="recordSelezionato(this,'.$matricola.')" ><td>'.$nome.'</td>';
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
                    }
                    echo "</tbody></table><br>";
                ?>

                <p id="sostituisci"></p>
                <div class="form-group clearfix">
                    <button type="submit" name="opzione" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=0>Home Page</button>
                </div>
                <input type="hidden" value="" name="riga" id="riga">

                <?php
                    if(isset($_POST['opzione']))
                    {
                        switch ($_POST['opzione'])
                        {
                            case 0:
                                {
                                    header("Location: homePage.php");
                                }break;
                            case 1:
                                {
                                    if(isset($_POST['riga']))
                                    {
                                        $connectionToServerDB->query("START TRANSACTION");
                                        $result = $connectionToServerDB->query('delete from users where matricola = '.$_POST['riga'].';');
                                        transazione($result,$connectionToServerDB);
                                        if($result)
                                        {
                                            header("Location: elimina.php");
                                        }
                                        else
                                        {
                                            echo '<p style="color:red">Errore nella cancellazione dello studente</p>';
                                        }
                                        $connectionToServerDB->query("CLOSE");
                                    }
                                }break;
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