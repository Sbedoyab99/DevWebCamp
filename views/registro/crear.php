<main class="registro">
	<h2 class="registro__heading"><?php echo $titulo ?></h2>
	<p class="registro__descripcion">Elige tu plan</p>
	<div class="paquetes__grid">
		<div class="paquete">
			<h3 class="paquete__nombre">Pase Gratis</h3>
			<ul class="paquete__lista">
				<li class="paquete--elemento">
					Acceso Virtual a DevWebCamp
				</li>
			</ul>
			<p class="paquete__precio">$0</p>
			<form method="POST" action="/finalizar-registro/gratis">
				<input type="submit" class="paquetes__submit" value="Inscripcion Gratis">
			</form>
		</div>
		<div class="paquete">
			<h3 class="paquete__nombre">Pase Presencial</h3>
			<ul class="paquete__lista">
				<li class="paquete--elemento">
					Acceso Presencial a DevWebCamp
				</li>
				<li class="paquete--elemento">
					Pase por 2 dias
				</li>
				<li class="paquete--elemento">
					Acceso a Talleres y conferencias
				</li>
				<li class="paquete--elemento">
					Acceso a las Grabaciones
				</li>
				<li class="paquete--elemento">
					Camisa del Evento
				</li>
				<li class="paquete--elemento">
					Refrigerio
				</li>
			</ul>
			<p class="paquete__precio">$50</p>
			
		</div>
		<div class="paquete">
			<h3 class="paquete__nombre">Pase Virtual</h3>
			<ul class="paquete__lista">
				<li class="paquete--elemento">
					Acceso Virtual a DevWebCamp
				</li>
				<li class="paquete--elemento">
					Pase por 2 dias
				</li>
				<li class="paquete--elemento">
					Acceso a Talleres y conferencias
				</li>
				<li class="paquete--elemento">
					Acceso a las Grabaciones
				</li>
			</ul>
			<p class="paquete__precio">$25</p>
		</div>
	</div>
</main>