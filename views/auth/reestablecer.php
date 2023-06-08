<main class="auth">
	<h2 class="auth__heading"><?php echo $titulo ?></h2>
	<p class="auth__texto">Ingresa tu Nueva Contraseña</p>
	<?php require_once __DIR__ . '/../templates/alertas.php' ?>
	<?php if($token_valido) {?>
		<form class="formulario" method="POST" novalidate>
			<div class="formulario__campo">
				<label for="password" class="formulario__label">Nueva Contraseña</label>
				<input 
					type="password"
					class="formulario__input"
					placeholder="Ingresa tu Nueva Contraseña"
					id="password"
					name="password">
			</div>
			<div class="formulario__campo">
				<label for="password2" class="formulario__label">Repite tu Contraseña</label>
				<input 
					type="password"
					class="formulario__input"
					placeholder="Repite tu Nueva Contraseña"
					id="password2"
					name="password2">
			</div>
			<input type="submit" class="formulario__submit" value="Reestablecer Contraseña">
		</form>
	<?php } ?>
	<div class="acciones">
		<a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? <b>Inicia Sesión</b></a>
		<a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? <b>Crea una</b></a>
	</div>
</main>