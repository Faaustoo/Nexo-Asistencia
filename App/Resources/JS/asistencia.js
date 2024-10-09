document.addEventListener("DOMContentLoaded", () => {
    // Variables para los botones de asistencia
    const btnTomarAsistencia = document.getElementById('asistencia-alumno');
    const divAsistencia = document.getElementById('asistencia-Alumnos');
    const formularioTomarAsistencia = document.getElementById("formularioTomarAsistencia");

    const btnCerrarAsistencia = document.getElementById("cerrar-asistencia");
    const btnEnviarAsistencia = document.getElementById("enviar-asistencia");
    const formularioEliminarAsistencia = document.getElementById("formularioEliminarAsistencia");
    
    
    const tomarAsistenciaDiv = document.getElementById("tomar-Asistencia");
    const listaAlumnosDiv = document.getElementById("Listalumnos");
    const condicionAlumnosDiv = document.getElementById("condicion-Alumnos");
    const formularioAlumnoDiv = document.getElementById('formularioAlumno'); 
    const formularioEditar = document.getElementById('formularioeditarAlumno');
    const formularioEliminar = document.getElementById('formularioAlumnoEliminar');

    let contadorClases = 0;
    
    // Mostrar la sección de tomar asistencia
    btnTomarAsistencia.addEventListener("click", () => {
        listaAlumnosDiv.style.display = "none";
        condicionAlumnosDiv.style.display = "none";
        formularioAlumnoDiv.style.display = "none";
        formularioEditar.style.display = "none";
        formularioEliminar.style.display = "none";
        divAsistencia.style.display = "block"; 
        formularioTomarAsistencia.style.display = 'none';
        formularioEliminarAsistencia.style.display = 'none'; 
        cargarAlumnosAsistencia();
    });

    // Función para cerrar la sección de asistencia
    btnCerrarAsistencia.addEventListener("click", () => {
        tomarAsistenciaDiv.style.display = "none"; 
        formularioTomarAsistencia.style.display = "none"; 
    });

    // Cargar alumnos
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
                const listaAlumnos = document.getElementById('tomar-Asistencia');
                listaAlumnos.innerHTML = ''; 
                
                if (data.alumnos.length > 0) {
                    let tablaHTML = `
                    <div class="fecha-asistencia">
                        <label for="fecha">Seleccione la fecha:</label>
                        <input type="date" id="fecha" name="fecha">
                        <div id="contadorClases">Cantidad de clases: ${contadorClases}</div>
                        <button class="todos" type="button" id="seleccionar-todos">Seleccionar Todos</button>
                    </div>
    
                        <table class="tabla-alumnos">
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
                        <div class="container-btn">
                            <button id="eliminarAsistencia">Eliminar Asistencia</button>
                            <button id="guardarAsistencia">Guardar Asistencia</button>
                        </div>
                    `;
    
                    listaAlumnos.innerHTML = tablaHTML;
    
                    // Función para seleccionar todos los checkboxes
                    const seleccionarTodos = document.getElementById('seleccionar-todos');
                    seleccionarTodos.addEventListener('click', () => {
                        const checkboxes = document.querySelectorAll('.asistencia-checkbox');
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = !checkbox.checked;
                        });
                    });
    
                    // Función para guardar asistencia
                    const btnGuardarAsistencia = document.getElementById("guardarAsistencia");
                    btnGuardarAsistencia.addEventListener("click", () => {
                        const fecha = document.getElementById('fecha').value;

                        document.getElementById('resultado-asistencia').innerHTML = ''; 
                        document.getElementById('error-asistencia').innerHTML = '';
                        formularioTomarAsistencia.style.display = 'block';
                        formularioEliminarAsistencia.style.display = 'none'; 

                        // Manejo de eventos para el botón de confirmar (Sí)
                        document.getElementById('si-asistencia').onclick = () => {
                            guardarAsistencia();
                        };

                        // Manejo de eventos para el botón de cancelar (No)
                        document.getElementById('no-asistencia').onclick = () => {
                            formularioTomarAsistencia.style.display = 'none'; // Cierra el formulario si se cancela
                        };

                        // Cerrar el formulario al hacer clic en el botón CERRAR
                        document.getElementById('cerrar-asistencia').onclick = () => {
                            formularioTomarAsistencia.style.display = 'none';
                            tomarAsistenciaDiv.style.display = 'block';
                            document.getElementById('fecha').value = '';
                            const checkboxes = document.querySelectorAll('.asistencia-checkbox');
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        };
                    });

                    const botonEliminarAsistencia = document.getElementById('eliminarAsistencia');
                    botonEliminarAsistencia.addEventListener('click', () => {
                        // Mostrar el formulario de eliminación
                        formularioEliminarAsistencia.style.display = 'block'; 
                        formularioTomarAsistencia.style.display = 'none';
                        document.getElementById('resultado-eliminarAsistencia').innerHTML = ''; 
                        document.getElementById('error-eliminarAsistencia').innerHTML = '';

                        // Confirmar eliminación
                        document.getElementById('enviar-asistencia-eliminar').onclick = () => {
                            eliminarAsistencia(); 
                        };

                        // Cerrar el formulario sin eliminar
                        document.getElementById('cerrar-a-eliminar').onclick = () => {
                            formularioEliminarAsistencia.style.display = 'none'; 
                            document.getElementById('fecha-eliminar').value='';
                        };
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

   // Función para eliminar la asistencia
   function eliminarAsistencia() {
    const fechaEliminar = document.getElementById('fecha-eliminar').value;
    if (!fechaEliminar) {
        alert('Seleccione una fecha para eliminar la asistencia.');
        return;
    }

    const datos = new FormData();
    datos.append('fecha', fechaEliminar); 
    fetch('eliminarAsistencia.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log('Respuesta del servidor:', data); 
        document.getElementById('resultado-eliminarAsistencia').innerHTML = ''; 
        document.getElementById('error-eliminarAsistencia').innerHTML = ''; 

        // Mostrar el mensaje de éxito o error
        if (data.estado === 'exito') {
            contadorClases--; // Solo suma si se guarda correctamente
            actualizarContador();
            document.getElementById('resultado-eliminarAsistencia').innerHTML = data.mensaje; // Mensaje de éxito

        } else if (data.estado === 'error') {
            document.getElementById('error-eliminarAsistencia').innerHTML = data.mensaje; // Mensaje de error
            if (data.errores && data.errores.length > 0) {
                data.errores.forEach(error => {
                    document.getElementById('error-eliminarAsistencia').innerHTML += error + '<br>'; 
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-asistencia').innerHTML = 'Error al usar fetch: ' + error;
    });
}



    function guardarAsistencia() {
        const fecha = document.getElementById('fecha').value;
        if (!fecha) {
            alert('Seleccione una fecha antes de guardar la asistencia.');
            return;
        }
    
        const url = new URLSearchParams(window.location.search);
        const idMateria = url.get('id');
        const checkboxes = document.querySelectorAll('.asistencia-checkbox');
        const asistenciaDatos = [];
    
        checkboxes.forEach(checkbox => {
            asistenciaDatos.push({
                id_alumno: checkbox.dataset.id,
                estado: checkbox.checked ? 1 : 0
            });
        });
    
        const datos = new FormData();
        datos.append('fecha', fecha); 
        datos.append('id_materia', idMateria);
        datos.append('asistencias', JSON.stringify(asistenciaDatos)); // Enviar el array completo de asistencias como JSON
    
        fetch('guardarAsistencia.php', {
            method: 'POST',
            body: datos
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            const resultadoAsistencia = document.getElementById('resultado-asistencia');
            const errorAsistencia = document.getElementById('error-asistencia');
    
            if (data.estado === 'exito') {
                contadorClases++; 
                actualizarContador();
                resultadoAsistencia.innerHTML = data.mensaje;
            } else {
                errorAsistencia.innerHTML = data.mensaje;
            }
        })
        .catch(error => {
            console.error('Error al guardar asistencia:', error);
        });
    }
    
    function actualizarContador() {
        document.getElementById('contadorClases').innerHTML = `Cantidad de clases: ${contadorClases}`;
    }
    

    

});





