// Muestra el formulario
document.getElementById('crear-alumno').addEventListener('click', function() {
    var formContainer = document.getElementById('formularioAlumno');
    formContainer.style.display = 'block';
});

// Oculta el formulario
document.getElementById('cerrar-institucion').addEventListener('click', function() {
    var formContainer = document.getElementById('formularioAlumno');
    formContainer.style.display = 'none';
});

// Maneja el envío del formulario
let formularioAlumno = document.getElementById('formDatosAlumno');
formularioAlumno.addEventListener('submit', function(e) {
    e.preventDefault(); 
    let datos = new FormData(formularioAlumno);

    // Limpiar mensajes de resultado y error
    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';

    // Realiza la petición fetch
    fetch('registroAlumno.php', { 
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
