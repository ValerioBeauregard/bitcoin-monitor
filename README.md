# Bitcoin Monitor

Aplicación web escrita en backend con PHP, front con HTML, JAVASCRIPT librerías de jQuery y consultas a base de datos con mysql. En desarrollo se utilizó servidor HTTP Apache.

Funciones principales: Guardar de manera local (servidor) cada dos segundos, los datos de precios proporcionados por la plataforma bitso para la moneda Bitcoin, a través de su API rest. En segundo lugar, a través de servidor apache (opcional) sirve una renderización grafica (frontend) de los últimos 300 registros guardados de dichos precios para la moneda Bitcoin.


## Consideraciones
1. El entorno necesita la instalacion de php, mysql(o gestor SQL de preferencia) y apache (o servidor http de preferencia).

2. La base de datos debe ser configurada con las siguientes características mínimas de tabla:
```
CREATE TABLE registros (
	id INT NOT NULL AUTO_INCREMENT,
	high INT,
	last INT,
	created_at DATETIME,
	book VARCHAR(255),
	volume DOUBLE,
	vwap DOUBLE,
	low INT,
	ask INT,
	bid INT,
	change_24 INT,
	rolling_average_change FLOAT,
	PRIMARY KEY (id)
);
```
** *Se anexa back up de la base de datos utilizada en desarrollo* **

3. En el archivo `/Backend/components/db.php` *(linea 12)*, se debe configurar el siguiente constructor de acuerdo a los parametros de conexión de su base de datos:

```
public function __construct() {
        $this -> hostname = 'suLocalhost';
        $this -> username = 'suUsuario';
        $this -> pass = 'suContraseña';
        $this -> nombreDB = 'nombreBD';
        $this -> endPoint = 'https://api.bitso.com/v3/ticker/?book=btc_mxn';
    }
```
4. Para el guardado en segundo plano de las consultas al endpoint se recomienda (desde Linux) utilizar los work jobs de Crontab para que ejecute el script `/Backend/procesosBD.php`, periódicamente cada 1 minuto. El script hará el cálculo para ejecutarse cada dos segundos durante el intervalo de 1 minuto entre cada tarea. 
Alternativamente la mayoría de las distribuciones UNIX cuentan nativamente con un gestor de trabajos que puede ejecutar dicho script en intervalos.