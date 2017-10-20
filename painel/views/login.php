<?php  

	if((empty($_GET['pag']) && !isset($_SESSION['ADMIN']))):

		if($_SERVER['REQUEST_METHOD'] == "POST"){

			$email = !empty($_POST['emailLogin']) ? $_POST['emailLogin'] : NULL;
			$senha = !empty($_POST['senhaLogin']) ? $_POST['senhaLogin'] : NULL;

			$login = new Login();
			$login->setEmail($email);
			$login->setSenha($senha);

			$permissions = new Permissions($login);
			$permissions->setTipo('administrador');
			$resultado = $permissions->verifyLogin('painel');

			if(isset($resultado['success']) && $_SESSION['ADMIN']['PERMISSOES'] == ""){
				echo 'chegou logou';
				echo "<script>window.location='".URL.'administradores'."'</script>";
			}
		}

?>

<div>
	
	<a class="hiddenanchor" id="signup"></a>
	<a class="hiddenanchor" id="signin"></a>

	<div class="login_wrapper">
		<div class="animate form login_form">
			<section class="login_content">
				<form action="#" method="post" id="formulario-login">
					<h1>Login</h1>
					<?php
						if(isset($resultado['error'])) {
						  	echo logs($resultado['error'],'alert-danger');
						}
					?>
					<div>
						<input type="text" name="emailLogin" id="emailLogin" class="form-control" placeholder="E-mail" required="required" />
					</div>
					<div>
						<input type="password" name="senhaLogin" id="senhaLogin" class="form-control" placeholder="Senha" required="required" />
					</div>
					<div>
						<a class="btn btn-default submit" href="#">Entrar</a>
						<a class="reset_pass" href="<?php echo URL ?>/esqueceu-senha">Esqueceu a senha ?</a>
					</div>

					<div class="clearfix"></div>

					<div class="separator">

						<div class="clearfix"></div>
						<br />

						<div>
							<h1><i class="fa fa-building"></i> Gainholder</h1>
							<p>© 2017 Todos os direitos reservados.</p>
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
</div>

<script>
	$(function(){

			$('#formulario-login a.submit').click(function(e){

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
		
		$url = explode('/',$_GET['pag']);
		if($url[0] == "esqueceu-senha"): 
			include('recuperar-senha.php');
		endif;
	
	endif; 
?>

