document.getElementById('crear-institucion').addEventListener('click', function() {
    const formulario = document.getElementById('formularioInstitucion');
    formulario.style.display = 'block'; 
});

document.getElementById('cerrar-institucion').addEventListener('click', function() {
    const formulario = document.getElementById('formularioInstitucion');
    formulario.style.display = 'none';
    document.getElementById('nombre_institucion').value = '';
    document.getElementById('direccion_institucion').value = '';
    document.getElementById('cue_institucion').value = ''; 
    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';
});

let formulario = document.getElementById('formDatosInstitucion');
formulario.addEventListener('submit', function(e) {
    e.preventDefault(); 
    let datos = new FormData(formulario);

    fetch('registroInstitucion.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
.then(data => {
    console.log(data);
    document.getElementById('resultado').innerHTML = '';
    document.getElementById('error').innerHTML = '';

    if (data.estado === 'exito') {
        document.getElementById('resultado').innerHTML = data.mensaje; 
    } else if (data.estado === 'error') {
            document.getElementById('error').innerHTML = data.errores.join('<br>'); 
        }
}).catch(error => {
        console.error('Error:', error);
        document.getElementById('error').innerHTML = 'Error al usar fetch: ' + error;
    });
});