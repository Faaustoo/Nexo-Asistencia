document.addEventListener('DOMContentLoaded', function () {
    const listaAlumnos = document.getElementById('lista-alumnos');
    const asistencia = document.getElementById('asistencia-alumno');
    const condicion = document.getElementById('condicion-alumno');
    const listaAlumnosDiv = document.getElementById('Listalumnos');
    const asistenciaDiv = document.getElementById('asistencia-Alumnos');
    const condicionAlumnosDiv = document.getElementById('condicion-Alumnos');
    const crearAlumno = document.getElementById('crear-alumno'); 
    const formularioAlumnoDiv = document.getElementById('formularioAlumno'); 
    const cerrarAlumno = document.getElementById('cerrar-alumno');
    const formularioEditar=document.getElementById('formularioeditarAlumno');
    const botonCerrarEditar= document.getElementById('cerrar-alumno-editar');
    const formularioEliminar= document.getElementById('formularioAlumnoEliminar');
    const botonCerrarEliminar= document.getElementById('cerrar-alumno-eliminar');
    const botonEnviarEditar= document.getElementById('enviar-alumno-editar');
   
   
    listaAlumnos.addEventListener('click', function () {
    asistenciaDiv.style.display = 'none';
    condicionAlumnosDiv.style.display = 'none';
    listaAlumnosDiv.style.display = 'block';
    formularioAlumnoDiv.style.display = 'none'; 
    cargarAlumnos();
    });

    asistencia.addEventListener('click', function () {
        listaAlumnosDiv.style.display = 'none';
        condicionAlumnosDiv.style.display = 'none';
        asistenciaDiv.style.display = 'block';
        formularioAlumnoDiv.style.display = 'none'; 
        formularioEditar.style.display = 'none';
        formularioEliminar.style.display = 'none';
        cargarAlumnosAsistencia();
    });

    
    condicion.addEventListener('click', function () {
        listaAlumnosDiv.style.display = 'none';
        asistenciaDiv.style.display = 'none';
        condicionAlumnosDiv.style.display = 'block';
        formularioAlumnoDiv.style.display = 'none'; 
        formularioEditar.style.display = 'none';
        listaAlumnosDiv.style.display = 'none';
        formularioEliminar.style.display = 'none';
    });

    
    crearAlumno.addEventListener('click', function () {
        listaAlumnosDiv.style.display = 'none';
        asistenciaDiv.style.display = 'none'; 
        condicionAlumnosDiv.style.display = 'none'; 
        formularioAlumnoDiv.style.display = 'block'; 
    });

    
    cerrarAlumno.addEventListener('click', function () {
        formularioAlumnoDiv.style.display = 'none'; 
        listaAlumnosDiv.style.display = 'block'; 
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
                            <th>Nombre</th>
                            <th>Apellido</th>
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
                            <td>${alumno.nombre}</td>
                            <td>${alumno.apellido}</td>
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

                   // Añadir funcionalidad a los botones de Editar y Eliminar
                document.querySelectorAll('.editar-btn').forEach(btn => {
                    btn.addEventListener('click', (event) => {
                        const alumnoId = event.target.getAttribute('data-id');

                        editarAlumno(alumnoId);
                        cargarAlumnos();
                    });
                });

                document.querySelectorAll('.eliminar-btn').forEach(btn => {
                    btn.addEventListener('click', (event) => {
                        const alumnoId = event.target.getAttribute('data-id');
                        eliminarAlumno(alumnoId);
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
    
    
    
    function cargarAlumnosAsistencia() {
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
                const tomarAsistencia = document.getElementById('tomar-Asistencia');
                tomarAsistencia.innerHTML = '';

                if (Array.isArray(data.alumnos) && data.alumnos.length > 0) {
                    let tablaHTML = `
                    <table class="tabla-asistencia">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    data.alumnos.forEach(alumno => {
                        tablaHTML += `
                            <tr>
                                <td>${alumno.nombre}</td>
                                <td>${alumno.apellido}</td>
                                <td>${alumno.dni}</td>
                                <td>
                                    <input type="checkbox" class="asistencia-checkbox" data-id="${alumno.id_alumno}">
                                </td>
                            </tr>
                        `;
                    });
                    tablaHTML += `
                            </tbody>
                        </table>
                        <button id="guardarAsistencia">Guardar Asistencia</button>
                    `;
                    tomarAsistencia.innerHTML = tablaHTML;
                } else {
                    tomarAsistencia.innerHTML = '<p>No hay alumnos disponibles.</p>';
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
    
        const url = new URLSearchParams(window.location.search);
        const idMateria = url.get('id');
    
        // Limpiar mensajes de error anteriores
        document.getElementById('error').innerHTML = '';
        document.getElementById('resultado').innerHTML = '';
    
        // Agregar el listener para el envío del formulario
        botonEnviarEditar.addEventListener('click', (event) => {
            event.preventDefault(); // Prevenir el envío por defecto del formulario
    
            const formulario = document.getElementById('formDatosEditarAlumno');
            const datos = new FormData(formulario);
            datos.append('id_materia', idMateria); // Asegúrate de agregar idMateria aquí
            datos.append('id_alumno', alumnoId);
    
            fetch('editarAlumno.php', {
                method: 'POST',
                body: datos
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return res.json();
            })
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
    
        botonCerrarEditar.addEventListener('click', function () {
            formularioEditar.style.display = 'none';
            listaAlumnosDiv.style.display = 'block';
        });

    }
    
    
    function eliminarAlumno(id) {

        formularioEliminar.style.display = 'block';
        listaAlumnosDiv.style.display = 'none';
        if ( botonCerrarEliminar.addEventListener('click', function () {
            formularioEliminar.style.display = 'none';
            listaAlumnosDiv.style.display = 'block';
            console.log(`Cerrado`);
            }));
        console.log(`Editar alumno con ID: ${id}`);

    }
  
});
