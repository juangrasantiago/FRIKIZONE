<?php
session_start(); // Iniciar la sesión si no está iniciada

// Variable para almacenar los nombres de los productos del carrito
$resumenPedido = "";

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalItems = $_POST["totalItems"];

    // Limpiar el carrito anterior si existe
    $_SESSION["juegos"] = array();

    for ($i = 0; $i < $totalItems; $i++) {
        // Verificar si el juego está marcado y agregarlo al carrito
        if (isset($_POST["title-" . $i])) {
            $_SESSION["juegos"][] = $_POST["title-" . $i];
            // Agregar el nombre del producto al resumen
            $resumenPedido .= $_POST["title-" . $i] . " "; // Agregar un espacio al final
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="http://localhost/proyectodaw/style.css">
</head>
<body>
    <form name="form" method="POST" action="conexion_bbdd_metodopago.php">
    <!-- FOTO LOGO y REDIRECCIONA A LA PAGINA PRINCIPAL-->
    <a href="http://localhost/proyectodaw/index.html">
        <img src="Imagenes\Logo.png" class="Logo" alt="">
    </a>
    <form name="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="formulario">
            <h1>Datos de Pago</h1>
            
            <!-- Aquí van los campos del formulario de pago -->
            <div class="username nombre">
                <input type="text" name="Nombre" required>
                <label>Nombre</label>
            </div>
            <div class="username apellidos">
                <input type="text" name="Apellidos" required>
                <label>Apellidos</label>
            </div>
            <div class="username">
                <input type="text" name="correoElectronico" required>
                <label>Correo Electrónico</label>
            </div>
            <div class="username">
                <input type="text" name="numeroTarjeta" required>
                <label>Número de Tarjeta</label>
            </div>
            <div class="username direccion">
                <input type="text" name="Direccion" required>
                <label>Dirección</label>
            </div>
            <!-- Campo para mostrar el resumen del pedido -->
            <div class="username">
                <input type="text" id="resumenPedido" name="resumenPedido" value="<?php echo $resumenPedido; ?>" readonly>
                <label>Resumen del Pedido</label>
            </div>
            <input type="submit" value="Realizar Pago" name="pago">
        </div>
    </form>
    <script src="http://localhost/proyectodaw/script.js"></script>
</body>
</html>






