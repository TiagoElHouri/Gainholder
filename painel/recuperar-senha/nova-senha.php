<?php

	include_once('../config/Config.php');
	include_once('../library/Autoload.php');
	include_once('../helpers/Helpers.php');

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$senha = !empty($_POST['senhaLogin']) ? md5($_POST['senhaLogin']) : NULL;

		$login = new Login();
		$login->setSenha($senha);

		$permissions = new Permissions($login);
		$resultado   = $permissions->renovarSenha($_GET['hash']);
	}
?>

	<!doctype html>
	<html lang="pt-br">

	    <head>
	        <meta charset="utf-8">
	        <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>Framework - Recuperar Senha</title>

	        <!-- CSS -->
	        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/bootstrap.min.css">
	        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/site.css">
	        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/painel.css">

	        <!-- JS -->
	        <script>var URL = '<?php echo URL; ?>';</script>
	        <script type="text/javascript" src="<?php echo URL ?>assets/js/jquery-1.11.3.js"></script>
	        <script type="text/javascript" src="<?php echo URL ?>assets/js/jquery-ui-1.10.3.min.js"></script>
	        <script type="text/javascript" src="<?php echo URL ?>assets/js/geral.js"></script>
	        <script type="text/javascript" src="<?php echo URL ?>assets/js/plugins.js"></script>
	        <script type="text/javascript" src="<?php echo URL ?>assets/js/bootstrap.js"></script>
	    </head>

	    <body>
	    	<div class="conteudo">

	   			<?php if (isset($_GET['hash']) && !empty($_GET['hash'])):  ?>

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
							        	senhaLogin: {
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

				<?php else: ?>

					<div class="col-md-12">    
				        <div class="alert alert-danger">
				            <span>Acesso incorreto a página.</span>
				        </div>
				    </div>

				<?php endif; ?>
			</div>
	    </body>
	</html>