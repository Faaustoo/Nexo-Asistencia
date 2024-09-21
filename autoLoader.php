<?php

spl_autoload_register(function($clase) {
    
        $nombre_archivo= __DIR__."/App/Clases/".$clase.".php";
        $nombre_archivo = str_replace('\\', '/', $nombre_archivo); 
    if (is_file($nombre_archivo)) {
        require_once $nombre_archivo;
    } else {
        echo "Error: Archivo no encontrado: $nombre_archivo<br>";
    }
});


?>