<?php
// Datos de conexión
$host = "localhost";      // o la IP del servidor
$port = "5432";           // puerto por defecto de PostgreSQL
$dbname = "planupbd";     //  base de datos
$user = "localhost";     //  usuario de PostgreSQL
$password = "331213"; //  tu contraseña

// Cadena de conexión
$connectionString = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Crear conexión
$conn = pg_connect($connectionString);

// Verificar conexión
if (!$conn) {
    echo "Error: No se pudo conectar a la base de datos.";
} else {
    echo "Conexión exitosa a la BD planupbd.";
}
?>
