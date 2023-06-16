<main class="agenda">
	<h2 class="agenda__heading">Workshops & Conferencias</h2>
	<p class="agenda__descripcion">Talleres y Conferencias dictadas por expertos en desarrollo web</p>
	<div class="eventos">
		<h3 class="eventos__heading">&lt;Conferencias /></h3>
		<p class="eventos__fecha">Viernes 5 de Octubre</p>
		<div class="eventos__listado">
			<?php foreach($eventos['conferenciasV'] as $evento) { ?>
				<div class="evento">
					<p class="evento__hora"><?php echo $evento->hora->hora ?></p>
					<div class="evento__informacion">
						<h4 class="evento__nombre"><?php echo $evento->nombre ?></h4>
						<p class="evento__introduccion"><?php echo $evento->descripcion ?></p>
						<div class="evento__autor-info">
							<picture>
								<source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen ?>.webp" type="image/webp">
								<source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen ?>.png" type="image/png">
								<img loading="lazy" class="evento__autor-imagen" src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen ?>.png" alt="Imagen Ponente">
							</picture>
							<p class="evento__autor-nombre">
								<?php echo $evento->ponente->nombre . ' ' .  $evento->ponente->apellido?>
							</p>
						</div>
					</div>
				</div>
			<?php } ?>	
		</div>
		<p class="eventos__fecha">Sabado 6 de Octubre</p>
		<div class="eventos__listado">

		</div>
	</div>
	<div class="eventos eventos--workshops">
		<h3 class="eventos__heading">&lt;Workshops /></h3>
		<p class="eventos__fecha">Viernes 5 de Octubre</p>
		<div class="eventos__listado">

		</div>
		<p class="eventos__fecha">Sabado 6 de Octubre</p>
		<div class="eventos__listado">

		</div>
	</div>
</main>