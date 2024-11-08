document.addEventListener("DOMContentLoaded", () => {
    const btncondicion = document.getElementById('condicion-alumno');
    const divListaCondicion = document.getElementById('condicion-lista');
    const divCondicion = document.getElementById('condicion-Alumnos');
    const divAsistencia = document.getElementById('asistencia-Alumnos');
    const formularioAlumnoDiv = document.getElementById('formularioAlumno'); 
    const formularioEditarAlumno = document.getElementById('formularioeditarAlumno');
    const formularioEliminar = document.getElementById('formularioAlumnoEliminar');
    const Listalumnosdiv = document.getElementById('Listalumnos');
    
    btncondicion.addEventListener("click", () => {
        divCondicion.style.display = "block";
        divListaCondicion.style.display = "block";
        divAsistencia.style.display = "none";
        Listalumnosdiv.style.display = "none";
        formularioAlumnoDiv.style.display = 'none';
        formularioEditarAlumno.style.display = "none";
        formularioEliminar.style.display = "none";
        document.getElementById('formulariEditarNota').style.display = 'none';
       
    });


    function cargarAlumnos() {
        const url = new URLSearchParams(window.location.search);
        const idMateria = url.get('id');
    
        const datos = new FormData();
        datos.append('id_materia', idMateria);
    
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
                <div class="tabla-container">
                    <table class="tabla-alumnos">
                        <thead>
                            <tr>
                                <th>Apellido</th>
                                <th>Nombre</th>
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
                    </div>
                `;
    
                const asistenciasPorAlumno = {};
                data.asistencias.forEach(asistencia => {
                    const idAlumno = asistencia.id_alumno;
                    const estadoAsistencia = asistencia.estado_asistencia;
    
                    if (!asistenciasPorAlumno[idAlumno]) {
                        asistenciasPorAlumno[idAlumno] = { presentes: 0, ausentes: 0 };
                    }
    
                    if (estadoAsistencia === 1) {
                        asistenciasPorAlumno[idAlumno].presentes++;
                    } else {
                        asistenciasPorAlumno[idAlumno].ausentes++;
                    }
                });
    
                // Object.keys() devuelve un array con las claves de un objeto.
                // obtengo el id del primer id del alumno
                const primerAlumnoId = Object.keys(asistenciasPorAlumno)[0];
                const diasClases = asistenciasPorAlumno[primerAlumnoId].presentes + asistenciasPorAlumno[primerAlumnoId].ausentes;
                document.getElementById('dia-clases').innerHTML = 'Cantidad de Clases: ' + diasClases;
                let totalAsistencias = 0;
                    if (primerAlumnoId) {
                        totalAsistencias = asistenciasPorAlumno[primerAlumnoId].presentes + asistenciasPorAlumno[primerAlumnoId].ausentes;
                    } else {
                        totalAsistencias = 0;
                    }

                document.getElementById('dia-clases').innerHTML = 'Cantidad de Clases: ' + diasClases;
    
                data.notas.forEach(alumno => {
                    const asistencias = asistenciasPorAlumno[alumno.id_alumno] || { presentes: 0, ausentes: 0 };
                    const totalAsistencias = asistencias.presentes + asistencias.ausentes;
                    let porcentajeAsistencia = 0;
    
                    if (totalAsistencias > 0) {
                        porcentajeAsistencia = (asistencias.presentes / totalAsistencias) * 100;
                    }
                    
                    let condicion = '';
                    if (data.ram) {
                        //parseFloat para convertir un string en un numero decimal

                        const porcentajePromocionRam = parseFloat(data.ram.porcentaje_promocion);
                        const porcentajeRegularRam = parseFloat(data.ram.porcentaje_regular);
                        const notaPromocionRam = parseFloat(data.ram.nota_promocion);
                        const notaRegularRam = parseFloat(data.ram.nota_regular);
    
                        const promedioNotas = (parseFloat(alumno.parcial1) + parseFloat(alumno.parcial2) + parseFloat(alumno.trabajo_final)) / 3;
    
                        if (porcentajeAsistencia >= porcentajePromocionRam && promedioNotas >= notaPromocionRam) {
                            condicion = 'PROMOCION';
                        } else if (porcentajeAsistencia >= porcentajeRegularRam && promedioNotas >= notaRegularRam) {
                            condicion = 'REGULAR';
                        } else {
                            condicion = 'LIBRE';
                        }
                    }
    
                    tablaHTML += `
                        <tr>
                            <td>${alumno.apellido}</td>
                            <td>${alumno.nombre}</td>
                            <td>${alumno.dni}</td>
                            <td>${alumno.parcial1}</td>
                            <td>${alumno.parcial2}</td>
                            <td>${alumno.trabajo_final}</td>
                            <td>${porcentajeAsistencia.toFixed(2)}%</td>
                            <td>${condicion}</td>
                            <td>
                                <button class="editar-btn-nota" data-id="${alumno.id_alumno}">Editar Nota</button>
                            </td>
                        </tr>
                    `;
                });
    
                tablaHTML += `
                        </tbody>
                    </table>
                `;
    
                listaAlumnos.innerHTML = tablaHTML;
    
                document.querySelectorAll('.editar-btn-nota').forEach(btn => {
                    btn.addEventListener('click', (event) => {
                        const alumnoId = event.target.getAttribute('data-id');
                        editarNota(alumnoId, data.notas);
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
    

    function editarNota(alumnoId , notas) {
        const formulario = document.getElementById('formEditarNota'); 
    
        document.getElementById('formulariEditarNota').style.display = 'block';
        document.getElementById('condicion-lista').style.display = 'none';
        document.getElementById('dia-clases').style.display = 'none';
        formularioEditarAlumno.style.display = 'none';
    
        const inputs = formulario.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = ''; 
        });
        document.getElementById('error-editar').innerHTML = '';
        document.getElementById('resultado-editar').innerHTML = '';

        const nota = notas.find(nota => nota.id_alumno == alumnoId);

    if (nota) {
        document.getElementById('parcial_uno').value = nota.parcial1;
        document.getElementById('parcial_dos').value = nota.parcial2;
        document.getElementById('trabajo_final').value = nota.trabajo_final;
   
    } else {
        console.error('Alumno no encontrado en la lista');
    }
    
        const url = new URLSearchParams(window.location.search);
        const idMateria = url.get('id');
    
        // Cerrar el formulario
        document.getElementById('cerrar-nota').addEventListener('click', () => {
            cargarAlumnos();
            document.getElementById('formulariEditarNota').style.display = "none";
            document.getElementById('condicion-lista').style.display = "block";
            document.getElementById('resultado-editar-nota').innerHTML = '';
            document.getElementById('error-editar-nota').innerHTML = '';
        });
    
        // Enviar el formulario
        document.getElementById('enviar-nota').addEventListener('click', (event) => {
            event.preventDefault();
            
    
            let datos = new FormData(formulario);
            datos.append('id_alumno', alumnoId);
            datos.append('id_materia', idMateria);
    
            fetch('editarNota.php', {
                method: 'POST',
                body: datos
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('resultado-editar-nota').innerHTML = '';
                document.getElementById('error-editar-nota').innerHTML = '';
                if (data.estado === 'exito') {
                    document.getElementById('resultado-editar-nota').innerHTML = data.mensaje;
                    setTimeout(() => {location.reload();}, 1000);
                } else if (data.estado === 'error') {
                    document.getElementById('error-editar-nota').innerHTML = data.errores.join('<br>');
                }
            })
            .catch(error => {
                console.error('Error al editar el alumno:', error);
                document.getElementById('error-editar-nota').innerHTML = 'Hubo un error al procesar la solicitud';
            });
        });
    }
    
    
    cargarAlumnos();   
    divCondicion.style.display = "block";
        divListaCondicion.style.display = "block";
});
