let formulario = document.getElementById('formularioLogin');

formulario.addEventListener('submit', function(e) {
    e.preventDefault(); 

    let datos = new FormData(formulario);

    fetch('login.php', { 
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);

        document.getElementById('resultado').innerHTML = '';
        document.getElementById('error').innerHTML = '';

        if (data.estado === 'exito') {
            window.location.href = 'paginaPrincipal.html';  
        } else if (data.estado === 'error') {
            if (data.errores) {
                document.getElementById('error').innerHTML = data.errores.join('<br>');
            } else {
                document.getElementById('error').innerHTML = data.mensaje || 'Error desconocido.';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error').innerHTML = 'Error al usar fetch: ' + error;
    });
});
