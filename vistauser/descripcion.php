<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>SpartanWeb / Ranking</title>
    <link rel="stylesheet" href="css/descripcion.css">
</head>

<body>
    <?php include("encabezado.html"); ?>
    <main>
        <?php
        include("conexion.php"); // Conexión a la base de datos
        
        // Verificación del parámetro 'doc_identidad'
        if (isset($_GET['doc_identidad']) && is_numeric($_GET['doc_identidad'])) {
            $id = intval($_GET['doc_identidad']);
            
            // Consulta SQL usando el identificador
            $sql = "SELECT doc_identidad, nombre, apellido, foto, pie_dominante, altura, peso, posicion, descripcion 
                    FROM miembro WHERE doc_identidad = $id";

            $result = mysqli_query($conexion, $sql);

            if (!$result) { // Verifica si la consulta fue exitosa
                die("Error en la consulta: " . mysqli_error($conexion)); // Manejo de error en la consulta
            }

            if (mysqli_num_rows($result) > 0) {
                $fila = mysqli_fetch_assoc($result);
                $id = $fila["doc_identidad"];
                $nombre = $fila["nombre"];
                $apellido = $fila["apellido"];
                $foto = $fila["foto"];
                $pie = $fila["pie_dominante"];
                $altura = $fila["altura"];
                $peso = $fila["peso"];
                $posicion = $fila["posicion"];
                $descripcion = $fila["descripcion"];

                echo "<div class='general'>";
                echo "<div class='imagen'><img style='height: 500px; width: 400px; border-radius: 10px;' src='" . $foto . "' alt='Foto'></div>";
                echo "<div class='cont_1'>" . $nombre . " " . $apellido . "</div>";
                echo "<div class='general_2'>";
                echo "<div class='cont_2'>" . $pie . "</div>";
                echo "<div class='cont_3'>" . $altura . "Cm" . "</div>";
                echo "<div class='cont_4'>" . $peso . "Kg" . "</div>";
                echo "<div class='cont_5'>" . $posicion . "</div>";
                echo "</div>";
                echo "<div class='cont_6'><p style='width: 90%; height: 90%;'>" . $descripcion . "</p></div>";
                echo "</div>";

                echo "<div class='botones'>";
                echo "<div class='boton1'><a href='lista_desc.php'>Regresar</a></div>";
            } else {
                echo "No se encontraron datos para mostrar.";
            }
        } else {
            echo "Parámetro 'doc_identidad' no válido o no proporcionado.";
        }
        ?>
    </main>
    <?php
    include("piepagina.html")
    ?>
</body>

</html>
