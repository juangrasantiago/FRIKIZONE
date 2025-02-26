<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: registro-usuario.html");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Usuario de MySQL
$password = "1234"; // Contraseña de MySQL
$database = "proyectodaw"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el nombre de usuario de la sesión
$usuario = $_SESSION['usuario'];

// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mostrar los datos recibidos del formulario para depurar
    var_dump($_POST);

    // Actualizar los registros en la base de datos
    foreach ($_POST as $key => $value) {
        // Prevenir inyección SQL 
        $value = $conn->real_escape_string($value);
        // Actualizar la base de datos con los nuevos valores
        $sql = "UPDATE usuarios SET $key = '$value' WHERE nombre_usuario = '$usuario'";
        if ($conn->query($sql) !== TRUE) {
            echo "Error al actualizar el registro '$key' a '$value': " . $conn->error;
            exit(); // Detiene la ejecución del script en caso de error
        }
    }
    
    // Mostrar mensaje de confirmación
    echo "¡Los registros se actualizaron correctamente!";
    exit();
}

$conn->close();
?>

