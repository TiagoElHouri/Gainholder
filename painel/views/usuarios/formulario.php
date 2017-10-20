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
										echo "<script>setTimeout(function(){window.location='".URL.'usuarios'."'} , 900);</script>";	
									}
								}else{
									echo logs($mensagem['error'],'alert-danger');
								}
							}	

						?>

						<form enctype="multipart/form-data" method="post" class="form-horizontal" action="<?php echo URL ?>usuarios/<?php echo $action ?>" id="formulario-usuario">

							<fieldset class="fieldset-cadastro">

								<legend> <?php echo $legend; ?> usuário </legend>

								<div class="form-group"> 
                                    <label class="col-sm-4">Foto de perfil:
                                        <?php if (isset($usuario) && ($usuario->getFotoPerfil() != null)):  ?>
                                            <div class="show-image-logotipo">
                                            	<img src="<?php echo URL_SITE ?>/assets/img/upload/usuarios_fotoPerfil/<?= $usuario->getFotoPerfil() ?>" width="140px" style="border:1px solid #000;"/>
                                            </div>
                                        <?php else: ?>
                                            <div class="show-image-logotipo">
                                            	<img src="<?php echo URL_SITE ?>/assets/img/sem-imagem.jpg" width="140px" style="border:1px solid #000;"/>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" size="45" id="usuariosFotoPerfil"  name="usuariosFotoPerfil"/>
                                        <?php if(isset($usuario)): ?>
                                        <input type="hidden" name="nomeImagem" value="<?php echo ($usuario->getFotoPerfil() != null) ? $usuario->getFotoPerfil() : ''; ?>"> 
                                    	<?php endif; ?>
                                    </label>
                                </div>

								<div class="form-group">

									<label class="alinhado col-sm-8">
										<input type="text" name="nomeCompletoUsuario" id="nomeCompletoUsuario" placeholder="Nome Completo" value="<?php echo isset($usuario) ? $usuario->getNome() : "" ?>">
									</label>

									<label class="naoalinhado col-sm-8">
										<?php

											if(isset($usuario) && $usuario->getLogin()->getEmail() != "") :
										?>
												<input type="text"   name="emailUsuarioEdit" id="emailUsuarioEdit" placeholder="E-mail" value="<?php echo isset($usuario) ? $usuario->getLogin()->getEmail() : "" ?>">
												<input type="hidden" name="emailUsuarioRef"  id="emailUsuarioRef"  placeholder="E-mail" value="<?php echo isset($usuario) ? $usuario->getLogin()->getEmail() : "" ?>">
										<?php
											else :
										?>
												<input type="text" name="emailUsuario" id="emailUsuario" placeholder="E-mail" value="<?php echo isset($usuario) ? $usuario->getLogin()->getEmail() : "" ?>">
										<?php
											endif;
										?>
									</label>

								</div>

								<div class="form-group">

									<label class="naoalinhado col-sm-4">
										<input type="password" name="senhaUsuario" id="senhaUsuario" placeholder="Senha">
									</label>

									<label class="alinhado col-sm-4">
										<input type="password" name="repetirSenhaUsuario" id="repetirSenhaUsuario" placeholder="Repetir Senha">
									</label>

								</div>

								<legend>Informações Adicionais</legend>

								<div class="form-group">
									<label class="naoalinhado col-sm-4"> Sexo 
										<?php $sexo = isset($usuario) ? $usuario->getSexo() : ""; ?> 
										<label><input type="radio" name="sexoUsuario" id="sexoUsuario" value="masculino" <?php echo ($sexo != "" && $sexo == "masculino")  ? 'checked' : ' '; ?>>&nbsp;Masculino</label>
										<label><input type="radio" name="sexoUsuario" id="sexoUsuario" value="feminino"  <?php echo ($sexo != "" && $sexo == "feminino")   ? 'checked' : ' '; ?>>&nbsp;Feminino</label>
									</label>
								</div>
								
								<div class="form-group">
									<label class="naoalinhado col-sm-4"> Data de Nascimento 
										<input type="date" name="dataNascimentoUsuario" id="dataNascimentoUsuario" value="<?php echo isset($usuario) ? $usuario->getDataNascimento() : "" ?>">
									</label>
								</div>

								<div class="form-group">
									
									<label class="naoalinhado col-sm-4">
										<input type="text" name="telefoneUsuario" id="telefoneUsuario" placeholder="Telefone" value="<?php echo isset($usuario) ? $usuario->getTelefone() : "" ?>">
									</label>
									
									<label class="alinhado col-sm-4">
										<input type="text" name="celularUsuario" id="celularUsuario" placeholder="Celular" value="<?php echo isset($usuario) ? $usuario->getCelular() : "" ?>">
									</label>
								
								</div>
								
								<div class="form-group">
									<label class="naoalinhado col-sm-4">
										<input type="text" name="cpfUsuario" id="cpfUsuario" placeholder="CPF" value="<?php echo isset($usuario) ? $usuario->getCpf() : "" ?>">
									</label>
								</div>

								<fieldset id="escolhaPermissoes" class="escolha-itens">
							        
							        <legend>Permissões</legend>
									
									<?php $status = isset($usuario) ? $usuario->getLogin()->getStatus() : ""; ?> 
									<label>Acesso:</label>
									<select name="acessoUsuario" id="acessoUsuario">
										<option value="-1" selected>Selecione o status...</option>
										<option value="1" <?php echo ($status != "" && $status == 1)  ? 'selected' : ''; ?>> Liberar uso do sistema </option>
										<option value="0" <?php echo ($status != "" && $status == 0)  ? 'selected' : ''; ?>> Bloquear uso do sistema </option>
									</select>
									
									<?php $nivel = isset($usuario) ? $usuario->getNivel() : 4; ?>
									
									<?php if($nivel > 1  AND $nivel <=4): ?>
										<label>Nível:</label>
										<select name="nivelUsuario" id="nivelUsuario">
											<option value="2" <?php echo ($nivel != "" && $nivel == 2)  ? 'selected' : ''; ?>> Comum </option>
										</select>
									<?php else: ?>
										<input type="hidden" name="nivelUsuario" value="<?php echo $nivel; ?>">
									<?php endif; ?>

								</fieldset>
								
								<input type="hidden" name="idLogin" value="<?php echo isset($usuario) ? $usuario->getLogin()->getId() : '';?>">
								<input type="hidden" name="modulo" value="usuario">
								<input type="submit" name="<?php echo $name; ?>" class="btn btn-laranja" value="Enviar">
								<p style=" margin-top: -27px; width: 80px; border-left: 1px solid #000; margin-left: 69px; padding-left: 10px;"><a href="<?php echo URL ?>usuarios">Voltar</a></p>

							</fieldset>	
						</form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
