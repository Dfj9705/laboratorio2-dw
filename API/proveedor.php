<?php
header('Content-Type: application/json; charset=utf-8');
require '../classes/Conexion.php';


$conexionObj = new Conexion();
$conexion = $conexionObj->getConexion();


$metodo = $_SERVER['REQUEST_METHOD'];
$accion = $_REQUEST['accion'] ?? 'default';



switch ($metodo) {
    case 'GET':
        $sql = "SELECT * FROM proveedor";

        $stm = $conexion->prepare($sql);
        if ($stm === false) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => $conexion->error
            ]);
            exit;
        }
        $stm->execute();

        $resultado = $stm->get_result();
        if ($resultado->num_rows > 0) {
            $data = [];


            while ($fila = $resultado->fetch_assoc()) {
                $data[] = $fila;
            }

            echo json_encode([
                'codigo' => 1,
                'mensaje' => count($data) . " proveedor/es encontrados",
                'datos' => $data
            ]);
        } else {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => "No se encontraron resultados"
            ]);
        }
        $stm->close();
        break;

    case 'POST':
        if ($accion == 'guardar') {

            $_POST['NIT'] = htmlspecialchars($_POST['NIT']);
            $_POST['NombreCompleto'] = htmlspecialchars($_POST['NombreCompleto']);
            $_POST['Direccion'] = htmlspecialchars($_POST['Direccion']);
            $_POST['Telefono'] = filter_var($_POST['Telefono'], FILTER_SANITIZE_NUMBER_INT);

            if ($_POST['NIT'] == '' || $_POST['NombreCompleto'] == '' || $_POST['Direccion'] == '' || $_POST['Telefono'] == '') {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => "Debe llenar todos los campos"
                ]);
                exit;
            }

            $sql = "INSERT INTO proveedor (NIT, NombreCompleto, Direccion, Telefono) values (?, ?, ?, ? )";

            $stm = $conexion->prepare($sql);
            if ($stm === false) {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => $conexion->error
                ]);
                exit;
            }
            $stm->bind_param('ssss', $_POST['NIT'], $_POST['NombreCompleto'], $_POST['Direccion'], $_POST['Telefono']);

            $resultado = $stm->execute();


            if ($resultado) {
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => "Proveedor ingresado correctamente"
                ]);
            } else {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => $stm->error
                ]);
            }

            $stm->close();
        } else if ($accion == 'activar') {
            $_POST['NIT'] = htmlspecialchars($_POST['NIT']);
            $_POST['Activo'] = (int)filter_var($_POST['Activo'], FILTER_SANITIZE_NUMBER_INT);

            if ($_POST['NIT'] == '') {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => "Faltan campos"
                ]);
                exit;
            }
            $activo =  $_POST['Activo'] == 1 ? 0 : 1;
            $sql = "UPDATE proveedor set Activo = ? where NIT = ?";

            $stm = $conexion->prepare($sql);
            if ($stm === false) {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => $conexion->error
                ]);
                exit;
            }
            $stm->bind_param('is', $activo, $_POST['NIT']);

            $resultado = $stm->execute();
            $activado = $activo == 1 ? "activado" : "desactivado";
            $mensaje = "Proveedor " . $activado . " correctamente";
            if ($resultado) {
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => $mensaje
                ]);
            } else {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => $stm->error
                ]);
            }

            $stm->close();
        }



        break;
}
$conexion->close();
exit;
