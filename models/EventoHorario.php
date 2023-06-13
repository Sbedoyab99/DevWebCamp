<?php

namespace Model;

class EventoHorario extends ActiveRecord {
	protected static $tabla = 'eventos';
	protected static $columnasDB = ['id', 'categoria_id', 'hora_id', 'dia_id'];

	public $id;
	public $categoria_id;
	public $hora_id;
	public $dia_id;
}