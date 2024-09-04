<?php require_once 'includes/auth.php' ?>
<?php include_once 'includes/header.php' ?>

<h1>Listado de todos lo proveedores</h1>
<p>Usuario: <?= $_SESSION['username']?></p>
<table>
    <thead>
        <tr>
            <th>NIT</th>
            <th>NOMBRE</th>
            <th>DIRECCIÓN</th>
            <th>TELÉFONO</th>
            <th>ACTIVO/INACTIVO</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<script src="src/js/listado.js"></script>
<?php include_once 'includes/footer.php' ?>