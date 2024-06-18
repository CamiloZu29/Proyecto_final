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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/prueba.css">
</head>

<body> 
<?php
    include("encabezado.php");
    ?>
    <main>
        
        <!--Texto bienvenida-->
        <div class="ct">
            <h2 class="txt">Bienvenido/a a SPARTAN WEB la pagina oficial de la escuela deportiva de futbol de salon
                SPARTANOS. Aqui podra encontrar toda la informacion relacionada a los jugadores, plantillas,
                estadisticas y demas informacion oficial compartida por parte de la escuela deportiva.</h2>
        </div>
        <!--Espaciados-->
        <br>
        <br>
        <!--Tarjetas de informacion-->
        <div class="cards">
            <div class="card">
                <div class="face front">
                    <img src="IS/card1.jpg" alt="">
                    <h3>Spartanos</h3>
                </div>
                <div class="face back">
                    <h3>¿Quienes Somos?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, a corrupti. Repellat, molestias. Aspernatur hic, dolorum, porro sit dolore autem nulla sint sapiente reiciendis nisi optio veniam harum et, iusto quo deleniti in nostrum sed blanditiis delectus natus est ad esse? Repellat dicta asperiores, reiciendis ex aut, reprehenderit eligendi corporis odit fugit non veritatis itaque? Necessitatibus itaque nemo qui molestias.</p>
                </div>
            </div>
    
            <div class="card">
                <div class="face front">
                    <img src="IS/card2.jpg" alt="">
                    <h3>Horarios</h3>
                </div>
                <div class="face back">
                    <h3>Horarios</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, a corrupti. Repellat, molestias. Aspernatur hic, dolorum, porro sit dolore autem nulla sint sapiente reiciendis nisi optio veniam harum et, iusto quo deleniti in nostrum sed blanditiis delectus natus est ad esse? Repellat dicta asperiores, reiciendis ex aut, reprehenderit eligendi corporis odit fugit non veritatis itaque? Necessitatibus itaque nemo qui molestias?</p>
                </div>
            </div>
    
            <div class="card">
                <div class="face front">
                    <img src="IS/card0.jpg" alt="">
                    <h3>Torneos</h3>
                </div>
                <div class="face back">
                    <h3>Torneos</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, a corrupti. Repellat, molestias. Aspernatur hic, dolorum, porro sit dolore autem nulla sint sapiente reiciendis nisi optio veniam harum et, iusto quo deleniti in nostrum sed blanditiis delectus natus est ad esse? Repellat dicta asperiores, reiciendis ex aut, reprehenderit eligendi corporis odit fugit non veritatis itaque? Necessitatibus itaque nemo qui molestias</p>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <!--Carrusel de imagenes-->
        <section class="container">
            <div class="slider-wrapper">
                <div class="slider">
                    <img id="slider-1" src="IS/slider1.jpg" alt="">
                    <img id="slider-2" src="IS/slider22.png" alt="">
                    <img id="slider-3" src="IS/slider3.jpg" alt="">
                    <img id="slider-4" src="IS/slider4.png" alt="">
                </div>
                <div class="slider-nav">
                    <a href="#slider-1"></a>
                    <a href="#slider-2"></a>
                    <a href="#slider-3"></a>
                    <a href="#slider-4"></a>
                </div>
            </div>
        </section>
    
    </main>
    <br>
    <br>
    <br>

    <?php
    include("piepagina.html")
    ?>
    
</body>
</html>