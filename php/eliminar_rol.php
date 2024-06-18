<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: login.php');
    exit();
}

include("conexion.php"); // Conexión a la base de datos

if (!empty($_GET['id_rol'])) {
    $id = $_GET['id_rol'];

    // Check if there are any users with this role
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE rol = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script language='JavaScript'>
                alert('No se puede eliminar el rol ya que tiene usuarios asociados.');
                location.assign('roles.php');
              </script>";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conexion->prepare("DELETE FROM roles WHERE id_rol = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script language='JavaScript'>
                    alert('El rol se borró correctamente :)');
                    location.assign('roles.php');
                  </script>";
        } else {
            echo "<script language='JavaScript'>
                    alert('El rol no se pudo borrar correctamente: " . $stmt->error . "');
                    location.assign('roles.php');
                  </script>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conexion->close();
?>
