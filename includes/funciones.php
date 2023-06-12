<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
function paginaActual($path) : bool {
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}
function isAuth() : void {
    session_start();
    if(isset($_SESSION['nombre']) && !empty($_SESSION)){
        return;
    }   else {
        header('location: /login');
    }
}
function isAdmin() : void {
    session_start();
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])){
        return;
    } else {
        header('location: /login');
    }
}
