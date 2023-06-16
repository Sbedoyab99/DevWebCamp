<header class="header">
	<div class="header__contenedor">
		<nav class="header__navegacion">
			<?php if(Auth()) { ?>
				<a href="<?php echo (Admin() ? '/admin/dashboard' : '/finalizar-registro') ?>" class="header__enlace">Administrar</a>
				<form class="header__form" method="POST" action="/logout">
					<input type="submit" value="Cerrar Sesión" class="header__submit">
				</form>
			<?php } else { ?>
				<a href="/registro" class="header__enlace">Registrarse</a>
				<a href="/login" class="header__enlace">Iniciar Sesión</a>
			<?php } ?>
		</nav>
		<div class="header__contenido">
			<a href="/">
				<h1 class="header__logo">&#60;DevWebCamp /></h1>
			</a>
			<p class="header__texto">Octubre 5-6/2023</p>
			<p class="header__texto header__texto--modalidad">Virtual - Presencial</p>
		</div>
		<a href="/registro" class="header__boton">Comprar Pase</a>
	</div>
</header>
<div class="barra">
	<div class="barra__contenido">
		<a href="/"><h2 class="barra__logo">&#60;DevWebCamp /></h2></a>
		<nav class="navegacion">
			<a href="/devwebcamp" class="navegacion__enlace">Evento</a>
			<a href="/paquetes" class="navegacion__enlace">Paquetes</a>
			<a href="/eventos" class="navegacion__enlace">Workshops / Conferencias</a>
			<a href="/registro" class="navegacion__enlace">Comprar Pase</a>
		</nav>
	</div>
</div>