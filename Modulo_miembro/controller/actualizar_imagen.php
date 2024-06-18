<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    exit(json_encode(['error' => 'Usuario no autenticado']));
}
$userId = $_SESSION['usuario'];
if ($_FILES['profileImage']) {
    $targetDir = "../vista/uploads/";
    $fileName = basename($_FILES['profileImage']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($fileType, $allowTypes)) {
        $host_spartanos = "localhost";
        $username_spartanos = "root";
        $password_spartanos = "";
        $database_spartanos = "spartanosos";

        $mysqli = new mysqli($host_spartanos, $username_spartanos, $password_spartanos, $database_spartanos);
        if ($mysqli->connect_error) {
            exit(json_encode(['error' => 'Error de conexión a spartanos: ' . $mysqli->connect_error]));
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
            $updateQuery = "UPDATE usuarios SET foto = '$fileName' WHERE username = '$userId'";

            if ($mysqli->query($updateQuery) === TRUE) {
                exit(json_encode(['success' => true, 'message' => 'Imagen actualizada correctamente']));
            } else {
                exit(json_encode(['error' => 'Error al actualizar la imagen en la base de datos']));
            }
        } else {
            exit(json_encode(['error' => 'Error al subir la imagen']));
        }

        $mysqli->close();
    } else {
        exit(json_encode(['error' => 'Formato de archivo no permitido']));
    }
} else {
    exit(json_encode(['error' => 'No se recibió ninguna imagen']));
}