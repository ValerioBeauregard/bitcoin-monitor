<?php 

class db {
    //Propiedades
    public $hostname;
    public $username;
    public $pass;
    public $nombreDB;
    private $endPoint;

    //Metodos
    public function __construct() {
        $this -> hostname = 'suLocalhost';
        $this -> username = 'suUsuario';
        $this -> pass = 'suContraseña';
        $this -> nombreDB = 'nombreBD';
        $this -> endPoint = 'https://api.bitso.com/v3/ticker/?book=btc_mxn';
    }

    public function query($query) {
        // Configuracion de coneccion a BD
        $conneccion = mysqli_connect(
            $this -> hostname,
            $this -> username,
            $this -> pass,
            $this -> nombreDB
        );

        // Verificando error en coneccion
        if (mysqli_connect_errno()) {
            echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
        }

        // Haciendo consulta
        $respuesta = mysqli_query($conneccion, $query);
        
        // Cerrando coneccion mysql
        mysqli_close($conneccion);

        return $respuesta;
    }

    // Peticion get al endpoint y retorna array asociativo del json recibido
    private function recibiendoData() {
        // Iniciando y configurando la peticion (curl)
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this -> endPoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        // Haciendo peticion
        $respuesta = curl_exec($curl);
        // var_dump($respuesta);

        // convirtiendo a array
        $jsonObject = json_decode($respuesta, true);

        // Cerrando sesion curl
        curl_close($curl);

        // retornando array
        return $jsonObject["payload"];

    }

    public function almacenadoLocal() {
        // Llamando funcion que trae los datos del endpoint
        $datos = $this -> recibiendoData();

        // Separando en variables locales (memoria)
        $high = $datos["high"];
        $last = $datos["last"];
        $created_at = $datos["created_at"];
        $book = $datos["book"];
        $volume = $datos["volume"];
        $vwap = $datos["vwap"];
        $low = $datos["low"];
        $ask = $datos["ask"];
        $bid = $datos["bid"];
        $change_24 = $datos["change_24"];
        $rolling_average_change = $datos["rolling_average_change"]["6"];
        
        // Guardando datos en base de datos local
        // Query de insercion
        $query = "INSERT INTO registros (high, last, created_at, book, volume, vwap, low, ask, bid, change_24, rolling_average_change) VALUES ('$high', '$last', '$created_at', '$book', '$volume', '$vwap', '$low', '$ask', '$bid', '$change_24', '$rolling_average_change')";

        // Configuracion de coneccion a BD
        $respuesta = $this -> query($query);
    }
}

?>