<?php
// Declaramos vectores para almacenar todos los datos de nuestra tabla de cursos
$identificador = array();
$cursos = array();
$disponibles = array();
$ocupadas = array();
$plazas_totales = array();
// Conectamos con mysql y configuramos el encoding de la BBDD
$db = new mysqli("127.0.0.1", "root", "");
$db->set_charset("utf8");

if ($db->connect_error) {
    // En caso de error lo notificamos
    echo "Error al conectar con la base de datos";
} else {
    // Seleccionamos la base de datos
    $db->select_db("cursos");
    // Generamos la setencia SQL y la ejecutamos
    $sql = "SELECT * FROM cursos;";
    $res = $db->query($sql, MYSQLI_USE_RESULT);
    // Recogemos y almacenamos todos los datos
    if ($res) {
        $fila = $res->fetch_assoc();
        while ($fila) {
            $identificador[] = $fila['id_curso'];
            $cursos[] = $fila['curso_disponible'];
            $disponibles[] = $fila['plazas_disponibles'];
            $ocupadas[] = $fila['plazas_ocupadas'];
            $totales[] = $fila['plazas_totales'];
            $fila = $res->fetch_assoc();
        }
    }
}

