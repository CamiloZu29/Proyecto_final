<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "spartanos";

$conexion = new mysqli($server, $user, $password, $db);

if($conexion->connect_errno) {
    die("Conexión a base de datos fallida: " . $conexion->connect_errno);
} else{
    echo "";
}
