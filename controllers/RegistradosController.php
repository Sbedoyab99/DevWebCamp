<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Paquete;
use Model\Ponente;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistradosController {
	public static function index(Router $router) {
		isAdmin();
		// Numero de Registros por pagina
		$registrosPP = 5;
		// Recupero la pagina actual
		$paginaActual = $_GET['page'];
		// Valido que la pagina actual sea un numero entero
		$paginaActual = filter_var($paginaActual, FILTER_VALIDATE_INT);
		// Si no esta declarada, si no es un entero o si es un numero negativo o 0:
		if(!$paginaActual || $paginaActual < 1) {
			// Redirecciono a la primer pagina
			header('location: /admin/registrados?page=1');
		}
		// Recupero el total de registros en la base de datos
		$totalRegistros = Registro::total();
		// Creo una nueva instancia para paginar
		$paginacion = new Paginacion($paginaActual, $registrosPP, $totalRegistros);
		// Si la pagina actual es mayor al total de paginas:
		if($paginacion->totalPaginas() < $paginaActual) {
			// Redirecciono
			header('location: /admin/registrados?page=1');
		}
		// Recupero los ponentes a recuperar en la pagina
		$registros = Registro::paginar($registrosPP, $paginacion->offset());
		foreach($registros as $registro) {
			$registro->usuario = Usuario::find($registro->usuario_id);
			$registro->paquete = Paquete::find($registro->paquete_id);
		}
		// Renderizo la pagina
		$router->render('admin/registrados/index', [
			'titulo' => 'Usuarios Registrados',
			'registros' => $registros,
			'paginacion' => $paginacion->paginacion()
		]);
	}
}