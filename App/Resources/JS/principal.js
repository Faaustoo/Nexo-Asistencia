document.getElementById('crear-institucion').addEventListener('click', function() {
    const formulario = document.getElementById('formularioInstitucion');
    formulario.style.display = 'block'; 
});

document.getElementById('cerrar-institucion').addEventListener('click', function() {
    const formulario = document.getElementById('formularioInstitucion');
    formulario.style.display = 'none';
    document.getElementById('nombre_institucion').value = '';
    document.getElementById('direccion_institucion').value = '';
    document.getElementById('cue_institucion').value = ''; 
    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';
});

let formulario = document.getElementById('formDatosInstitucion');
formulario.addEventListener('submit', function(e) {
    e.preventDefault(); 
    let datos = new FormData(formulario);

    fetch('registroInstitucion.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        document.getElementById('resultado').innerHTML = '';
        document.getElementById('error').innerHTML = '';

        if (data.estado === 'exito') {
            document.getElementById('resultado').innerHTML = data.mensaje; 
        } else if (data.estado === 'error') {
            data.errores.forEach(error => {
                document.getElementById('error').innerHTML += error + '<br>'; 
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error').innerHTML = 'Error al usar fetch: ' + error;
    });
});


function cargarInstituciones() {
    fetch('obtenerInstituciones.php') 
        .then(res => res.json())
        .then(data => {
            const listaInstituciones = document.getElementById('lista-instituciones');
            listaInstituciones.innerHTML = ''; 

            if (data.estado === 'exito') {
                data.instituciones.forEach(institucion => {
                    listaInstituciones.innerHTML += `
                        <a href="paginaSecundaria.html?id=${institucion.id_institucion}" style="display: block; margin: 5px 0;">
                            ${institucion.nombre}
                        </a>
                    `;
                });
            } else {
                listaInstituciones.innerHTML = `<p>${data.mensaje}</p>`;
            }
        })
        .catch(error => {
            console.error('Error al cargar instituciones:', error);
            document.getElementById('lista-instituciones').innerHTML = '<p>Error al cargar instituciones.</p>';
        });
}

document.addEventListener('DOMContentLoaded', cargarInstituciones);
