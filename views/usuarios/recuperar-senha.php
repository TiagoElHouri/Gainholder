<?php

	if(!isset($url[1])):

		if($_SERVER['REQUEST_METHOD'] == "POST"){

			$email = !empty($_POST['emailLogin']) ? $_POST['emailLogin'] : NULL;

			$login = new Login();
			$login->setEmail($email);

			$permissions = new Permissions($login);
			$resultado   = $permissions->recuperarSenha('site');
		}
?>

		<form class="" action="#" method="post" id="formulario-recuperar-senha" class="mostrar" style="background-color:#fff; border-radius:4px; margin-top:10%;">

			<fieldset style="width:350px;">

				<img src="<?php echo URL_SITE; ?>/assets/img/palupa.png" width="196" height="102" class="center-block" />

				<?php

					// EXIBIÇÃO DO RESULTADO DE ENVIO DE E-MAIL PARA REDEFINIÇÃO DE SENHA
					if(isset($resultado)) {

						if(isset($resultado['error'])){

							echo logs($resultado['error'],'alert-danger');
						}else{

							echo logs($resultado['success'],'alert-success');
						}
					}
				?>

				<label for="email" class="naoalinhado">E-mail:
					<input  type="text" size="40" name="emailLogin" id="emailLogin"/>
				</label>

				<button type="submit" class="btn btn-laranja" id="btnLogin" style="width:100%;">Reenviar senha</button>
				<p style="text-align: center;"></p>

			</fieldset>
		</form>

		<script>
		$(function(){

				$('#formulario-recuperar-senha button[type="submit"]').click(function(e){

		 			e.preventDefault();

					// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
					$('#formulario-recuperar-senha').validate({
				        rules:{
							emailLogin: {
								required: true,
								email: true
							}
				        },
				        messages:{
				        	emailLogin: {
				        		required: "Campo obrigatório.",
				        		email: "Digite um e-mail válido."
				        	}
				        }
				    });

				    if($("#formulario-recuperar-senha").valid()){

				    	$("#formulario-recuperar-senha").submit();
					}

		 		});

		});
		</script>

<?php endif; ?>