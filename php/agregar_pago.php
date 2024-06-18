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
    include("encabezado.php
    ");
?>
    <main>
        <?php
        include("conexion.php");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extraer los datos del formulario
            $multa = $_POST['multa'];
            $fecha = $_POST['fecha'];
            $fechalimite = $_POST['fecha_limite'];
            $monto = $_POST['monto'];
            $confirm_monto = $_POST['confirm_monto'];
            $doc_pago = $_POST['doc_pago'];

            if ($monto !== $confirm_monto) {
                echo "<script>alert('Los montos no coinciden. Por favor, verifique los valores ingresados.'); window.location = '" . $_SERVER['PHP_SELF'] . "';</script>";
            } else {
                // Verificar si el documento de identidad existe en la tabla miembro
                $stmt_verificar = $conexion->prepare("SELECT COUNT(*) FROM miembro WHERE doc_identidad = ?");
                $stmt_verificar->bind_param("i", $doc_pago);
                $stmt_verificar->execute();
                $stmt_verificar->bind_result($existe);
                $stmt_verificar->fetch();
                $stmt_verificar->close();

                if ($existe > 0) {
                    // Preparar y enlazar la consulta
                    $stmt = $conexion->prepare("INSERT INTO pagos (fecha_pago, monto, doc_pago, multa, fecha_limite) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssiss", $fecha, $monto, $doc_pago, $multa, $fechalimite);

                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        // Mostrar alerta y redirigir
                        echo "<script>alert('Pago agregado correctamente.'); window.location = 'lista_pagos.php';</script>";
                    } else {
                        die("Error al agregar el pago: " . $conexion->error);
                    }

                    // Cerrar la consulta
                    $stmt->close();
                } else {
                    // Mostrar mensaje de error y redirigir
                    echo "<script>alert('Documento de identidad incorrecto.'); window.location = 'lista_pagos.php';</script>";
                }
            }
        }

        $conexion->close();
        ?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <h2 style="margin-top: 20px;">Agregar pago</h2>
            <input type="hidden" name="id_pago" value="<?= $id ?>">
            <div class="mb-3">
                <label for="doc_pago" class="form-label">Doc de pago:</label>
                <br>
                <input type="text" class="form-control" name="doc_pago" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto:</label>
                <br>
                <input type="text" class="form-control" name="monto" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="confirm_monto" class="form-label">Confirmar monto:</label>
                <br>
                <input type="text" class="form-control" name="confirm_monto" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="fecha_limite" class="form-label">Fecha límite:</label>
                <br>
                <input type="date" class="form-control" name="fecha_limite" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de pago:</label>
                <br>
                <input type="date" class="form-control" name="fecha" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="multa" class="form-label">Multa:</label>
                <br>
                <input type="text" class="form-control" name="multa" autocomplete="off">
            </div>

            <br>
            <br>
            <input style="cursor: pointer; font-size: 15px;width: 100px; height: 40px; border-radius: 8px;
            margin-top: 30px; align-self: center;" class="Agregar" type="submit" name="enviar" autocomplete="off" value="Agregar">
            <a style=" text-align: center; text-decoration: none; background-color:white; color:black; cursor: pointer;
            font-size: 15px;width: 100px; height: 22px; border-radius: 8px; margin-top: 5px; margin-bottom: 20px; align-self: center;" href="lista_pagos.php" onclick="return confirmar()"> volver </a>

        </form>

    </main>
    <?php include("piepagina.html"); ?>



</body>

</html>