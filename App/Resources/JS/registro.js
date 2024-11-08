let formulario = document.getElementById('formularioRegistro');

formulario.addEventListener('submit', function(e) {
    e.preventDefault(); 
    let datos = new FormData(formulario);

    fetch('registro.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log(data.mensaje);
        document.getElementById('resultado').innerHTML = '';
        document.getElementById('error').innerHTML = '';
        if (data.estado === 'exito') {
            document.getElementById('resultado').innerHTML = data.mensaje;
            setTimeout(() => {window.location.href =`index.html`;}, 1000);
        } else if (data.estado === 'error') {
            if (data.errores) {
                document.getElementById('error').innerHTML = data.errores.join('<br>');
            } else {
                document.getElementById('error').innerHTML = data.mensaje;
            }
        }
    }).catch(error => {
        document.getElementById('error').innerHTML = 'Error al usar fetch: ' + error;
    });
});