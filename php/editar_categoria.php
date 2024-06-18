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
    <link rel="stylesheet" href="../css/editar_categoria.css">
</head>

<body>
<?php
    include("encabezado.php");
    ?>
    <main>
        <?php
        include ("conexion.php"); // Conexión a la base de datos
        if (isset($_POST['enviar'])) {
            $id = $_POST['id_categoria'];
            $nombrecat = $_POST['nombre_categoria'];
            $edadmin = $_POST['edad_min'];
            $edadmax = $_POST['edad_max'];


            // Sentencia sql que actualiza en la base de datos, los campos que el usuario cambie
            $sql = "UPDATE categorias SET nombre_categoria='$nombrecat', edad_min='$edadmin', edad_max='$edadmax' WHERE id_categoria=$id";

            // Ejecuta la consulta
            $resultado = mysqli_query($conexion, $sql);

            //Alertas, segun si esta bien o mal
            if ($resultado) {
                echo "<script lenguage='JavaScript'>
                alert ('Los datos se han actualizado correctamente a la categoria :)');
                location.assign('categorias.php');
                </script>";
            } else {
                echo "<script lenguage='JavaScript'>
                alert ('Los datos no se han podido actualizar correctamente:" . mysqli_error($conexion) . "');
                location.assign('categorias.php');
                </script>";
            }
        } else
            // Si no se ha enviado el formulario, muestra el formulario de actualización
            $id = $_GET['id_categoria'];
        // Consulta SQL para obtener datos basados en el identificador
        $sql = "SELECT * FROM categorias WHERE id_categoria = $id";

        $resultado = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            $id = $fila["id_categoria"];
            $nombrecat = $fila['nombre_categoria'];
            $edadmin = $fila['edad_min'];
            $edadmax = $fila['edad_max'];
            ?>
            <form id="updateForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h2 style="margin-bottom: 30px;">Actualización Categoria</h2>
                <div class="mb-3">
                    <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
                    <label for="nombre_categoria" class="form-label">Nombre Categoria:</label>
                    
                    <textarea id="nombre_categoria" class="form-control-desc" name="nombre_categoria"
                        autocomplete="off"><?php echo $nombrecat; ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
                    <label for="edad_min" class="form-label">Edad Minima:</label>
                    
                    <textarea id="edad_min" class="form-control-desc" name="edad_min"
                        autocomplete="off"><?php echo $edadmin; ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
                    <label for="edad_max" class="form-label">Edad Maxima:</label>
                    
                    <textarea id="edad_max" class="form-control-desc" name="edad_max"
                        autocomplete="off"><?php echo $edadmax; ?></textarea>
                </div>
                <input style="margin-top: 10px; cursor:pointer; text-decoration: none; color: black;" type="submit" name="enviar" autocomplete="off" value="Actualizar"> 
                <?php echo '<button style="margin-top: 20px; width: 50px; height: 20px;><a style="text-decoration: none; color: black;" href="categorias.php?id_categoria=' . $fila['id_categoria'] . '" onclick="return confirmar()">Volver</a></button>' ?>
            </form>
            <?php
        } else {
            echo "No se encontraron datos para actualizar.";
        }
        ?>
    </main>
    <?php include("piepagina.html"); ?>
</body>

</html>