<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
if (isset($_POST['regitro'])){
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $direccion = $_POST['direccion'];

    // Insertar datos en la tabla
    $sql = "INSERT INTO usuarios (nombre, apellidos, nombre_usuario, contraseña, direccion) VALUES ('$nombre', '$apellidos', '$usuario', '$contraseña', '$direccion')";

    if ($conn->query($sql) === TRUE) {
        echo "<link rel='stylesheet' type='text/css' href='http://localhost/proyectodaw/style.css'>"; // Enlace a CSS
            echo "<div class='mensaje-exito'>";
            echo "<p class='registro-texto'>Registro exitoso</p>";
            echo "<a href='registro-usuario.html' class='username'>Iniciar Sesión</a>";
            echo "</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
 }else{
        // Recibir datos del formulario para inicio de sesión
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['password'];

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario='$usuario' AND contraseña='$contraseña'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['usuario'] = $usuario;
        header("Location: index.html?login=success&user=$usuario"); // Redirigir a la página principal con un mensaje de éxito y el nombre de usuario
        exit();
    } else {
        // Inicio de sesión fallido
        header("Location: registro-usuario.html?error=Usuario o contraseña incorrectos"); // Redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
        exit();
    }
 }

 $conn->close();


}

?>