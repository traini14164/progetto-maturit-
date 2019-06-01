<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Inserisci utenti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
        function dataPlaceholder()
        {
            document.getElementById("data").focus();
            document.getElementById("nome").focus();
        }
    </script>
    
    </head>
    <?php
        include 'connectToServer.php';
        if(!isset($_SESSION['matricola']) || !isset($_SESSION['password']) )
        {
            header("Location: index.php");
        }
        if($_SESSION['tipo'] != "adm" && $_SESSION['password'] != "seg")
        {
            header("Location: homePage.php");
        }
    ?>
    <body onload="dataPlaceholder()">
        <div class="login-form">
            <h2 class="text-center">
                <?php
                    $row = $connectionToServerDB->query('select * from users where matricola="'.$_SESSION['matricola'].'" lock in share mode;')->fetch_assoc();
                    echo "Inserisci utenti";
                ?>
            </h2>
            <form action="inserisci.php" method="POST">         
                <div class="form-group">
                    <input type="text" class="form-control input-lg" id="nome" style="border-radius: 50px;" name="nome" placeholder="Nome" required="required">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control input-lg" id="matricola" style="border-radius: 50px;" name="cognome" placeholder="Cognome" required="required">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-lg" id="password" style="border-radius: 50px;" name="password" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                    <input type="date" class="form-control input-lg" id="data" style="border-radius: 50px;" name="data" placeholder="Data di Nascita" onfocus="(this.type='date')" onblur="(this.type='text')" required="required">
                </div>
                <div class="form-group">
                    <select type="select" class="form-control input-lg" id="tipo" style="border-radius: 50px;" name="tipo" required="required" placeholder="Tipo" >
                        <option value="" disabled selected>Tipo</option>
                        <option value="adm">admin</option>
                        <option value="doc">docente</option>
                        <option value="seg">segreteria</option>
                        <option value="stu">studente</option>
                    </select>
                </div>
                <div class="form-group clearfix">
                    <button name ="opzione" type="submit" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" value=1>inserisci</button>
                </div>
                <div class="form-group clearfix">
                    <button name ="opzione" type="button" class="btn btn-primary btn-lg" style="position:relative;left:50%;transform: translate(-50%);" onclick="window.location.href='homePage.php'" value=0>Home Page</button>
                </div>
                <?php
                    if (isset($_POST["opzione"]))
                    {
                        switch ($_POST["opzione"])
                        {
                            case 0:
                            {
                                header("Location: homePage.php");
                            }break;
                            case 1:
                            {
                                if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['password']) && isset($_POST['data']) && isset($_POST['tipo']))
                                {
                                    $connectionToServerDB->query("START TRANSACTION");
                                    $result = $connectionToServerDB->query('insert into users (nome,cognome,password,data_nascita,tipo) values ("'.$_POST['nome'].'","'.$_POST['cognome'].'",md5("'.$_POST['password'].'"),"'.$_POST['data'].'","'.$_POST['tipo'].'");');
                                    transazione($result,$connectionToServerDB);
                                    if($result)
                                    {
                                        echo '<p style="color:green">Studente inserito con successo</p>';
                                    }
                                    else
                                    {
                                        echo '<p style="color:red">Errore nell\' inserimento dello studente</p>'; 
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