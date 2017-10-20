<div class="row">

	<div class="col-md-12">

		<section class="modulo">

			<!-- 12 -->
			<div class="row">

				<div class="col-md-12">

					<header class="m-cabecalho">
						<h2><?php echo $title; ?> Usuário ▼</h2>
					</header>

					<div class="sessao">

						<?php

							if($resultado){

								if(isset($mensagem['success'])){

									echo logs($mensagem['success'],'alert-success');

									if(!isset($id)){

										echo "<script>setTimeout(function(){window.location='".URL_SITE.'/perfil'."'} , 900);</script>";
									}
								}else{

									echo logs($mensagem['error'],'alert-danger');
								}
							}
						?>

						<!-- TELA PARA CADASTRO VIA ÁREA DO SITE -->
						<form method="post" class="form-horizontal" action="<?php echo URL_SITE ?>/perfil/<?php echo $action ?>" id="formulario-usuario">

							<fieldset class="fieldset-cadastro">

									<legend> <?php echo $legend; ?> usuário </legend>

									<div class="form-group">

										<label class="col-md-4">Nome
											<input type="text" name="nomeUsuario" id="nomeUsuario" placeholder="Nome Completo" value="<?php echo isset($usuario) ? $usuario->getNome() : "" ?>">
										</label>

									</div>

									<div class="form-group">

										<label class="col-md-4">Email
											<input type="text" name="emailUsuario" id="emailUsuario" placeholder="E-mail" value="<?php echo isset($usuario) ? $usuario->getLogin()->getEmail() : "" ?>">
										</label>

									</div>

									<legend>
										Dados de Acesso
									</legend>

									<div class="form-group">

										<label class="col-md-4">
											<input type="password" name="senhaUsuario" id="senhaUsuario" placeholder="Senha">
										</label>

									</div>

									<div class="form-group">

										<label class="col-md-4">
											<input type="password" name="repetirSenhaUsuario" id="repetirSenhaUsuario" placeholder="Repetir Senha">
										</label>

									</div>

								<input type="hidden" name="idLogin" value="<?php echo isset($usuario) ? $usuario->getLogin()->getId() : '';?>">
								<input type="hidden" name="modulo" value="usuario">
								<input type="hidden" id="id_nivelUsuario" name="id_nivelUsuario" value="2">
								<input type="submit" name="<?php echo $name; ?>" class="btn btn-laranja" value="Efetuar cadastro">
								<p style=" margin-top: -27px; width: 80px; border-left: 1px solid #000; margin-left: 69px; padding-left: 80px;"><a href="<?php echo URL_SITE ?>/perfil">Voltar</a></p>

							</fieldset>
						</form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
