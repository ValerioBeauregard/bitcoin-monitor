<?php
    // Definiendo ruta para require_once
    define('__ROOT__', dirname(dirname(__FILE__)));

    // Solicitando db class
    require_once(__ROOT__.'/db.php');

    // Instancia
    $db = new db();

    // Formulando query
    $query = "SELECT * FROM registros ORDER BY id DESC LIMIT 300";

    // Haciendo consulta
    $respuesta = $db -> query($query);

    // Creando array con respuesta de bd
    $precios = array();
    while ($arra = mysqli_fetch_array($respuesta)) {
        $precios += [ $arra['created_at'] => $arra['last'] ];
    }

    // renderizando json e invirtiendo orden
    $json = json_encode(array_reverse($precios));

    //Modificando el header y mandando los datos
    header('Content-type: application/json; charset=utf-8');
    echo $json;
    exit();
?>
