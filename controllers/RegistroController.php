<?php

namespace Controllers;

use Model\Paquete;
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
}