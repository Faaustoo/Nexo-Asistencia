document.addEventListener("DOMContentLoaded", () => {
    const btncondicion = document.getElementById('condicion-alumno');
    const divListaCondicion = document.getElementById('condicion-lista');
    const divCondicion = document.getElementById('condicion-Alumnos');
    const divAsistencia = document.getElementById('asistencia-Alumnos');
    const formularioAlumnoDiv = document.getElementById('formularioAlumno'); 
    const formularioEditar = document.getElementById('formularioeditarAlumno');
    const formularioEliminar = document.getElementById('formularioAlumnoEliminar');
    const Listalumnosdiv = document.getElementById('Listalumnos');

    // Mostrar la sección de tomar asistencia
    btncondicion.addEventListener("click", () => {
        console.log('click');
        divCondicion.style.display = "block";
        divListaCondicion.style.display = "block";
        divAsistencia.style.display = "none"; 
        Listalumnosdiv.style.display = "none"; 
        formularioAlumnoDiv.style.display = 'none';
        formularioEditar.style.display = "none";
        formularioEliminar.style.display = "none";
        cargarAlumnos();
    });

    function cargarAlumnos() {
        const url = new URLSearchParams(window.location.search);
        const idMateria = url.get('id');
        console.log('ID de materia:', idMateria); // Verifica que se esté capturando el ID correctamente
    
        const datos = new FormData();
        datos.append('id_materia', idMateria);
        
        // Mostrar indicador de carga
        document.getElementById('condicion-lista').innerHTML = '<p>Cargando alumnos...</p>';
    
        fetch('obtenerAlumnosNotas.php', { 
            method: 'POST',
            body: datos
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
    
            const listaAlumnos = document.getElementById('condicion-lista');
            listaAlumnos.innerHTML = ''; 
    
            if (data.estado === 'exito') {
                    let tablaHTML = `
                        <div id="error-condicion"></div>
                        <div id="resultado-condicion"></div>
                        <table class="tabla-alumnos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Parcial 1</th>
                                    <th>Parcial 2</th>
                                    <th>Trabajo Final</th>
                                    <th>Asistencia %</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
    
                    // guard las asistencias por alumno
                        const asistenciasPorAlumno = {};
                        data.asistencias.forEach(asistencia => {
                            const idAlumno = asistencia.id_alumno;
                            const estadoAsistencia = asistencia.estado_asistencia; 

                            if (!asistenciasPorAlumno[idAlumno]) {
                                asistenciasPorAlumno[idAlumno] = {presentes: 0, ausentes: 0 };
                            }

                            if (estadoAsistencia === 1) {
                                asistenciasPorAlumno[idAlumno].presentes++;
                            } else {
                                asistenciasPorAlumno[idAlumno].ausentes++;
                            }
                        });
                        console.log(asistenciasPorAlumno);

    
                    data.notas.forEach(alumno => {
                        const asistencias = asistenciasPorAlumno[alumno.id_alumno] ;
                        const totalAsistencias = asistencias.presentes + asistencias.ausentes;
                        let porcentajeAsistencia;

                            if (totalAsistencias > 0) {
                                porcentajeAsistencia = (asistencias.presentes / totalAsistencias) * 100;
                            } else {
                                porcentajeAsistencia = 0; 
                            }

    
                        tablaHTML += `
                            <tr>
                                <td>${alumno.nombre || 'N/A'}</td>
                                <td>${alumno.apellido || 'N/A'}</td>
                                <td>${alumno.dni || 'N/A'}</td>
                                <td>${alumno.parcial1 !== null ? alumno.parcial1 : 'N/A'}</td>
                                <td>${alumno.parcial2 !== null ? alumno.parcial2 : 'N/A'}</td>
                                <td>${alumno.trabajo_final !== null ? alumno.trabajo_final : 'N/A'}</td>
                                <td>${porcentajeAsistencia}%</td>
                                <td>${alumno.condicion || 'N/A'}</td>
                                <td>
                                    <button class="editar-btn" data-id="${alumno.id_alumno}">Editar Nota</button>
                                </td>
                            </tr>
                        `;
                    });
    
                    tablaHTML += `
                            </tbody>
                        </table>
                    `;
    
                    listaAlumnos.innerHTML = tablaHTML;
    
                    // Agregar evento para los botones de editar
                    document.querySelectorAll('.editar-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const idAlumno = this.getAttribute('data-id');
                            // Lógica para editar la nota
                            console.log('Editar nota para alumno ID:', idAlumno);
                        });
                    });
                
            } else {
                document.getElementById('error-condicion').innerHTML = data.mensaje; 
            }
        })
        .catch(error => {
            document.getElementById('error-condicion').innerHTML = 'Error al usar fetch: ' + error;
        });
    }
});
