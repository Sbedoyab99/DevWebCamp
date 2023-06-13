<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;

class EventosController {
	public static function index(Router $router) {
		isAdmin();
		$router->render('admin/eventos/index', [
			'titulo' => 'Conferencias y Workshops'
		]);
	}

	public static function crear(Router $router) {
		isAdmin();
		$alertas = [];
		$categorias = Categoria::all();
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');
		$evento = new Evento;

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$evento->sincronizar($_POST);
			$alertas = $evento->validar();
			if(empty($alertas)) {
				$resultado = $evento->guardar();
				if($resultado) {
					header('location: /admin/eventos');
				}
			}
		}

		$router->render('admin/eventos/crear', [
			'titulo' => 'Crear Evento',
			'alertas' => $alertas,
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas,
			'evento' => $evento
		]);
	}
}