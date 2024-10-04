document.getElementById('crear-institucion').addEventListener('click', function() {
    const formularioCrear = document.getElementById('formularioCrearInstitucion');
    formularioCrear.style.display = 'block';
    document.getElementById('formularioEliminarInstitucion').style.display = 'none'; 
});

document.getElementById('eliminar-institucion').addEventListener('click', function() {
    const formularioEliminar = document.getElementById('formularioEliminarInstitucion');
    formularioEliminar.style.display = 'block';
    document.getElementById('formularioCrearInstitucion').style.display = 'none'; 
});

document.getElementById('cerrar-institucion').addEventListener('click', function() {
    const formularioCrear = document.getElementById('formularioCrearInstitucion');
    formularioCrear.style.display = 'none';
    document.getElementById('nombre_institucion').value = '';
    document.getElementById('direccion_institucion').value = '';
    document.getElementById('cue_institucion').value = ''; 
    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';
});

document.getElementById('cerrar-eliminar-institucion').addEventListener('click', function() {
    const formularioEliminar = document.getElementById('formularioEliminarInstitucion');
    formularioEliminar.style.display = 'none';
    document.getElementById('nombre_eliminar').value = '';
    document.getElementById('resultado-eliminar').innerHTML = '';
    document.getElementById('error-eliminar').innerHTML = '';
});

let formularioCrear = document.getElementById('formDatosInstitucion');
formularioCrear.addEventListener('submit', function(e) {
    e.preventDefault(); 
    let datos = new FormData(formularioCrear);

    fetch('registroInstitucion.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('resultado').innerHTML = '';
        document.getElementById('error').innerHTML = '';

        if (data.estado === 'exito') {
            document.getElementById('resultado').innerHTML = data.mensaje; 
        } else if (data.estado === 'error') {
            data.errores.forEach(error => {
                document.getElementById('error').innerHTML += error + '<br>'; 
            });
        }
    }).catch(error => {
        console.error('Error:', error);
        document.getElementById('error').innerHTML = 'Error al usar fetch: ' + error;
    });
});

let formularioEliminar = document.getElementById('formDatosEliminarInstitucion');
formularioEliminar.addEventListener('submit', function(e) {
    e.preventDefault(); 
    let datos = new FormData(formularioEliminar);

    fetch('eliminarInstitucion.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('resultado-eliminar').innerHTML = '';
        document.getElementById('error-eliminar').innerHTML = '';
    
        if (data.estado === 'exito') {
            document.getElementById('resultado-eliminar').innerHTML = data.mensaje; 
        } else if (data.estado === 'error') {
            data.errores.forEach(error => {
                document.getElementById('error-eliminar').innerHTML += error + '<br>'; 
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-eliminar').innerHTML = 'Error al usar fetch: ' + error;
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
            ${institucion.nombre}</a>
            `;});
        } else {
            listaInstituciones.innerHTML = `<p>${data.mensaje}</p>`;
        }
    }).catch(error => {
        console.error('Error al cargar instituciones:', error);
    });
}

document.addEventListener('DOMContentLoaded', cargarInstituciones);
