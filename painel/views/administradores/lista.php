
<div class="x_panel">
	<div class="x_title">
		<h2>Gerenciar Acessos<small>Administradores</small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">

		<div class="buttons">
			<a href="<?php echo URL ?>/administradores/cadastrar" class="btn btn-primary btn-sm"><i class="fa fa-file"></i> Novo administrador</button>	
			</a>

			<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Sobrenome</th>
						<th>E-mail</th>
						<th>Status</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Tiger</td>
						<td>Nixon</td>
						<td>System Architect</td>
						<td>Edinburgh</td>
						<td>61</td>
					</tr>
					<tr>
						<td>Garrett</td>
						<td>Winters</td>
						<td>Accountant</td>
						<td>Tokyo</td>
						<td>63</td>
					</tr>
					<tr>
						<td>Ashton</td>
						<td>Cox</td>
						<td>Junior Technical Author</td>
						<td>San Francisco</td>
						<td>66</td>
					</tr>
					<tr>
						<td>Cedric</td>
						<td>Kelly</td>
						<td>Senior Javascript Developer</td>
						<td>Edinburgh</td>
						<td>22</td>
					</tr>
					<tr>
						<td>Airi</td>
						<td>Satou</td>
						<td>Accountant</td>
						<td>Tokyo</td>
						<td>33</td>
					</tr>
					<tr>
						<td>Brielle</td>
						<td>Williamson</td>
						<td>Integration Specialist</td>
						<td>New York</td>
						<td>61</td>
					</tr>
					<tr>
						<td>Herrod</td>
						<td>Chandler</td>
						<td>Sales Assistant</td>
						<td>San Francisco</td>
						<td>59</td>
					</tr>
					<tr>
						<td>Rhona</td>
						<td>Davidson</td>
						<td>Integration Specialist</td>
						<td>Tokyo</td>
						<td>55</td>
					</tr>
					<tr>
						<td>Colleen</td>
						<td>Hurst</td>
						<td>Javascript Developer</td>
						<td>San Francisco</td>
						<td>39</td>
					</tr>
					<tr>
						<td>Sonya</td>
						<td>Frost</td>
						<td>Software Engineer</td>
						<td>Edinburgh</td>
						<td>23</td>
					</tr>
					<tr>
						<td>Jena</td>
						<td>Gaines</td>
						<td>Office Manager</td>
						<td>London</td>
						<td>30</td>
					</tr>
					<tr>
						<td>Quinn</td>
						<td>Flynn</td>
						<td>Support Lead</td>
						<td>Edinburgh</td>
						<td>22</td>
					</tr>
					<tr>
						<td>Charde</td>
						<td>Marshall</td>
						<td>Regional Director</td>
						<td>San Francisco</td>
						<td>36</td>
					</tr>
				</tbody>
			</table>


		</div>
	</div>

<script>

	$(document).ready(function(){
		$(document).keypress(function(e) {
			if(e.which == 13) {
				e.preventDefault();
				$("#buscarAdministradores").trigger("click");
			}
		});
	});

	$(function() {

	// URL PARA ENVIO DE PARÂMETRO POR AJAX
	var URL = '<?php echo URL; ?>library/Requests.php';

	//REALIZAR BUSCA
	$("#buscarAdministradores").click(function(){

		var nome  = $("#buscaNome").val()  != "" ? $("#buscaNome").val()  : "indefinido";
		var email = $("#buscaEmail").val() != "" ? $("#buscaEmail").val() : "indefinido";
		
		window.location = "<?php echo URL; ?>administradores/buscar/"+nome+"/"+email+"/1";

	});


	$("#dialog-confirm").hide();
	$("#labelMessage").hide();
	
	$(".excluir").click(function(){
		
		var idAdminstrador = $(this).attr('data-id');
		var idUsuario      = $(this).attr('data-id-client');
		
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:300,
			width: 500,
			modal: true,
			buttons: {
				Remover: function() {

					$.ajax({
						url: URL,
						type: 'GET',
						data : {
							modulo    : 'administradores',
							acao      : 'delete',
							id        : idAdminstrador,
							idUsuario : idUsuario
						},
						dataType: 'json',
						cache: false,
						success: function (resp) {

							if(typeof(resp) != "undefined" && resp != null){

								if(resp.resultado){
									$("#labelMessage").attr('class','alert alert-success');
									$("#labelMessage span").text(resp.mensagem);
								}else{
									$("#labelMessage").attr('class','alert alert-danger')
									$("#labelMessage span").text(resp.mensagem);
								}

								$("#labelMessage").fadeIn(1000);

							}else{
								$("#labelMessage").attr('class','alert alert-danger');
								$("#message").text("Ocorreu algum erro ao remover!");
								$("#labelMessage").fadeIn(1000);
							}

						},

						error: function(resp) {
							alert("Data not found");
						}


					});

					$(this).dialog("close");

					setTimeout(function(){
						location.reload();
					}, 2000);

				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
});
</script>

<div id="dialog-confirm" title="Confirmação">
	<p>Você tem certeza que deseja remover esse administador ?</p>
</div>