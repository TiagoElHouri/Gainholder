<?php
	if(!isset($_SESSION['USER'])):

		if($_SERVER['REQUEST_METHOD'] == "POST"){

			$email = !empty($_POST['emailLogin']) ? $_POST['emailLogin'] : NULL;
			$senha = !empty($_POST['senhaLogin']) ? $_POST['senhaLogin'] : NULL;

			$login = new Login();
			$login->setEmail($email);
			$login->setSenha($senha);

			$permissions = new Permissions($login);
			$permissions->setTipo('usuario');
			$resultado   = $permissions->verifyLogin('site');
		}

 ?>     <!-- TELA DE LOGIN -->
		<form action="#" method="post" id="formulario-login" class="mostrar" style="background-color:#fff; border-radius:4px; margin-top:10%;">

			<fieldset style="width:350px;">

				<img src="<?php echo URL_SITE; ?>/	assets/img/palupa.png" width="196" height="102" class="center-block" />

				<?php
					if(isset($resultado['error'])) {
					  	echo logs($resultado['error'],'alert-danger');
					}
				?>

				<label for="email" class="naoalinhado">E-mail:
					<input  type="text" size="40" name="emailLogin" id="emailLogin"/>
				</label>

				<label for="senha" class="naoalinhado">Senha:
					<input type="password" size="40" name="senhaLogin" id="senhaLogin" />
				</label>

				<button type="submit" class="btn btn-laranja center-block" id="btnLogin" style="width:100%;">Entrar</button>
				<a class="btn center-block" style="border:1px solid; width:100%; margin-top:10px;" href="<?php echo URL_SITE ?>/perfil/esqueceuSenha">Esqueceu senha</a>
				<a class="btn center-block" style="border:1px solid; width:100%; margin-top:10px;" title="Cadastrar-se como usuário" href="<?php echo URL_SITE ?>/perfil/cadastrar">Cadastrar</a>
				<p style="text-align: center;"></p>

			</fieldset>
		</form>

		<script>
		$(function(){

			$('#formulario-login button[type="submit"]').click(function(e){

	 			e.preventDefault();

				// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
				$('#formulario-login').validate({
			        rules:{
						emailLogin: {
							required: true,
							email: true
						},
						senhaLogin: {
							required: true
						}
			        },
			        messages:{
			        	emailLogin: {
			        		required: "Campo obrigatório.",
			        		email: "Digite um e-mail válido."
			        	},
			        	senhaLogin: {
			        		required: "Campo obrigatório."
			        	}
			        }
			    });

			    if($("#formulario-login").valid()){

			    	$("#formulario-login").submit();
				}

	 		});

		});
		</script>
<?php
	
	else:
		var_dump($_GET);
		$url = explode('/',$_GET['pag']);

		if($url[0] == "esqueceu-senha"):
			include('recuperar-senha.php');
		endif;
	
	endif;
?>

