<?php

namespace Controllers;

use Model\EventoHorario;
use Model\Regalo;
use Model\Registro;

class APIRegalos {
	public static function index() {
		isAdmin();
		$regalos = Regalo::get(9, 'ASC');
		foreach($regalos as $regalo) {
			$regalo->total = Registro::totalAray(['regalo_id' => $regalo->id, 'paquete_id' => '1']);
		}
		echo json_encode($regalos);
	}
}