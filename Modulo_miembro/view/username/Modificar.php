//pasamos los parametor por el metodo post
<?php
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/controller/usernameControler.php");
$obj = new usernameController();
$obj->Modificar(
    $_POST['doc_identidad'],
    $_POST['nombre'],
    $_POST['apellido'],
    $_POST['fecha_nacimiento'],
    $_POST['foto'],
    $_POST['altura'],
    $_POST['peso'],
    $_POST['pie_dominante'],
    $_POST['posicion'],
    $_POST['contacto_acudiente'],
    $_POST['descripcion'],
    $_POST['cat_miembro'],
    $_POST['id_user'],
    $_POST['direccion'],
    $_POST['eps'],
    $_POST['estado_eps']
);

?>
