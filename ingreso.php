<?php include_once 'includes/header.php' ?>
<h1>Formulario de ingreso de proveedores</h1>
<section class="section-index">
    <form>
        <div class="input-box">
            <label for="NIT">N.I.T</label>
            <input type="text" name="NIT" id="NIT" required>
        </div>
        <div class="input-box">
            <label for="NombreCompleto">Nombre completo</label>
            <input type="text" name="NombreCompleto" id="NombreCompleto" required>
        </div>
        <div class="input-box">
            <label for="Direccion">Dirección</label>
            <input type="text" name="Direccion" id="Direccion" required>
        </div>
        <div class="input-box">
            <label for="Telefono">Teléfono</label>
            <input type="tel" name="Telefono" id="Telefono" required>
        </div>

        <div class="input-box">
            <button class="primary">Guardar</button>
        </div>
    </form>
</section>
<script src="src/js/ingreso.js"></script>
<?php include_once 'includes/footer.php' ?>