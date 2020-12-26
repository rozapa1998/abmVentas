<?php

    include_once "config.php";
    include_once "entidades/usuario.php";

    $usuario = new Usuario();
    $usuario->usuario = "rodrigozapata";
    $usuario->clave = $usuario->encriptarClave("admin123");
    $usuario->nombre = "Rodrigo";
    $usuario->apellido = "Zapata";
    $usuario->correo = "rodrigo@mail.com";
    $usuario->insertar();

?>