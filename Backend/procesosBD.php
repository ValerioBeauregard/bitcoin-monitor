<?php

// Definiendo ruta para require_once
define('__ROOT__', dirname(dirname(__FILE__)));

// Solicitando db class
require_once(__ROOT__.'/Backend/components/manttoDB.php');

// Instanciando clase
$db = new manttoDB();

// Variable de control controlando las 30 consultas que debe ejecutarse en 1 minutos se la tarea de ejecuta cada 2 segundos
$control = 0; 
while ($control < 30) {
    // Llamando metodos
    $db -> almacenadoLocal();
    $db -> mantenimientoDB();

    $control += 1;

    // Esperar
    usleep(1200000); // Tiempo de espera calculado en promedio de las condiciones de respuesta locales en entorno de desarrollo.
}

?>