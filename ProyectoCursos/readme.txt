Cursos

# Descripción del documento:
Documentos.php:
~ index.php -> Página de inicio: contiene un formulario de registro e inicio de sesión
y código PHP para la conexión y comprobación de existencia del usuario además de su registro
en la base de datos.
~ main.php -> Página del usuario: muestra una tabla y un listado con los datos extraídos
de la base de datos. Utilizamos 'include' para llamar al archivo 'funciones.php' el cual 
extrae la información con la que rellenamos la tabla con la información de los cursos.
Por otro lado, mostramos la información global en la lista.
~ funciones.php -> Archivo externo codificado en PHP. Extrae la información de la base de datos
para volcarla posteriormente en la página 'main.php'.
~ añadir.php -> Página transitoria: en un principio el usuario no debería llegar a ver nunca
el contenido de este archivo en su navegador, este archivo contiene las instrucciones
para que el administrador (root) pueda añadir cursos a la base de datos desde la propia
aplicación.
~ reservar.php -> Página transitoria: en un principio el usuario no debería llegar a ver nunca
el contenido de este archivo en su navegador, este archivo contiene las instrucciones para 
modificar la información del curso del que el usuario desea reservar plaza dentro de la
base de datos.

Documentos.css:
inicio.css -> Contiene la hoja de estilo que se aplica sobre el index.php
main.css -> Contiene la hoja de estilo que se aplica sobre el main.php

En la carpeta BBDD se encuentra el documento cursos.txt que contiene la estructura e información
de nuestra base de datos.