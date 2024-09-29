const params = new URLSearchParams(window.location.search);
const institucionId = params.get('id'); 

// Mostrar el ID para verificar (puedes eliminar esto después de probar)
console.log('ID de la institución:', institucionId);

// Mostrar el formulario para crear una materia
document.getElementById('crear-materia').addEventListener('click', function() {
    const formulario = document.getElementById('formularioMateria');
    formulario.style.display = 'block'; 
});

// Cerrar el formulario y limpiar los campos
document.getElementById('cerrar-materia').addEventListener('click', function() {
    const formulario = document.getElementById('formularioMateria'); 
    formulario.style.display = 'none';
    document.getElementById('nombre_materia').value = '';
    document.getElementById('descripcion_materia').value = '';
});

// Manejo del formulario de materia
let formularioMateria = document.getElementById('formDatosMateria');
formularioMateria.addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar que la página se recargue

    let datos = new FormData(formularioMateria);
    datos.append('id_institucion', institucionId); 

    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';


    fetch('registroMateria.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log('data')
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
        listaMaterias.innerHTML = ''; // Limpiar la lista existente
        console.log(data);
        if (data.estado === 'exito') {
            // Asegúrate de que 'materias' sea un array
            if (Array.isArray(data.materias)) {
                data.materias.forEach(materia => {
                    listaMaterias.innerHTML += `
                        <div style="margin: 5px 0;">
                            <a href="tercerPagina.html?id=${materia.id_materia}" class="materia-link">
                                ${materia.nombre}
                            </a>
                        </div>
                    `;
                });
            } else {
                listaMaterias.innerHTML = '<p>No hay materias disponibles.</p>';
            }
        } else {
            listaMaterias.innerHTML = `<p>${data.mensaje}</p>`;
        }
    })
    .catch(error => {
        console.error('Error al obtener materias:', error);
        document.getElementById('lista-materias').innerHTML = '<p>Error al cargar materias.</p>';
    });
    
}

// Cargar las materias al cargar la página
document.addEventListener('DOMContentLoaded', cargarMaterias);
