<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
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
			header('location: /admin/ponentes?page=1');
		}
		// Recupero el total de registros en la base de datos
		$totalRegistros = Ponente::total();
		// Creo una nueva instancia para paginar
		$paginacion = new Paginacion($paginaActual, $registrosPP, $totalRegistros);
		// Si la pagina actual es mayor al total de paginas:
		if($paginacion->totalPaginas() < $paginaActual) {
			// Redirecciono
			header('location: /admin/ponentes?page=1');
		}
		// Recupero los ponentes a recuperar en la pagina
		$ponentes = Ponente::paginar($registrosPP, $paginacion->offset());
		// Renderizo la pagina
		$router->render('admin/ponentes/index', [
			'titulo' => 'Ponentes / Conferencistas',
			'ponentes' => $ponentes,
			'paginacion' => $paginacion->paginacion()
		]);
	}

	public static function crear(Router $router) {
		isAdmin();
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
				$image_webp->save($carpetaImagenes . '/' . $nombreImagen . '.webp');
				// Guardar en la base de datos
				
				$resultado = $ponente->guardar();
				// Si se guardo el registro;
				if($resultado) {
					header('location: /admin/ponentes');
				}
			}
		}
		// Recupero las redes para autocompletar en caso de que haya un error
		$redes = json_decode($ponente->redes);
		// Renderizo la pagina
		$router->render('admin/ponentes/crear', [
			'titulo' => 'Registrar Ponente',
			'alertas' => $alertas,
			'ponente' => $ponente,
			'redes' => $redes
		]);
	}

	public static function editar(Router $router) {
		isAdmin();
		// Recuperamos el ID del ponente
		$id = $_GET['id'];
		$alertas = [];
		// Verificamos que el ID sea valido
		$id = filter_var($id, FILTER_VALIDATE_INT);
		// Si el id no es valido:
		if(!$id) {
			// Redireccionamos
			header('location: /admin/ponentes');
		}
		// Recuperamos el ponente con ese id
		$ponente = Ponente::find($id);
		// Si no se encuentra un ponente:
		if(!$ponente) {
			// Redireccionamos
			header('location: /admin/ponentes');
		}
		// Recupero el nombre de la imagen actual de la base de datos
		$ponente->imagen_actual = $ponente->imagen;
		// recupero el objeto json de la base de datos y lo convierto en un array
		$redes = json_decode($ponente->redes);
		// Si se guardan cambios:
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
				// Eliminar la imagen previa
				unlink($carpetaImagenes . '/' . $ponente->imagen_actual . ".png" );
				unlink($carpetaImagenes . '/' . $ponente->imagen_actual . ".webp" );
				// Convierto la imagen a png y webp
				$image_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
				$image_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);
				// Creo un nombre unico para la imagen
				$nombreImagen = md5(uniqid(rand(), true));
				// Almaceno en $_POST el nombre de la imagen 
				$_POST['imagen'] = $nombreImagen;
			// Si no hay imagen cargada:	
			} else {
				// almaceno en $_POST la imagen actual
				$_POST['imagen'] = $ponente->imagen_actual;
			}
			// Convierto el array de redes a un string en formato Json
			$_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
			// Sincronizo la informacion de ponente con la informacion de $_POST
			$ponente->sincronizar($_POST);
			// Reviso que todos los campos esten bien diligenciados
			$alertas = $ponente->validar();
			// Si no hay alertas:
			if(empty($alertas)) {
				// Si hay una nueva imagen:
				if(isset($nombreImagen)) {
					// Guardo la imagen en la carpeta en ambos formatos
					$image_png->save($carpetaImagenes . '/' . $nombreImagen . '.png');
					$image_webp->save($carpetaImagenes . '/' . $nombreImagen . '.webp');
				}
				// Guardamos la informacion
				$resultado = $ponente->guardar();
				// Si se guardo correctamente:
				if($resultado) {
					// Redireccionamos
					header('location: /admin/ponentes');
				}
			}
		}
		// Renderizo la pagina
		$router->render('admin/ponentes/crear', [
			'titulo' => 'Actualizar Ponente',
			'alertas' => $alertas,
			'ponente' => $ponente,
			'redes' => $redes
		]);
	}

	public static function eliminar() {
		isAdmin();
		// SI el metodo es $_POST:
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Recupero el id enviado
			$id = $_POST['id'];
			// Recupero el ponente con el id
			$ponente = Ponente::find($id);
			// Si no hay ponente:
			if(!isset($ponente)) {
				//Redirecciono
				header('location: /admin/ponentes');
			}
			// Elimino el ponente
			$resultado = $ponente->eliminar();
			// Si se elimino correctamente:
			if($resultado) {
				// Redirecciono
				header('location: /admin/ponentes');
			}
		}
	}
}