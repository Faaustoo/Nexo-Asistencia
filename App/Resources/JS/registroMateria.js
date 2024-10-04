const url = new URLSearchParams(window.location.search);
const institucionId = url.get('id');

document.getElementById('crear-materia').addEventListener('click', function () {
    const formulario = document.getElementById('formularioMateria');
    const formularioEliminar = document.getElementById('formularioEliminarMateria');
    formularioEliminar.style.display = 'none'; 
    formulario.style.display = 'block'; 
    document.getElementById('nombre_materia').value = '';
    document.getElementById('descripcion_materia').value = '';
    document.getElementById('resultado').innerHTML = ''; 
    document.getElementById('error').innerHTML = ''; 
});

document.getElementById('eliminar-materia').addEventListener('click', function () {
    const formulario = document.getElementById('formularioMateria');
    const formularioEliminar = document.getElementById('formularioEliminarMateria');
    formularioEliminar.style.display = 'block'; 
    formulario.style.display = 'none'; 
});

document.getElementById('cerrar-materia').addEventListener('click', function () {
    console.log('click');
    const formularioMateria=document.getElementById('formularioMateria');
    formularioMateria.style.display='none';
    document.getElementById('resultado-eliminar').innerHTML = ''; 
    document.getElementById('error-eliminar').innerHTML = ''; 
});

document.getElementById('cerrar-eliminar').addEventListener('click', function () {
    console.log('click');
    formularioMateria=document.getElementById('formularioMateria');
    const formularioEliminar = document.getElementById('formularioEliminarMateria');
    formularioMateria.style.display='none';
    formularioEliminar.style.display = 'none'; 
    document.getElementById('nombre_materia_eliminar').value = ''; 
    document.getElementById('resultado-eliminar').innerHTML = ''; 
    document.getElementById('error-eliminar').innerHTML = ''; 
});

let formularioMateria =document.getElementById('formDatosMateria');
formularioMateria.addEventListener('submit', function (e) {
    e.preventDefault();
    const datos = new FormData(formularioMateria); 
    datos.append('id_institucion', institucionId);
    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';

    fetch('registroMateria.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.estado === 'exito') {
            document.getElementById('resultado').innerHTML = data.mensaje;
        } else if (data.estado === 'error') {
            if (data.errores) {
                data.errores.forEach(error => {
                    document.getElementById('error').innerHTML += error + '<br>';
                });
            } else {
                document.getElementById('error').innerHTML = data.mensaje;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error').innerHTML = 'Error al usar fetch: ' + error;
    });
});
let formularioElimiarMateria =document.getElementById('formDatosEliminarMateria');
formularioElimiarMateria.addEventListener('submit', function (e) {
    e.preventDefault();
    let datos = new FormData(formularioElimiarMateria); 

    fetch('eliminarMateria.php', { 
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
            if (data.errores) {
                data.errores.forEach(error => {
                    document.getElementById('error-eliminar').innerHTML += error + '<br>'; 
                });
            } else {
                document.getElementById('error-eliminar').innerHTML = data.mensaje;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-eliminar').innerHTML = 'Error al usar fetch: ' + error;
    });
});

function cargarMaterias() {
    const datos = new FormData();
    datos.append('id_institucion', institucionId);

    fetch('obtenerMaterias.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        const listaMaterias = document.getElementById('lista-materias');
        if (listaMaterias) {
            listaMaterias.innerHTML = '';
            if (data.estado === 'exito') {
                if (Array.isArray(data.materias)) {
                    data.materias.forEach(materia => {
                        listaMaterias.innerHTML += `
                        <div style="margin: 5px 0;">
                        <a href="tercerPagina.html?id=${materia.id_materia}" style="display: block; margin: 5px 0;" class="materia-link">
                        ${materia.nombre}</a></div>
                        `;
                    });
                } else {
                    listaMaterias.innerHTML = '<p>No hay materias disponibles.</p>';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error al obtener materias:', error);
    });
}

document.addEventListener('DOMContentLoaded', cargarMaterias);
