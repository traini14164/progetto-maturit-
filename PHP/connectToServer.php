<?php

$host = "localhost";
$username = "gestioneutenti";
$password = "";
$db = "my_gestioneutenti";
$connectionToServerDB = new mysqli($host,$username,$password,$db);

if($connectionToServerDB->connect_error)
{
    die("Connessione fallita ".$connectionToServerDB->connect_error);
}
session_start();

?>