<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Paquete;
use Model\Ponente;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController {
	public static function crear(Router $router) {
		isAuth();
		$registro = Registro::where('usuario_id', $_SESSION['id']);
		if(isset($registro) && $registro->paquete_id === '3') {
			header('location: /boleto?id=' . urlencode($registro->token));
		}
		$router->render('registro/crear', [
			'titulo' => 'Finalizar Registro'
		]);
	}

	public static function gratis() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			isAuth();
			$registro = Registro::where('usuario_id', $_SESSION['id']);
			if(isset($registro) && $registro->paquete_id === '3') {
				header('location: /boleto?id=' . urlencode($registro->token));
			}
			$token = substr(md5(uniqid(rand(), true)), 0, 8);
			$datos = [
				'paquete_id' => 3,
				'pago_id' => '',
				'token' => $token,
				'usuario_id' => $_SESSION['id'],
			];
			$registro = new Registro($datos);
			$resultado = $registro->guardar();
			if($resultado) {
				header('location: /boleto?id=' . urlencode($registro->token));
			}
		}
	}

	public static function boleto(Router $router) {
		$id = $_GET['id'];
		if(!$id || strlen($id) !== 8 ) {
			header('location: /');
		}
		$registro = Registro::where('token', $id);
		if(!$registro) {
			header('location: /');
		}
		$registro->usuario = Usuario::find($registro->usuario_id);
		$registro->paquete = Paquete::find($registro->paquete_id);

		$router->render('registro/boleto', [
			'titulo' => 'Asistencia a DevWebCamp',
			'registro' => $registro
		]);
	}

	public static function pagar() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			isAuth();
			if(empty($_POST)) {
				echo json_encode([]);
				return;
			}

			$datos = $_POST;
			$datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
			$datos['usuario_id'] = $_SESSION['id'];
			
			try {
				$registro = new Registro($datos);
				$resultado = $registro->guardar();
				echo json_encode($resultado);
			} catch (\Throwable $th) {
				echo json_encode([
					'resultado' => 'error'
				]);
			}
		}
	}

	public static function conferencias(Router $router) {
		isAuth();
		$usuario_id = $_SESSION['id'];
		$registro = Registro::where('usuario_id', $usuario_id);
		if($registro->paquete_id !== '1') {
			header('location: /');
		}
		$eventos = Evento::ordenar('hora_id', 'ASC');
		$eventosFormateados = [];
		foreach($eventos as $evento) {
			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);
			if($evento->dia_id === '1' && $evento->categoria_id === '1') {
				$eventosFormateados['conferenciasV'][] = $evento;
			}
			if($evento->dia_id === '2' && $evento->categoria_id === '1') {
				$eventosFormateados['conferenciasS'][] = $evento;
			}
			if($evento->dia_id === '1' && $evento->categoria_id === '2') {
				$eventosFormateados['workshopsV'][] = $evento;
			}
			if($evento->dia_id === '2' && $evento->categoria_id === '2') {
				$eventosFormateados['workshopsS'][] = $evento;
			}
		}

		$router->render('registro/conferencias', [
			'titulo' => 'Workshops y Conferencias ',
			'eventos' => $eventosFormateados
		]);
	}
}