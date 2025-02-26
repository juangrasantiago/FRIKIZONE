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

// Consultar la base de datos para obtener todos los datos del usuario
$sql = "SELECT * FROM usuarios WHERE nombre_usuario='$usuario'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="http://localhost/proyectodaW/style.css"> 
</head>
<body>

<?php
if ($result->num_rows > 0) {
    // Mostrar los datos del usuario en una tabla editable
    echo "<h1>Datos del Usuario</h1>";
    echo "<div class='tabla-perfil'>";
    echo "<form id='datosUsuarioForm' action='guardar_cambios.php' method='post'>";
    echo "<table border='1'>";
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            if ($key != 'id') { // Ignorar la columna 'id'
                echo "<tr>";
                echo "<th>" . ucfirst(str_replace("_", " ", $key)) . "</th>";
                echo "<td contenteditable='true' data-field='$key'>$value</td>"; // Hacer las celdas editables
                echo "</tr>";
            }
        }
    }
    echo "</table>";
    echo "<input type='submit' value='Guardar Cambios'>";
    echo "</form>";
    echo "</div>";
} else {
    echo "No se encontraron datos del usuario.";
}

$conn->close();
?>

<script>
    document.getElementById('datosUsuarioForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe automáticamente

        // Obtener todas las celdas editables
        var cells = document.querySelectorAll('#datosUsuarioForm td[contenteditable=true]');

        // Crear un objeto FormData para enviar los datos del formulario
        var formData = new FormData();

        // Iterar sobre las celdas editables y agregar sus valores al objeto FormData
        cells.forEach(function(cell) {
            formData.append(cell.dataset.field, cell.textContent);
        });

        // Enviar los datos del formulario al archivo guardar_cambios.php mediante una solicitud POST
        fetch('guardar_cambios.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Hubo un problema al actualizar los datos.');
            }
            return response.text();
        })
        .then(function(message) {
            console.log(message); // Muestra el mensaje de confirmación en la consola
            alert(message); // Muestra el mensaje de confirmación al usuario
        })
        .catch(function(error) {
            console.error('Error:', error);
            alert('Hubo un error al actualizar los datos. Por favor, inténtalo de nuevo.');
        });
    });
</script>

</body>
</html>




