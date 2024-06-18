<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/actualizacion.css">
</head>

<body>
    <?php include("encabezado.php"); ?>
    <main>
        <?php
        include("conexion.php"); // Conexión a la base de datos
        
        if (isset($_POST['enviar'])) {
            $id = $_POST['doc_identidad'];
            $descripcion = $_POST['descripcion'];

            // Sentencia SQL que actualiza en la base de datos los campos que el usuario cambie
            $sql = "UPDATE miembro SET descripcion='$descripcion' WHERE doc_identidad=$id";

            // Ejecuta la consulta
            $resultado = mysqli_query($conexion, $sql);

            // Alertas, según si está bien o mal
            if ($resultado) {
                echo "<script language='JavaScript'>
                alert('Los datos se han actualizado correctamente al miembro :)');
                location.assign('descripcion.php?doc_identidad=$id');
                </script>";
            } else {
                echo "<script language='JavaScript'>
                alert('Los datos no se han podido actualizar correctamente: " . mysqli_error($conexion) . "');
                location.assign('descripcion.php?doc_identidad=$id');
                </script>";
            }
        } else {
            // Si no se ha enviado el formulario, muestra el formulario de actualización
            if (isset($_GET['doc_identidad']) && is_numeric($_GET['doc_identidad'])) {
                $id = intval($_GET['doc_identidad']);
                
                // Consulta SQL para obtener datos basados en el identificador
                $sql = "SELECT doc_identidad, descripcion 
                        FROM miembro WHERE doc_identidad = $id";

                $resultado = mysqli_query($conexion, $sql);

                if (mysqli_num_rows($resultado) > 0) {
                    $fila = mysqli_fetch_assoc($resultado);
                    $id = $fila["doc_identidad"];
                    $descripcion = $fila["descripcion"];
                    ?>
                    <form id="updateForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <h2 style="margin-top: 20px;">Actualización Descripción</h2>
                        <div class="mb-3">
                            <input type="hidden" name="doc_identidad" value="<?php echo $id; ?>">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <br><br>
                            <textarea id="descripcion" class="form-control-desc" name="descripcion"
                                      autocomplete="off"><?php echo $descripcion; ?></textarea>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <input
                            style="cursor: pointer; margin-top: 20px; font-size: 15px;width: 100px; height: 40px; border-radius: 8px; margin-top: 130px; align-self: center;"
                            class="actualizar" type="submit" name="enviar" autocomplete="off" value="Actualizar">
                        <?php echo '<a style="text-align: center; text-decoration: none; background-color: white; color: black; cursor: pointer; font-size: 15px; width: 100px; height: 22px; border-radius: 8px; margin-top: 5px; margin-bottom: 20px; align-self: center;" href="descripcion.php?doc_identidad=' . $fila['doc_identidad'] . '">Volver</a>'; ?>
                    </form>
                    <?php
                } else {
                    echo "No se encontraron datos para actualizar.";
                }
            } else {
                echo "Parámetro 'doc_identidad' no válido o no proporcionado.";
            }
        }
        ?>
    </main>
    <?php include("piepagina.html"); ?>
</body>

</html>
