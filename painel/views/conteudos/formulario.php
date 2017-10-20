<div class="x_panel">
	<div class="x_title">
		<h2>Conteúdos <small>cadastro</small></h2>
		<div class="clearfix"></div>
	</div>

	<div class="x_content">
		<br />
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria*</label>
				<div class="col-md-6 col-sm-9 col-xs-12">
					<select class="select2_single form-control" tabindex="-1">
						<option value="">Selecione uma categoria...</option>
						<option value="AK">Alaska</option>
						<option value="HI">Hawaii</option>
						<option value="CA">California</option>
						<option value="NV">Nevada</option>
						<option value="OR">Oregon</option>
						<option value="WA">Washington</option>
						<option value="AZ">Arizona</option>
						<option value="CO">Colorado</option>
						<option value="ID">Idaho</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NM">New Mexico</option>
						<option value="ND">North Dakota</option>
						<option value="UT">Utah</option>
						<option value="WY">Wyoming</option>
						<option value="AR">Arkansas</option>
						<option value="IL">Illinois</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="OK">Oklahoma</option>
						<option value="SD">South Dakota</option>
						<option value="TX">Texas</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Imagem Destaque <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="file" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Titulo <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			<div class="form-group">
				
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Conteúdo (Texto) 
				<span class="required">*</span>
				</label>
				
				<div id="alerts"></div>

				<div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
					<div class="btn-group">
						<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
						<ul class="dropdown-menu">
						</ul>
					</div>

					<div class="btn-group">
						<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a data-edit="fontSize 5">
									<p style="font-size:17px">Huge</p>
								</a>
							</li>
							<li>
								<a data-edit="fontSize 3">
									<p style="font-size:14px">Normal</p>
								</a>
							</li>
							<li>
								<a data-edit="fontSize 1">
									<p style="font-size:11px">Small</p>
								</a>
							</li>
						</ul>
					</div>

					<div class="btn-group">
						<a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
						<a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
						<a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
						<a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
					</div>

					<div class="btn-group">
						<a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
						<a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
						<a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
						<a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
					</div>

					<div class="btn-group">
						<a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
						<a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
						<a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
						<a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
					</div>

					<div class="btn-group">
						<a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
						<div class="dropdown-menu input-append">
							<input class="span2" placeholder="URL" type="text" data-edit="createLink" />
							<button class="btn" type="button">Add</button>
						</div>
						<a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
					</div>

					<div class="btn-group">
						<a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
						<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
					</div>

					<div class="btn-group">
						<a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
						<a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
					</div>
				</div>

				<div id="editor-one" class="editor-wrapper"></div>

				<textarea name="descr" id="descr" style="display:none;"></textarea>
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
			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<button type="submit" class="btn btn-success">Cadastrar</button>
					<a href="<?php echo URL ?>/conteudos" class="btn btn-info">Voltar</a>
				</div>
			</div>
		</form>
	</div>
</div>

