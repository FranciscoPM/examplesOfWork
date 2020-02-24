<?php
// Iniciamos una sesión para almacenar credenciales del usuario
session_start();
/*
    Función comprobar. Recibe dos parámetros (nombre de usuario y vector con los usuarios que tenemos en la base de datos)
    y se encarga de comprobar si el usuario dado aparece en la base de datos
*/
function comprobar($usuario, $usuarios) {
    // En caso de existir esta función devuelve su posición en el vector
    for ($i = 0; $i < count($usuarios); $i++) {
        if ($usuarios[$i] == $usuario) {
            return $i;
        }
    }
    // En caso contrario devuelve -1 (false)
    return (-1);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <!-- Link a la Hoja de estilos -->
    <link rel="stylesheet" href="estilos/inicio.css">
</head>

<body>
    <!-- HOME -->
    <h1 id="titulo">tucurso.net</h1>
    <div id="Content">
        <h2>Registro / Acceso</h2>
        <!-- FORMULARIO DE REGISTRO Y ACCESO -->
        <form id="formEntrada" action="index.php" method="POST" enctype="multipart/form-data">
            <label for="in_user" id="lab_user" name="lab_user">Usuario</label>
            <input type="text" class="in_text" id="in_user" name="in_user" placeholder="Nombre de usuario" autofocus /> <br />
            <label for="in_pass" id="lab_pass" name="lab_pass">Contraseña</label>
            <input type="password" class="in_text" id="in_pass" name="in_pass" placeholder="Contraseña" /> <br />
            <input type="submit" id="in_submit" name="in_submit" value="Registrar" />
            <input type="submit" id="in_submit" name="in_submit" value="Acceder" />
        </form>
        <?php
        // Si se ha pasado el formulario se ejecuta el siguiente código
        if (isset($_POST['in_user']) && isset($_POST['in_pass'])) {
            // Almacenamos credenciales en la sesión
            $_SESSION['usuario'] = $_POST['in_user'];
            $_SESSION['contra'] = $_POST['in_pass'];
            // Y pasamos los datos a variables para poder manejarlos cómodamente
            $usuario = $_SESSION['usuario'];
            $contra = $_SESSION['contra'];
            // Conectamos con mysql y configuramos el encoding de los datos de la BBDD
            $db = new mysqli("127.0.0.1", "root", "");
            $db->set_charset("utf8");
            
            if ($db->connect_error) {
                // En caso de error mostramos un mensaje
                echo "Error al conectar con la base de datos: inicio de sesión";
            } else {
                // Seleccionamos la base de datos
                $db->select_db("cursos");
                // Declaramos y ejecuamos una query para recoger todos los usuarios que existen en nuestra BBDD
                $sql = "SELECT * FROM usuarios";
                $res = $db->query($sql, MYSQLI_USE_RESULT);
                // Declaramos dos vectores para almacenar los datos de nuestra BBDD
                $id_usuarios = array();
                $usuarios = array();
                // A continuación asignamos los datos de cada columna en arrays en paralelo
                if ($res) {
                    $fila = $res->fetch_assoc();
                    while ($fila) {
                        $id_usuarios[] = $fila['id_usuario'];
                        $usuarios[] = $fila['usuario'];
                        $fila = $res->fetch_assoc();
                    }
                }
                // En función del botón que se ha utilizado se ejecutan unas instrucciones u otras
                if ($_POST['in_submit'] == "Registrar") {
                    // En caso de querer registrarse se comprueba que el usuario no esté dado de alta actualmente y se le añade a la BBDD para pasar a la siguiente página
                    if (comprobar($usuario, $usuarios) >= 0) {
                        echo "<h2>El usuario ya está registrado, por favor, 'Acceda'</h2>";
                    } elseif (comprobar($usuario, $usuarios) == (-1)) {
                        $sql = "INSERT INTO usuarios (usuario, contra) VALUES ('$usuario', '$contra');";
                        $res = $db->query($sql);
                        header("location:main.php");
                    }
                } elseif ($_POST['in_submit'] == "Acceder") {
                    // En caso de querer acceder se comprueba que el usuario esté dado de alta actualmente y en caso de no estarlo se le avisa
                    if (comprobar($usuario, $usuarios) >= 0) {
                        header("location:main.php");
                    } elseif (comprobar($usuario, $usuarios) == (-1)) {
                        echo "<h2>El usuario no está registrado, por favor, regístrelo</h2>";
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>