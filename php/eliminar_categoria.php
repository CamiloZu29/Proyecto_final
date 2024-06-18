<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 
<?php
include("conexion.php");

if (isset($_GET['id_categoria'])) {
    $id_categoria = $_GET['id_categoria'];

    // Intentar eliminar la categoría
    $sql_delete_category = "DELETE FROM categorias WHERE id_categoria = ?";
    $stmt_category = $conexion->prepare($sql_delete_category);
    $stmt_category->bind_param("i", $id_categoria);

    try {
        $stmt_category->execute();
        if ($stmt_category->affected_rows > 0) {
            // Redirigir después de eliminar exitosamente
            header("Location: categorias.php?mensaje=eliminado");
        } else {
            // Si no se pudo eliminar (afectó 0 filas)
            header("Location: categorias.php?mensaje=no_existe");
        }
    } catch (mysqli_sql_exception $e) {
        // Si ocurre un error de clave foránea
        if ($e->getCode() == 1451) {
            header("Location: categorias.php?mensaje=error_foranea");
        } else {
            // Otros errores
            header("Location: categorias.php?mensaje=error_general");
        }
    }

    $stmt_category->close();
    $conexion->close();
} else {
    echo "ID de categoría no proporcionado.";
}
exit();
