
	<div class="row">

		<div class="col-md-12">
			<!-- VISUALIZAÇÃO DAS INFORMAÇÕES DOS USUÁRIOS -->
			<section class="modulo">

				<!-- 12 -->
				<div class="row">

					<div class="col-md-12">

						<header class="m-cabecalho col-sm-4" style="left:30px;">
							<h2><?php echo $usuario[0]['nome']; ?> ▼</h2>
						</header>

						<header class="m-cabecalho" style="position:absolute; right:20px;">
							<h2><button type="button" class="btn btn-lg center-block" id="btnLogout" style="width:100%;">Logout &nbsp<span class="glyphicon glyphicon-log-out"></span></button></h2>
						</header>

						<div class="row sessao">

							<div class="col-md-12">

								<label class="alinhado col-sm-4">Foto de perfil:
			                        <div class="show-image-logotipo">
	                                    <img src="<?php echo URL_SITE ?>/assets/img/upload/usuarios_perfil/perfil_default.jpg?>" width="140px" style="border:1px solid #000;"/>
	                                </div>
                                </label>

                                <label class="naoalinhado col-sm-4">Nome: <?php echo $usuario[0]['nome'];?></label>

								<label class="naoalinhado col-sm-4">Sexo: <?php echo $usuario[0]['sexo'];?></label>

								<label class="naoalinhado col-sm-4">Data nascimento: <?php echo implode("/",array_reverse(explode("-",$usuario[0]['dataNascimento'])));?></label>

								<label class="naoalinhado col-sm-4">Telefone: <?php echo $usuario[0]['telefone'];?></label>

								<label class="naoalinhado col-sm-4">Celular: <?php echo $usuario[0]['celular'];?></label>

								<label class="naoalinhado col-sm-4">E-mail: <?php echo $usuario[0]['login'][0]['email'];?></label>

							</div>
						</div>
	                </div>
	            </div>

	        </section>
	    </div>
	</div>

	<script type="text/javascript">

		$(function(){

			// LOGOUT DO USUÁRIO QUE ESTÁ VISUALIZANDO SEU PERFIL
			$('#btnLogout').on('click',function(){

				window.location='<?php echo URL_SITE?>'+'/logout';
			});

		});
	</script>