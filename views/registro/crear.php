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
			<div id="smart-button-container">
    			<div style="text-align: center;">
        			<div id="paypal-button-container"></div>
    			</div>
			</div>
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

<!-- Reemplazar CLIENT_ID por tu client id proporcionado al crear la app desde el developer dashboard) -->
<script src="https://www.paypal.com/sdk/js?client-id=AVwUdXmeNqP9l_DNlmRmgYdGEQwcAoh9ReIRIrv5vRGw7z1LBK1HPySCPwxMcTQhHfNuUlG6CFMaAmAj&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
 
<script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}]
          });
        },
 
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
 
			const datos = new FormData();
			datos.append('paquete_id', orderData.purchase_units[0].description)
			datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id)
			url = '/finalizar-registro/pagar'

			fetch(url, {
				method: 'POST',
				body: datos
			})
			.then(respuesta => respuesta.json())
			.then(resultado => {
				if(resultado.resultado) {
					actions.redirect('http://localhost:3000/finalizar-registro/conferencias')
				}
			})
            
          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
 
  initPayPalButton();
</script>