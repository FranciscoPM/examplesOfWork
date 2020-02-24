<?php
// Iniciamos la sesión
session_start();
// Llamamos a nuestro archivo 'funciones.php' donde recogemos todos los datos de los cursos de nuestra BBDD
include "funciones.php";
if (isset($_SESSION['usuario']) && isset($_SESSION['contra'])) {
    // Pasamos las credenciales que almacenamos en nuestra sesión a variables por comodidad
    $usuario = $_SESSION['usuario'];
    $contra = $_SESSION['contra'];
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Cursos</title>
        <!-- Link a la hoja de estilos -->
        <link rel="stylesheet" href="estilos/main.css">
    </head>

    <body>
        <h1 id="primero">Bienvenido a tucurso.net</h1>
        <div id="contenedor">
            <h2>Lista de Cursos</h2>
            <!-- Tabla de cursos -->
            <table id="tabla_cursos">
                <thead>
                    <tr>
                        <th>Cursos disponibles</th>
                        <th>Plazas totales</th>
                        <th>Plazas disponibles</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // A continuación imprimimos todos los cursos con sus respectivas plazas y anclas para reservar plaza
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo "<tr>";
                        if ($ocupadas[$i] == $totales[$i]) {
                            echo "<td><del>$cursos[$i]</del></td> <td><del>$totales[$i]</del></td><td><del>$disponibles[$i]</del></td>";
                            echo "<td></td>";
                        } else {
                            echo "<td>$cursos[$i]</td> <td>$totales[$i]</td><td>$disponibles[$i]</td>";
                            echo "<td><a href='reservar.php?id=$identificador[$i]'>Reservar plaza</a></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            /*
                Si el usuario se identifica como 'root' (administrador) aparece un formulario para añadir cursos a la tabla
            */
            if ($usuario == "root") {
            ?>
                <h3>Añadir curso</h3>
                <div id="divAñadir">
                    <!-- Formulario para añadir cursos -->
                    <form action="añadir.php" method="POST" enctype="multipart/form-data">
                        <label for="in_curso" id="lab_curso" name="lab_curso">Curso</label>
                        <input type="text" id="in_curso" name="in_curso" placeholder="Nombre del curso" autofocus /> <br />
                        <label for="in_totales" id="lab_totales" name="lab_totales">Plazas totales</label>
                        <input type="number" id="in_totales" name="in_totales" placeholder="Plazas totales del curso" /> <br />
                        <input type="submit" id="in_submit" name="in_submit" value="Añadir" />
                    </form>
                </div>
            <?php
            }
            ?>
            <br></br>
            <h3>Resumen de ocupación:</h3>
            <!-- Lista desordenada para mostrar -->
            <ul>
            <?php
            // Imprimimos los resultados globales de nuestra BBDD
            echo "<li>Plazas totales ofertadas: " . array_sum($totales) . "</li>";
            echo "<li>Plazas ocupadas: " . array_sum($ocupadas) . "</li>";
            // Calculamos e imprimimos el porcentaje de plazas ocupadas
            echo "<li>Porcentaje de ocupación: " . round(array_sum($ocupadas) / array_sum($totales) * 100) . "%</li>";
        } else {
            // En caso de error mostramos un mensaje y un ancla a inicio
            echo "Ha ocurrido un error: Usuario no identificado <br />";
            echo "<a href='index.php'>Volver a inicio</a>";
        }
            ?>
            </ul>
            <!-- Enlace para cerrar sesión --> 
            <a href="index.php">Cerrar sesión</a>
        </div>
    </body>

    </html>