const tabla = document.querySelector('table')


const buscar = async () => {


    try {
        const respuesta = await fetch('API/proveedor.php', {
            method: 'GET'
        })
        const data = await respuesta.json();
        const { codigo, mensaje, datos } = data;

        const fragment = document.createDocumentFragment();
        tabla.tBodies[0].innerHTML = ''
        if (codigo == 1) {

            datos.forEach(prov => {
                const tr = document.createElement('tr');
                const tdNit = document.createElement('td');
                const tdNombre = document.createElement('td');
                const tdDireccion = document.createElement('td');
                const tdTelefono = document.createElement('td');
                const tdActivo = document.createElement('td');
                const checkBox = document.createElement('input')
                checkBox.type = "checkBox"

                checkBox.checked = prov.Activo == 1

                checkBox.addEventListener('change', (e) => {
                    e.preventDefault()
                    activar(prov.NIT, prov.Activo)

                })

                tdNit.textContent = prov.NIT
                tdNombre.textContent = prov.NombreCompleto
                tdDireccion.textContent = prov.Direccion
                tdTelefono.textContent = prov.Telefono
                tdActivo.appendChild(checkBox)
                tr.appendChild(tdNit)
                tr.appendChild(tdNombre)
                tr.appendChild(tdDireccion)
                tr.appendChild(tdTelefono)
                tr.appendChild(tdActivo)
                fragment.appendChild(tr)
            })


        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 5
            td.textContent = "No se encontraron datos"
            tr.appendChild(td)
            fragment.appendChild(tr)
            alert(mensaje)
        }

        tabla.tBodies[0].appendChild(fragment)
        console.log(data);
    } catch (error) {
        console.log(error);
    }
}

const activar = async (NIT, Activo) => {
    try {
        const body = new FormData()
        body.append('NIT', NIT)
        body.append('Activo', Activo)
        body.append('accion', 'activar')
        const respuesta = await fetch('API/proveedor.php', {
            method: 'POST',
            body
        })
        const data = await respuesta.json();
        const { codigo, mensaje } = data;

        alert(mensaje);
        if (codigo == 1) {
            buscar();
        }

        console.log(data);
    } catch (error) {
        console.log(error);
    }
}

buscar();