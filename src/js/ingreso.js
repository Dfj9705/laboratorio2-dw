const formulario = document.querySelector('form')


const guardarProveedor = async (e) => {
    e.preventDefault();

    formulario.querySelectorAll('input').forEach(input => {
        if (input.value.trim() == '') {
            input.focus()
            return
        }
    })


    try {
        const body = new FormData(formulario)
        body.append('accion', 'guardar')
        const respuesta = await fetch('API/proveedor.php', {
            method: 'POST',
            body
        })
        const data = await respuesta.json();
        const { codigo, mensaje } = data;

        alert(mensaje);
        if (codigo == 1) {
            formulario.reset();
        }

        console.log(data);
    } catch (error) {
        console.log(error);
    }
}

const soloNumeros = e => {
    const charCode = e.which ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
    }
}

formulario.addEventListener('submit', guardarProveedor)
formulario.Telefono.addEventListener('keypress', soloNumeros)