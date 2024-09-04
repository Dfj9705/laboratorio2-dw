<?php
// Iniciar la sesión
session_start();

// Datos de conexión a la base de datos
$host = 'localhost';
$usuario_db = 'desarrollo_web';
$password_db = 'desarrollo';
$nombre_bd = 'desarrollo_web';

// Crear una conexión a la base de datos con MySQLi
$conexion = new mysqli($host, $usuario_db, $password_db, $nombre_bd);

// Verificar si hay algún error en la conexión
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Verificar si ya existe una sesión de autenticación
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Si no se han enviado las credenciales o son incorrectas, pedir autenticación
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        // Enviar el encabezado WWW-Authenticate para solicitar las credenciales
        header('WWW-Authenticate: Basic realm="Contenido Protegido"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Las credenciales son requeridas para acceder a este contenido.';
        exit;
    }

    // Obtener las credenciales proporcionadas
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    // Preparar la consulta SQL para buscar al usuario en la base de datos
    $stmt = $conexion->prepare("SELECT pswd FROM userauth WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();


    // Verificar si el usuario existe en la base de datos
    if ($stmt->num_rows > 0) {
        // Obtener la contraseña hasheada desde la base de datos
        $stmt->bind_result($hash);
        $stmt->fetch();


        // Verificar si la contraseña es correcta usando password_verify
        if (md5($password) == $hash) {
            // Si la contraseña es correcta, establecer la sesión
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
        } else {
            // Si la contraseña es incorrecta, volver a pedir las credenciales
            header('WWW-Authenticate: Basic realm="Contenido Protegido"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Credenciales incorrectas.';
            exit;
        }
    } else {
        // Si el usuario no existe, volver a pedir las credenciales
        header('WWW-Authenticate: Basic realm="Contenido Protegido"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Credenciales incorrectas.';
        exit;
    }

    $stmt->close();
}

// var_dump($_SESSION);
// Cerrar la conexión a la base de datos
$conexion->close();
