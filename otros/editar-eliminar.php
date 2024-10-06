function guardarAsistencia() {
        const checkboxes = document.querySelectorAll('.asistencia-checkbox:checked');
        const asistenciaData = Array.from(checkboxes).map(checkbox => checkbox.dataset.id);

        // Aquí puedes enviar los datos al servidor
        console.log('Alumnos presentes:', asistenciaData);
        // Agrega aquí la lógica para guardar asistencia en el servidor
    }


    function eliminarAlumno(idAlumno) {
    let datos = new FormData();
    datos.append('id_alumno', idAlumno);

    fetch('eliminarAlumno.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.estado === 'exito') {
            alert('Alumno eliminado correctamente');
            // Vuelve a cargar los alumnos para actualizar la tabla
            cargarAlumnos();
        } else {
            alert('Error al eliminar el alumno: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error al eliminar alumno:', error);
    });
}


function editarAlumno(idAlumno) {
    // Puedes abrir un formulario para editar al alumno
    let datos = new FormData();
    datos.append('id_alumno', idAlumno);

    // Hacer un fetch para obtener los datos del alumno
    fetch('obtenerAlumno.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.estado === 'exito') {
            document.getElementById('nombre').value = data.alumno.nombre;
            document.getElementById('apellido').value = data.alumno.apellido;
            document.getElementById('dni').value = data.alumno.dni;
            // Otros campos...

            // Manejar la acción de guardar los cambios
            document.getElementById('guardar-cambios').addEventListener('click', function () {
                let nuevosDatos = new FormData(document.getElementById('formularioAlumno'));
                nuevosDatos.append('id_alumno', idAlumno);

                fetch('editarAlumno.php', {
                    method: 'POST',
                    body: nuevosDatos
                })
                .then(res => res.json())
                .then(data => {
                    if (data.estado === 'exito') {
                        alert('Alumno editado correctamente');
                        cargarAlumnos(); // Recargar la tabla para reflejar los cambios
                    } else {
                        alert('Error al editar el alumno: ' + data.mensaje);
                    }
                })
                .catch(error => {
                    console.error('Error al editar alumno:', error);
                });
            });
        } else {
            alert('Error al obtener los datos del alumno: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error al obtener datos del alumno:', error);
    });
}


// Selecciona el checkbox "seleccionar todo" y los checkboxes de asistencia
const seleccionarTodoCheckbox = document.getElementById('seleccionar-todo');
const checkboxesAsistencia = document.querySelectorAll('.asistencia-checkbox');

// Agrega un evento al checkbox "seleccionar todo"
seleccionarTodoCheckbox.addEventListener('change', function() {
    checkboxesAsistencia.forEach(checkbox => {
        checkbox.checked = seleccionarTodoCheckbox.checked; // Marca o desmarca todos
    });
});


// Agregar eventos a los botones de editar y eliminar
                const editarBtns = document.querySelectorAll('.editar-btn');
                const eliminarBtns = document.querySelectorAll('.eliminar-btn');

                editarBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const idAlumno = this.getAttribute('data-id');
                        editarAlumno(idAlumno);
                    });
                });

                eliminarBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const idAlumno = this.getAttribute('data-id');
                        eliminarAlumno(idAlumno);
                    });
                });