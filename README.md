Nexo - Sistema de Gestión de Asistencias

Nexo es un sistema sencillo para gestionar las asistencias, materias, alumnos y notas. Aquí te contamos lo que puedes hacer como profesor:
  Funcionalidades como Profesor:
  Acceso como Profesor: Regístrate e ingresa con tu usuario para acceder a todas las herramientas.
  Gestión de Asistencias: Puedes crear y eliminar asistencias, marcar presencia o ausencia de los alumnos y eliminar asistencias de forma individual.
  Gestión de Materias: Tienes la opción de crear y eliminar materias según sea necesario.
  Edición de Parámetros de Promoción: Modifica los criterios de promoción de los alumnos de acuerdo con las políticas establecidas.
  Gestión de Alumnos: Dar de alta, baja y modificar alumnos, además de ver los datos de todos los estudiantes en un solo lugar.
  Notas y Promoción: Ingresa las notas fácilmente y consulta si un alumno promociona, regulariza o queda libre según su rendimiento.
  Nexo está diseñado para simplificar todas estas tareas y darte un control completo sobre tus clases y alumnos.

Pasos para Descargar, Configurar y Ejecutar el Proyecto con Laragon: Ve a Laragon y descarga la última versión 
    
    https://laragon.org/download/
Ejecuta el instalador y sigue las instrucciones para completar la instalación. Una vez instalado, inicia Laragon y asegúrate de que los servicios de Apache y MySQL estén activos (puedes verlos en la interfaz de Laragon). Si no están iniciados, ve a Configuración > Servicios y Puertos, y selecciona las casillas de Apache y MySQL.


 
Descargar el Proyecto:



  -Descarga el archivo ZIP del proyecto desde el repositorio de GitHub:

  
Haz clic en el botón 'Code' y selecciona 'Download ZIP'. Luego, extrae el archivo ZIP en una carpeta, a la que podrás cambiarle el nombre según prefieras. Después, mueve la carpeta del proyecto extraído a la carpeta 'www' en Laragon, cuya ruta usualmente es:
    
    C:\laragon\www
  Si la carpeta del proyecto se llama 'Asistencia', la ruta final será :
  
    C:\laragon\www\Asistencia
    
cargar la Base de Datos en MySQL 


 Importar la base de datos: Si el proyecto incluye un archivo de base de datos (como un archivo .sql), necesitarás cargarlo en MySQL. Para hacerlo, abre la Terminal de Laragon y accede al cliente de MySQL. Luego, copia el siguiente comando en la terminal y presiona ENTER dos veces
    
    mysql -u root -p; 
  -Crea la base de datos para el proyecto:

  
  Localiza el archivo Asistencia.sql, ábrelo, copia su contenido y pégalo en la terminal (dar enter y los datos se cargaran automaticamente)
  
Cargar Datos y Ejecutar el Programa:


 En Laragon, accede a la Terminal y usa los siguientes comandos: primero, navega a la carpeta del proyecto usando el comando:
    
    cd Asistencia;
  Inicia el servidor PHP usando el comando:  
     
     php -S localhost:80;
  Esto te proporcionará un enlace local, como http://localhost:80. Copia el enlace en el navegador y estará listo para usar.


El programa ya tiene un Usuario y contraseña cargados para poder evaluarse:  
 - Email :

       javier@gmail.com
 - contraseña:
 -       javier123
