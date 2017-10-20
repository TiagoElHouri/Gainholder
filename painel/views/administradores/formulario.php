<div class="x_panel">
	<div class="x_title">
		<h2>Administradores <small>cadastro</small></h2>
		<div class="clearfix"></div>
	</div>

	<div class="x_content">
		<br />
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
			
			<div class="form-group">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Foto perfil</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input id="middle-name" class="form-control col-md-7 col-xs-12" type="file" name="middle-name">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sobrenome <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div id="gender" class="btn-group" data-toggle="buttons">
						<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							<input type="radio" name="gender" value="male"> &nbsp; Permitido &nbsp;
						</label>
						<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
							<input type="radio" name="gender" value="female"> Bloqueado
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<legend> Configurar Permissões </legend>
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Módulos:</label>
				<div class="col-md-3 col-sm-9 col-xs-12">
				<?php 
					if(isset($modulos)): 
						foreach($modulos as $modulo):

							$alinhamento = $modulo->getIdPai() != 0 ? 'margin-left: 20px;' : '';
				?>
						<div style="<?php echo $alinhamento;  ?>" class="checkbox" data-id-pai="<?php echo $modulo->getIdPai(); ?>">
							<label>
								<input type="checkbox" class="flat opcao-modulo"  value="<?php echo $modulo->getId(); ?>" > <?php echo $modulo->getNome(); ?>
							</label>
						</div>
				<?php  
						endforeach;
					endif;
				?>
				</div>
				<div class="col-md-3 col-sm-9 col-xs-12">
					<div class="checkbox">
						<label>
							<input type="checkbox" class="flat opcao-modulo" value="0" > Todos
						</label>
					</div>
				</div>
			</div>
			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<button type="submit" class="btn btn-success">Cadastrar</button>
					<a href="<?php echo URL ?>/administradores" class="btn btn-info">Voltar</a>
				</div>
			</div>
		</form>
	</div>
</div>

