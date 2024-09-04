<?php


session_start();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {

    $_SESSION = [];

    session_destroy();

    header('WWW-Authenticate: Basic realm="Contenido Protegido"');
    header('HTTP/1.0 401 Unauthorized');


    $mensaje = "Sesión cerrada correctamente.";

} else {
    $mensaje = "No hay una sesión activa.";

}

?>
<?php include_once 'includes/header.php' ?>
<h1><?= $mensaje ?></h1>
<a href='index.php'>Volver a inicio</a>

<?php include_once 'includes/footer.php' ?>