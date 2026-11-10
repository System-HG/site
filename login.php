<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Sistema de Cobros de Agua</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="fondo-login">
    <div class="contenedor-login">
        <h2>💧 Sistema de Cobros de Agua</h2>
        <?php
        session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            require "config/bd.php";
            $usuario = $_POST['usuario'];
            $clave = $_POST['contrasena'];
            
            $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?");
            $stmt->bind_param("ss", $usuario, $clave);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows === 1) {
                $fila = $resultado->fetch_assoc();
                $_SESSION['usuario'] = $fila['usuario'];
                $_SESSION['nombre'] = $fila['nombre_completo'];
                $_SESSION['rol'] = $fila['rol'];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "<p class='error'>Usuario o contraseña incorrectos</p>";
            }
            $stmt->close();
        }
        ?>
        <form method="POST">
            <div class="campo">
                <label>Usuario:</label>
                <input type="text" name="usuario" required>
            </div>
            <div class="campo">
                <label>Contraseña:</label>
                <input type="password" name="contrasena" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>