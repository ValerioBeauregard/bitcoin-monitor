<?php

// Solicitando db class
require_once(__ROOT__.'/Backend/components/db.php');

class manttoDB extends db {
    //Propiedades
    private $limite = 500; // Int establece el maximo de registros en bd para evitar exedentes dado que solo necesitamos 300

    //Metodos
    // Funcion que devuelve el numero de registros en base de datos
    public function numRegistros() {

        // Guardando query consulta
        $query = "SELECT COUNT(id) FROM registros";

        $resultado = $this -> query($query);

        return mysqli_fetch_array($resultado)[0];
    }

    public function mantenimientoDB() {
        // Guardando el numero total de registros
        $registros = $this -> numRegistros();

        // Valorando si hay mas de los registros necesarios
        if ($registros > $this -> limite) {

            //Tomando id del registro mas antiguo
            $querySeleccion = "SELECT MIN(id) FROM registros";
            $min = $this -> query($querySeleccion);
            $id = mysqli_fetch_array($min)[0];

            // Borrando registro seleccionado
            $queryBorrado = "DELETE FROM registros WHERE id='$id'";
            $respuesta = $this -> query($queryBorrado);
        }
    }

}


?>