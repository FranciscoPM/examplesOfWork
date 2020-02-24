<?php
// Iniciamos la sesión
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['contra'])) {
    // Pasamos las credenciales a variables por comodidad
    $usuario = $_SESSION['usuario'];
    $contra = $_SESSION['contra'];
    // Comprobamos que se ha enviado el formulario y que los campos no están en blanco
    if (isset($_POST['in_curso']) && isset($_POST['in_totales']) && strlen($_POST['in_curso']) > 0 && $_POST['in_totales'] > 0) {
        // Almacenamos los datos en variables
        $curso = $_POST['in_curso'];
        $plazas = $_POST['in_totales'];
        // Conectamos con mysql y configuramos el encoding de la BBDD
        $db = new mysqli("127.0.0.1", "root", "");
        $db->set_charset("utf8");

        if ($db->connect_error) {
            // Si hay un error al conectar enviamos un mensaje
            echo "Error al conectar con la base de datos: al añadir";
        } else {
            // Si no, seleccionamos la base de datos
            $db->select_db("cursos");
            // Creamos la sentencia SQL con los datos dados y la ejecutamos en la BBDD
            $sql = "INSERT INTO cursos (curso_disponible, plazas_disponibles, plazas_ocupadas, plazas_totales) VALUES ('$curso', $plazas, 0, $plazas);";
            $res = $db->query($sql);
            // Vuelve a la página del usuario
            header("location:main.php");
        }
    } else {
        /*
            En caso de que no se hayan recogido correctamente los datos del formulario lo notificamos y
            mostramos un ancla para volver a la página del usuario
        */
        echo "Error al recoger datos del nuevo curso <br />";
        echo "<a href='main.php'>Volver a la página anterior</a>";
    }
} else {
    // En caso de no tener los datos del usuario lo notificamos y mostramos un ancla de vuelta a inicio
    echo "Error al acreditar usuario <br />";
    echo "<a href='index.php'>Volver a inicio</a>";
}
