document.addEventListener('DOMContentLoaded', function () {

    const listaAlumnos = document.getElementById('lista-alumnos');
    const listaAlumnosDiv = document.getElementById('Listalumnos');
    const crearAlumno = document.getElementById('crear-alumno');
    const formularioAlumnoDiv = document.getElementById('formularioAlumno'); 
    const cerrarAlumno = document.getElementById('cerrar-alumno');

    const formularioEditar=document.getElementById('formularioeditarAlumno');
    const botonCerrarEditar= document.getElementById('cerrar-alumno-editar');
    const botonEnviarEditar= document.getElementById('enviar-alumno-editar');

    const formularioEliminar= document.getElementById('formularioAlumnoEliminar');
    const botonCerrarEliminar= document.getElementById('cerrar-alumno-eliminar');
    const botonEnviarEliminar= document.getElementById('enviar-alumno-eliminar');

    const asistenciaAlumnos= document.getElementById('asistencia-Alumnos');
    const condicionAlumnos= document.getElementById('condicion-Alumnos');
    
    

    listaAlumnos.addEventListener('click', function () {
    listaAlumnosDiv.style.display = 'block';
    formularioAlumnoDiv.style.display = 'none';
    asistenciaAlumnos.style.display = 'none'; 
    condicionAlumnos.style.display = 'none';
    cargarAlumnos();
    });

    
    crearAlumno.addEventListener('click', function () {
        listaAlumnosDiv.style.display = 'none';
        formularioAlumnoDiv.style.display = 'block'; 
        asistenciaAlumnos.style.display = 'none';
        condicionAlumnos.style.display = 'none';
        document.getElementById('resultado').innerHTML=' ';
        document.getElementById('error').innerHTML=' ';
    });

    
    cerrarAlumno.addEventListener('click', function () {
        listaAlumnosDiv.style.display = 'block';
        formularioAlumnoDiv.style.display = 'none'; 
        asistenciaAlumnos.style.display = 'none';
        condicionAlumnos.style.display = 'none';
        limpiarFormulario(formulario); 
        document.getElementById('resultado').innerHTML = ' ';
        document.getElementById('error').innerHTML = ' ';
       });
    


    let formulario = document.getElementById('formDatosAlumno');
    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); 
        const urlParams = new URLSearchParams(window.location.search);
        const idMateria = urlParams.get('id'); 
        let datos = new FormData(formulario); 
        datos.append('id_materia', idMateria); 

        document.getElementById('resultado').innerHTML = ''; 
        document.getElementById('error').innerHTML = ''; 
        
        fetch('registroAlumno.php', { 
            method: 'POST', 
            body: datos 
        })
        .then(res => res.json()) 
        .then(data => {
            console.log(data);
            // Manejo de la respuesta
            if (data.estado === 'exito') {
                document.getElementById('resultado').innerHTML = data.mensaje; 
            } else if (data.estado === 'error') {
                if (data.errores && Array.isArray(data.errores)) {
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
    

function cargarAlumnos() {
    const url = new URLSearchParams(window.location.search);
    const idMateria = url.get('id'); 
    const datos = new FormData();
    datos.append('id_materia', idMateria);

    fetch('obtenerAlumnos.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.estado === 'exito') {
            const listaAlumnos = document.getElementById('lista-Alumnos');
            listaAlumnos.innerHTML = ''; 
            
            if (data.alumnos.length > 0) {
                let tablaHTML = `
                    <table class="tabla-alumnos">
                    <thead>
                        <tr>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Fecha de nacimiento</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                `;

                data.alumnos.forEach(alumno => {
                    tablaHTML += `
                        <tr>
                            <td>${alumno.apellido}</td>
                            <td>${alumno.nombre}</td>
                            <td>${alumno.dni}</td>
                            <td>${alumno.email}</td>
                            <td>${alumno.fecha_nacimiento}</td>
                            <td>
                                <button class="editar-btn" data-id="${alumno.id_alumno}">Editar</button>
                                <button class="eliminar-btn" data-id="${alumno.id_alumno}">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });

                tablaHTML += `
                        </tbody>
                    </table>
                `;

                listaAlumnos.innerHTML = tablaHTML;


                document.querySelectorAll('.editar-btn').forEach(btn => {
                    btn.addEventListener('click', (event) => {
                        const alumnoId = event.target.getAttribute('data-id');
                        editarAlumno(alumnoId);
                    });
                });

                document.querySelectorAll('.eliminar-btn').forEach(btn => {
                    btn.addEventListener('click', (event) => {
                        const alumnoId = event.target.getAttribute('data-id');
                        eliminarAlumno(alumnoId)
                    });
                });
            } else {
                listaAlumnos.innerHTML = '<p>No hay alumnos disponibles.</p>';
            }
        } else {
            alert(data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error al obtener alumnos:', error);
    });
}
    



function editarAlumno(alumnoId) {
    formularioEditar.style.display = 'block';
    listaAlumnosDiv.style.display = 'none';

    limpiarFormulario(formularioEditar);

    const url = new URLSearchParams(window.location.search);
    const idMateria = url.get('id');

    // Limpiar mensajes de error anteriores
    document.getElementById('error-editar').innerHTML = '';
    document.getElementById('resultado-editar').innerHTML = '';

    // Eliminar el listener anterior si ya existe
    botonCerrarEditar.removeEventListener('click', cerrarFormulario);

    // Agregar el nuevo listener
    botonCerrarEditar.addEventListener('click', cerrarFormulario);

    function cerrarFormulario() {
        formularioEditar.style.display = 'none';
        listaAlumnosDiv.style.display = 'block';
    }

    // Código para el envío del formulario (sin cambios)
    botonEnviarEditar.addEventListener('click', (event) => {
        event.preventDefault();
        const datos = new FormData(formDatosEditarAlumno);
        datos.append('id_alumno', alumnoId);
        datos.append('id_materia', idMateria);

        fetch('editarAlumno.php', {
            method: 'POST',
            body: datos
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            document.getElementById('resultado-editar').innerHTML = '';
            document.getElementById('error-editar').innerHTML = '';
            if (data.estado === 'exito') {
                document.getElementById('resultado-editar').innerHTML = data.mensaje;
            } else if (data.estado === 'error') {
                if (data.errores) {
                    document.getElementById('error-editar').innerHTML = data.errores.join('<br>');
                } 
            }
        })
        .catch(error => {
            console.error('Error al editar el alumno:', error);
        });
    });
}

    
function eliminarAlumno(alumnoId) {
        formularioEliminar.style.display = 'block';
        listaAlumnosDiv.style.display = 'none';
    
        document.getElementById('error-eliminar').innerHTML = '';
        document.getElementById('resultado-eliminar').innerHTML = '';
    
        document.getElementById('si').addEventListener('click', (event) => {
            event.preventDefault();
    
            const datos = new FormData();
            datos.append('id_alumno', alumnoId);
    
            fetch('eliminarAlumno.php', {
                method: 'POST',
                body: datos
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                document.getElementById('resultado-eliminar').innerHTML = '';
                document.getElementById('error-eliminar').innerHTML = '';
    
                if (data.estado === 'exito') {
                    document.getElementById('resultado-eliminar').innerHTML = data.mensaje;
                } else if (data.estado === 'error' && data.errores) {
                    document.getElementById('error-eliminar').innerHTML = data.errores.join('<br>');
                }
            })
            .catch(error => {
                console.error('Error al eliminar el alumno:', error);
            });
        });
    
        document.getElementById('no').addEventListener('click', () => {
            formularioEliminar.style.display = 'none'; 
            listaAlumnosDiv.style.display = 'block'; 
        });
    
        botonCerrarEliminar.addEventListener('click', () => {
            formularioEliminar.style.display = 'none';
            listaAlumnosDiv.style.display = 'block';
        });
}
    

function limpiarFormulario(formulario) {
    const inputs = formulario.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = ''; 
    });
}


});
