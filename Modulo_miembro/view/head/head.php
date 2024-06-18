<?php 
$Email = isset($_SESSION['EMAIL']) ? $_SESSION['EMAIL'] : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/head.css">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="logo"><a href="../../../php/prueba.php">SpartanWeb</a></div>
            <ul class="links">
                <li><a href="">Miembros</a></li>
                <li><a href="../../../php/lista_usuarios.php">Usuarios</a></li>
                <li><a href="../../../php/roles.php">Roles</a></li>
                <li><a href="../../../php/categorias.php">Categorias</a></li>
                <li><a href="../../../php/asistencias.php">Asistencias</a></li>
                <li><a href="../../../php/lista_pagos.php">Pagos</a></li>
                <li><a href="../../../php/lista_desc.php">Descripciones</a></li>
            </ul>
            <a href="../../../php/salir.php" class="btn1">
                <div class="user">
                    <img src="../../../php/salir.png" alt="Logout">
                </div>
            </a>

        <div class="dropdown_menu">
            <li><a href="#">Miembros</a></li>
            <li><a href="#">Usuarios</a></li>
            <li><a href="#">Roles</a></li>
            <li><a href="#">Categorias</a></li>
            <li><a href="#">Asistencias</a></li>
            <li><a href="#">Pagos</a></li>
            <li><a href="lista_desc.php">Descripciones</a></li>
            <li><a href="#" class="action_btn">Iniciar Sesion</a></li>
        </div>
    </header>

    <script src="../js/script.js"></script> <!-- Asegúrate de que este sea el nombre correcto del archivo JavaScript -->
</body>

</html>





