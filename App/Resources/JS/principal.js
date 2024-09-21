// Muestra el formulario al hacer clic en "Crear institución"
document.getElementById('crear-institucion').addEventListener('click', function() {
    const formulario = document.getElementById('formularioInstitucion');
    formulario.style.display = formulario.style.display === 'none' ? 'block' : 'none';
});

// Manejo del cierre de sesión
document.getElementById('cerrar-sesion').addEventListener('click', function() {
    fetch('logout.php', {
        method: 'POST',
    })
    .then(response => {
        if (response.ok) {
            window.location.href = 'login.php'; // Redirige a la página de login
        }
    })
    .catch(error => console.error('Error al cerrar sesión:', error));
});

// Manejo del formulario
document.getElementById('formularioInstitucion').addEventListener('submit', function(e) {
    e.preventDefault(); // Previene el envío por defecto

    const datos = new FormData(this);

    fetch('crearInstitucion.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'exito') {
            alert('Institución creada exitosamente');
            this.reset(); // Limpiar el formulario
            this.style.display = 'none'; // Ocultar el formulario nuevamente
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => console.error('Error al crear la institución:', error));
});
