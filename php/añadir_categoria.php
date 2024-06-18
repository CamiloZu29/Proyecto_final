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
    <link rel="stylesheet" href="../css/añadir_categoria.css">
</head>

<body>
    <?php
    include("encabezado.php");
    ?>
    <main>
        <?php
        include("conexion.php"); // Conexión a la base de datos
        if (isset($_POST['enviar'])) {
            if (!empty($_POST['nombre_categoria']) && !empty($_POST['edad_min']) && !empty($_POST['edad_max'])) {
                $nombrecat = $_POST['nombre_categoria'];
                $edadmin = $_POST['edad_min'];
                $edadmax = $_POST['edad_max'];

                // Sentencia SQL para insertar los datos en la base de datos
                $sql = "INSERT INTO categorias (nombre_categoria, edad_min, edad_max) VALUES ('$nombrecat', '$edadmin', '$edadmax')";

                $resultado = mysqli_query($conexion, $sql);

                // Alertas, según si está bien o mal
                if ($resultado) {
                    echo "<script language='JavaScript'>
                    alert('La categoría se añadió correctamente :)');
                    location.assign('categorias.php');
                    </script>";
                } else {
                    echo "<script language='JavaScript'>
                    alert('La categoría no se pudo añadir correctamente: " . mysqli_error($conexion) . "');
                    location.assign('categorias.php');
                    </script>";
                }
            } else {
                echo "Asegúrate de completar todos los campos.";
            }
        }
        ?>
        <form id="updateForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h2 style="margin-bottom: 30px;">Añadir Categoria</h2>
                <div class="mb-3">
                    <label for="nombre_categoria" class="form-label">Nombre Categoria:</label>
                    
                    <textarea id="nombre_categoria" class="form-control-desc" name="nombre_categoria"
                        autocomplete="off"></textarea>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
                    <label for="edad_min" class="form-label">Edad Minima:</label>
                    
                    <textarea id="edad_min" class="form-control-desc" name="edad_min"
                        autocomplete="off"></textarea>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="id_categoria" value="<?php echo $id; ?>">
                    <label for="edad_max" class="form-label">Edad Maxima:</label>
                    
                    <textarea id="edad_max" class="form-control-desc" name="edad_max"
                        autocomplete="off"></textarea>
                </div>
                <input style="margin-top: 20px; cursor:pointer; text-decoration: none; color: black;" type="submit" name="enviar" autocomplete="off" value="Añadir Categoria"> 
                <button style="margin-top: 20px; width: 50px; height: 20px;"> <a style="text-decoration: none; color: black;" href="categorias.php">Volver</a></button>
            </form>
    </main>
    <?php include("piepagina.html"); ?></body>

</html>