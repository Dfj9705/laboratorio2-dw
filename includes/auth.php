<?php

session_start();


$host = 'localhost';
$usuario_db = 'desarrollo_web';
$password_db = 'desarrollo';
$nombre_bd = 'desarrollo_web';


$conexion = new mysqli($host, $usuario_db, $password_db, $nombre_bd);


if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}


if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {

        header('WWW-Authenticate: Basic realm="Contenido Protegido"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Las credenciales son requeridas para acceder a este contenido.';
        exit;
    }


    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];


    $stmt = $conexion->prepare("SELECT pswd FROM userauth WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();



    if ($stmt->num_rows > 0) {

        $stmt->bind_result($hash);
        $stmt->fetch();



        if (md5($password) == $hash) {

            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
        } else {

            header('WWW-Authenticate: Basic realm="Contenido Protegido"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Credenciales incorrectas.';
            exit;
        }
    } else {

        header('WWW-Authenticate: Basic realm="Contenido Protegido"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Credenciales incorrectas.';
        exit;
    }

    $stmt->close();
}

$conexion->close();
