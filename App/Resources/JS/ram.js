document.addEventListener('DOMContentLoaded', function() {
    const url = new URLSearchParams(window.location.search);
    const institucionId = url.get('id');

    cargarDatosRam(institucionId);
});

function cargarDatosRam(institucionId) {
    const datos = new FormData();
    datos.append('id_institucion', institucionId);

    fetch('obtenerDatosRam.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        const divRam = document.getElementById('ram');
        divRam.innerHTML = ''; 
        
        if (data.estado === 'exito') {
            const ram = data.datos;
            const tablaHTML = `
                <table class="tabla-ram">
                    <thead>
                        <tr>
                            <th>Porcentaje Promoción</th>
                            <th>Porcentaje Regular</th>
                            <th>Nota Promoción</th>
                            <th>Nota Regular</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${ram.porcentaje_promocion}%</td>
                            <td>${ram.porcentaje_regular}%</td>
                            <td>${ram.nota_promocion}</td>
                            <td>${ram.nota_regular}</td>
                            <td><button class="editar-btn-ram" id="editar-ram">Editar</button></td>

                        </tr>
                    </tbody>
                </table>
            `;

            divRam.innerHTML = tablaHTML;


            const botonEditar = document.getElementById('editar-ram');
            botonEditar.addEventListener('click', () => {
                document.getElementById('porcentaje_promocion').value =ram.porcentaje_promocion;
                document.getElementById('porcentaje_regular').value = ram.porcentaje_regular;
                document.getElementById('nota_promocion').value = ram.nota_promocion;
                document.getElementById('nota_regular').value =ram.nota_regular;

                document.getElementById('formularioEditarRam').style.display = "block";
                divRam.style.display = "none";

                document.getElementById('formDatosRam').onsubmit = (e) => {
                    e.preventDefault();
                    guardarCambios(institucionId);
                };
            });
        } else {
            divRam.innerHTML = `<p>${data.mensaje}</p>`;
        }
    })
    .catch(error => console.error('Error al cargar datos de RAM:', error));
}

function guardarCambios(institucionId) {
    const form = document.getElementById('formDatosRam');
    const datos = new FormData(form);
    datos.append('id_institucion', institucionId);


    fetch('editarRam.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        const resultadoEditar = document.getElementById('resultado-editar');
        const errorEditar = document.getElementById('error-editar');

        resultadoEditar.innerHTML = '';
        errorEditar.innerHTML = '';

        if (data.estado === 'exito') {
            resultadoEditar.innerHTML = data.mensaje; 
            cargarDatosRam(institucionId);
            document.getElementById('formularioEditarRam').style.display = "none";
            document.getElementById('ram').style.display = "block"; 
        } else if (data.estado === 'error') {
            errorEditar.innerHTML = data.mensaje; 
            if (data.errores && data.errores.length > 0) {
                data.errores.forEach(error => {
                    errorEditar.innerHTML += error + '<br>'; 
                });
            }
        }
    })
    .catch(error => console.error('Error al guardar cambios:', error));
}


// Cerrar el formulario sin guardar
document.getElementById('cerrar-editar').addEventListener('click', () => {
    document.getElementById('formularioEditarRam').style.display = "none";
    document.getElementById('ram').style.display = "block"; 
});
