<?php

namespace Controllers;

use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
	public static function index(Router $router) {
		// Renderizo la pagina
		$router->render('admin/ponentes/index', [
			'titulo' => 'Ponentes / Conferencistas'
		]);
	}

	public static function crear(Router $router) {
		// Creo una nueva instancia de ponentes
		$ponente = new Ponente;
		// Creo un array de alertas vacio
		$alertas = [];
		// Si se envia el formulario:
		if($_SERVER['REQUEST_METHOD']  === 'POST') {
			// Si hay una imagen cargada:
			if(!empty($_FILES['imagen']['tmp_name'])) {
				// Declaro el directorio para guardar las imagenes
				$carpetaImagenes = '../public/img/speakers';
				// Si el directorio no existe:
				if(!is_dir($carpetaImagenes)) {
					// Creo el directorio
					mkdir($carpetaImagenes, 0755, true);
				}
				// Convierto la imagen a png y webp
				$image_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
				$image_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);
				// Creo un nombre unico para la imagen
				$nombreImagen = md5(uniqid(rand(), true));
				// Almaceno en $_POST el nombre de la imagen 
				$_POST['imagen'] = $nombreImagen;
			} 
			// Convierto el array de redes a un string en formato Json
			$_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
			// Sincronizo la informacion del formulario con la de ponente
			$ponente->sincronizar($_POST);
			// Valido que los campos esten bien diligenciados
			$alertas = $ponente->validar();
			// Si no hay alertas:
			if(empty($alertas)) {
				// Guardo la imagen en la carpeta en ambos formatos
				$image_png->save($carpetaImagenes . '/' . $nombreImagen . '.png');
				$image_png->save($carpetaImagenes . '/' . $nombreImagen . '.webp');
				// Guardar en la base de datos
				
				$resultado = $ponente->guardar();
				// Si se guardo el registro;
				if($resultado) {
					header('location: /admin/ponentes');
				}
			}
		}
		// Renderizo la pagina
		$router->render('admin/ponentes/crear', [
			'titulo' => 'Registrar Ponente',
			'alertas' => $alertas,
			'ponente' => $ponente
		]);
	}
}