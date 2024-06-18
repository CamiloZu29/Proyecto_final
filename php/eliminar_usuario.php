<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: login.php');
    exit();
}

include "conexion.php";

$id_usuario = $_GET['id_usuario'];

$query_delete = mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'");

if ($query_delete) {
    header("Location: lista_usuarios.php");
} else {
    echo '<p class="msg_error">Error al eliminar el usuario</p>';
}
?>
