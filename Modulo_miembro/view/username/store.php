<?php
require_once ("c://xampp/htdocs/Modulo_miembro/controller/usernameControler.php");
$obj = new usernameController();




// Obtener los datos del formulario
$doc_identidad = $_POST['doc_identidad'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
$altura = $_POST['altura'] ?? '';
$peso = $_POST['peso'] ?? '';
$pie_dominante = $_POST['pie_dominante'] ?? '';
$posicion = $_POST['posicion'] ?? '';
$contacto_acudiente = $_POST['contacto_acudiente'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$id_user = $_POST['id_user'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$eps = $_POST['eps'] ?? '';
$estado_eps = $_POST['estado_eps'] ?? '';
$categoria = $_POST['categoria'] ?? '';

// Verificar si se ha cargado una foto y obtenerla
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['foto'];
    $fotoPath = "imagenes/usuarios/" . $nombre . "_" . $apellido . "/" . basename($foto["name"]);
    $targetDir = "c://xampp/htdocs/Modulo_miembro/view/imagenes/usuarios" . $fotoPath;
    if (!is_dir(dirname($targetDir))) {
        mkdir(dirname($targetDir), 0777, true); // Crear el directorio si no existe
    }
    move_uploaded_file($foto["tmp_name"], $targetDir);
} else {
    $fotoPath = null;
}

// Llamar a la función guardar en el controlador, incluyendo la categoría y la ruta de la foto
$obj->guardar($doc_identidad, $nombre, $apellido, $fecha_nacimiento, $fotoPath, $altura, $peso, $pie_dominante, $posicion, $contacto_acudiente, $descripcion, $id_user, $direccion, $eps, $estado_eps, $categoria);
?>