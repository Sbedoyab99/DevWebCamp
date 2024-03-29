<main class="auth">
	<h2 class="auth__heading"><?php echo $titulo ?></h2>
	<p class="auth__texto">Ingresa tu Correo Para Recuperar tu Acceso a DevWebCamp</p>
	<?php require_once __DIR__ . '/../templates/alertas.php' ?>
	<form class="formulario" method="POST" novalidate>
		<div class="formulario__campo">
			<label for="email" class="formulario__label">Email</label>
			<input 
				type="email"
				class="formulario__input"
				placeholder="Ingresa tu Email"
				id="email"
				name="email">
		</div>
		<input type="submit" class="formulario__submit" value="Enviar Instrucciones">
	</form>
	<div class="acciones">
		<a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? <b>Inicia Sesión</b></a>
		<a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? <b>Crea una</b></a>
	</div>
</main>