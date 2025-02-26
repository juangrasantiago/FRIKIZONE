<?php
session_start(); // Iniciar la sesión si no está iniciada

// Verificar si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["Nombre"];
    $apellidos = $_POST["Apellidos"];
    $correoElectronico = $_POST["correoElectronico"];
    $numeroTarjeta = $_POST["numeroTarjeta"];
    $direccion = $_POST["Direccion"];
    
    // Verificar si la variable de sesión $_SESSION['juegos'] está definida y no es nula
    if (isset($_SESSION['juegos']) && is_array($_SESSION['juegos'])) {
        // Convertir el array de juegos en una cadena separada por comas
        $resumenPedido = implode(', ', $_SESSION['juegos']);
    } else {
        // Si $_SESSION['juegos'] no está definida o es nula, asignar una cadena vacía
        $resumenPedido = '';
    }

    // Datos de conexión a la base de datos
    $servername = "localhost";
    $username = "root"; 
    $password = "1234"; 
    $database = "proyectodaw"; 
    
    // Crear conexión 
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Preparar la consulta SQL 
    $sql = "INSERT INTO pedido (nombre, apellidos, correoElectronico, numeroTarjeta, direccion, resumenPedido)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Preparar la declaración
    $declaracion = $conn->prepare($sql);

    // Enlazar los parámetros y ejecutar la declaración
    $declaracion->bind_param("ssssss", $nombre, $apellidos, $correoElectronico, $numeroTarjeta, $direccion, $resumenPedido);
    if ($declaracion->execute()) {
        echo '<div class="mensaje-exito">Pago Realizado Exitosamente</div>';
        echo "<link rel='stylesheet' type='text/css' href='http://localhost/proyectodaw/style.css'>";
        echo '<a href="http://localhost/proyectodaw/index.html">';
        echo '<img src="Imagenes/Logo.png" alt="Ir a la página principal">';
        echo '</a>';
    } else {
        echo "Error al crear el registro: " . $conn->error;
    }

    // Cerrar declaración y conexión
    $declaracion->close();
    $conn->close();
}

// Función para limpiar datos
function limpiarDatos($datos) {
    // Eliminar espacios en blanco al principio y al final
    $datos = trim($datos);
    // Eliminar barras invertidas
    $datos = stripslashes($datos);
    // Convertir caracteres especiales a entidades HTML
    $datos = htmlspecialchars($datos);
    return $datos;
}
?>


