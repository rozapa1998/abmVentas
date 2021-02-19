<?php

    include_once "config.php";
    include_once "entidades/usuario.php";

    $usuario = new Usuario();
    $usuario->usuario = "Rodrigo1998";
    $usuario->clave = $usuario->encriptarClave("admin123");
    $usuario->nombre = "Rodrigo Agustin";
    $usuario->apellido = "Zapata Pantano";
    $usuario->correo = "rodrigo@mail.com";
    $usuario->insertar();

?>