<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController {
	public static function index(Router $router) {
		isAdmin();
		$paginaActual = $_GET['page'];
		$paginaActual = filter_var($paginaActual, FILTER_VALIDATE_INT);
		if(!$paginaActual || $paginaActual < 1) {
			header('location: /admin/eventos?page=1');
		}
		$registrosPP = 8;
		$totalRegistros = Evento::total();
		$paginacion = new Paginacion($paginaActual, $registrosPP, $totalRegistros);
		$eventos = Evento::paginar($registrosPP, $paginacion->offset());
		foreach($eventos as $evento) {
			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);
		}
		
		$router->render('admin/eventos/index', [
			'titulo' => 'Conferencias y Workshops',
			'eventos' => $eventos,
			'paginacion' => $paginacion->paginacion()
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

	public static function editar(Router $router) {
		isAdmin();
		$alertas = [];
		$id = $_GET['id'];
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if(!$id) {
			header('location: /admin/eventos?page=1');
		}
		$categorias = Categoria::all();
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');
		$evento = Evento::find($id);
		if(!$evento) {
			header('location: /admin/eventos?page=1');
		}

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

		$router->render('admin/eventos/editar', [
			'titulo' => 'Editar Evento',
			'alertas' => $alertas,
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas,
			'evento' => $evento
		]);
	}

	public static function eliminar() {
		// SI el metodo es $_POST:
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			isAdmin();
			// Recupero el id enviado
			$id = $_POST['id'];
			// Recupero el ponente con el id
			$evento = Evento::find($id);
			// Si no hay ponente:
			if(!isset($evento)) {
				//Redirecciono
				header('location: /admin/eventos');
			}
			// Elimino el ponente
			$resultado = $evento->eliminar();
			// Si se elimino correctamente:
			if($resultado) {
				// Redirecciono
				header('location: /admin/eventos');
			}
		}
	}
}