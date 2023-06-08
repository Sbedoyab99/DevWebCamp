<main class="auth">
	<h2 class="auth__heading"><?php echo $titulo ?></h2>
	<p class="auth__texto">
		Tu Cuenta en DevWebCamp
	</p>
	<?php require_once __DIR__ . '/../templates/alertas.php' ?>
	<div class="acciones">
		<a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? <b>Inicia Sesión</b></a>
		<a href="/olvide" class="acciones__enlace"><i>¿Olvidaste tu Contraseña?</i></a>
	</div>
</main>