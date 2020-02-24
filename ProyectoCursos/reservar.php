<?php
// Iniciamos la sesión
session_start();
// Comprobamos que tenemos los datos necesarios (credenciales e id del curso)
if (isset($_GET['id']) && isset($_SESSION['usuario']) && isset($_SESSION['contra'])) {
    // Almacenamos las credenciales y el id del curso en variables por comodidad
    $usuario = $_SESSION['usuario'];
    $contra = $_SESSION['contra'];
    $id = $_GET['id'];
    // Conectamos con mysql y configuramos el encoding de la BBDD
    $db = new mysqli("127.0.0.1", "root", "");
    $db->set_charset("utf8");

    if ($db->connect_error) {
        // En caso de error lo notificamos
        echo "Error al conectar a la base de datos: al reservar";
    } else {
        // Seleccionamos la base de datos
        $db->select_db("cursos");
        // Declarmaos y ejecutamos las instrucciones para modificar el curso
        $sql = "UPDATE cursos SET plazas_disponibles = plazas_disponibles - 1 WHERE id_curso = $id;";
        $res = $db->query($sql);

        $sql = "UPDATE cursos SET plazas_ocupadas = plazas_ocupadas + 1 WHERE id_curso = $id";
        $res = $db->query($sql);
        // Vuelta a la página del usuario
        header("location:main.php");
    }
}
