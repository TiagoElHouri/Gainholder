<?php

	if(!isset($url[1])):

		if($_SERVER['REQUEST_METHOD'] == "POST"){

			$email = !empty($_POST['emailLogin']) ? $_POST['emailLogin'] : NULL;

			$login = new Login();
			$login->setEmail($email);

			$permissions = new Permissions($login);
			$resultado   = $permissions->recuperarSenha('painel');
		}
?>

		<form class="login" action="#" method="post" id="formulario-recuperar-senha" class="mostrar" style="background-color:#fff; border-radius:4px;">
			
			<fieldset style="width:350px;">
				
				<img src="<?php echo URL; ?>assets/img/palupa.png" width="196" height="102" class="center-block" />

				<?php 
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

<?php else: ?>

		<?php

			if($_SERVER['REQUEST_METHOD'] == "POST"){

				$senha = !empty($_POST['senhaLogin']) ? md5($_POST['senhaLogin']) : NULL;

				$login = new Login();
				$login->setSenha($senha);

				$permissions = new Permissions($login);
				$resultado   = $permissions->renovarSenha($url[1]);
			}
		?>

		<form class="login" action="#" method="post" id="formulario-nova-senha" class="mostrar" style="background-color:#fff; border-radius:4px;">

			<fieldset style="width:350px;">

				<img src="<?php echo URL; ?>assets/img/palupa.png" width="196" height="102" class="center-block" />

				<?php 
					if(isset($resultado)) {

						if(isset($resultado['error'])){

							echo logs($resultado['error'],'alert-danger');
						}else{

							echo logs($resultado['success'],'alert-success');
						}
					}
				?>

				<label for="senha" class="naoalinhado">Nova Senha:
					<input type="password" size="40" name="senhaLogin" id="senhaLogin" />
				</label>

				<button type="submit" class="btn btn-laranja" id="btnLogin" style="width:100%;">Confirmar</button>
				<a class="btn center-block" style="border:1px solid; width:100%; margin-top:10px;" href="<?php echo URL ?>">Fazer login</a>
				<p style="text-align: center;"></p>
				
			</fieldset>
		</form>

		<script>
		$(function(){

				$('#formulario-nova-senha button[type="submit"]').click(function(e){

		 			e.preventDefault();

					// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
					$('#formulario-nova-senha').validate({
				        rules:{
							senhaLogin: {
								required: true,
							}
				        },
				        messages:{
				        	emailLogin: {
				        		required: "Campo obrigatório.",
				        	}
				        }
				    });

				    if($("#formulario-nova-senha").valid()){

				    	$("#formulario-nova-senha").submit();
					}

		 		});

		});
		</script>

<?php endif; ?>

