<?php

session_start();

include ('conexion_bbdd.php');

if(isset($_POST['usuario']) && isset($_POST['contraseña'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $usuario = validate($_POST['usuario']);
    $contraseña = validate($_POST['contraseña']);

    if (empty($usuario)){
        header("Location:registro-usuario.html?error=El Usuario es Requerido");
        exit();
    } elseif (empty($contraseña)){
        header("Location:registro-usuario.html?error=La contraseña es Requerida");
        exit();
    } else {
        // Hash de la contraseña proporcionada por el usuario
        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        $Sql ="SELECT * FROM usuario WHERE nombre_usuario = '$usuario'";
        $result = mysqli_query($conexion, $Sql);

        if ($result && mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);

            // Verificar la contraseña utilizando password_verify
            if(password_verify($contraseña, $row['contraseña'])) {
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['id'] = $row['id'];
                header("Location: index.html ");
                exit();
            } else {
                header("Location: registro-usuario.html?error= El usuario o la contraseña son incorrectos");
                exit();
            }
        } else {
            header("Location: registro-usuario.html?error= El usuario o la contraseña son incorrectos");
            exit();
        }
    }
} else {
    header("Location: registro-usuario.html");
    exit();
}
?>

