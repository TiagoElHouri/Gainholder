<div class="row">

	<div class="col-md-12">

		<section class="modulo">

			<div class="row">

				<div class="col-md-12">

					<header class="m-cabecalho">
                        <h2>Gerenciar Usuários</h2>
					</header>

					<div class="sessao">

						<div id="labelMessage">
							<span></span>
						</div>

                        <fieldset>

                            <legend>Novo usuário</legend>

                            <label class="alinhado">
                                <a class="btn btn-laranja" href="<?php echo URL ?>usuarios/cadastrar" style="color: #fff;">Novo usuário</a>
                            </label>

                        </fieldset>

                        <fieldset>
                            
                            <form id="formulario-busca-palavra-chave" action="#" method="POST" style="margin-top:1px;">

                                <div class="col-md-2">
                                    <input type="text" name="buscaNome" id="buscaNome" class="form-control busca-palavras" placeholder="Nome ...">
                                </div>

                                <div class="col-md-1" style="margin-left:-90px;"></div>

                                <div class="col-md-2">
                                    <button type="button" id="buscarUsuarios" class="btn btn-success active">Buscar &nbsp;&nbsp;<div class="glyphicon glyphicon-search"></div></button>
                                </div>

                            </form>

                        </fieldset>

                        <!-- TABELA DE USUÁRIOS -->
                            <?php echo $usuarios; ?>
                        <!-- /FIM DA TABELA GERADA DINÂMICAMENTE ---->


						<?php 
							$pagination = new Paginator('usuarios u',"u.id as usuarioId, l.id as loginId, nivelId, nome, sexo, dataNascimento, telefone, celular, cpf, email, status",
                                                            "INNER JOIN login l ON (l.usuarioId = u.id) $condicao ",$limite, $url,$pg);

	                        $pagination->makeInterface();
                        ?>      
                	</div>
            	</div>
            </div>
        </section>
    </div>
</div>

<script>

    $(document).ready(function(){
        $(document).keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                $("#buscarUsuarios").trigger("click");
            }
        });
    });

    $(function() {

        // URL PARA ENVIO DE PARÂMETRO POR AJAX
        var URL = '<?php echo URL; ?>library/Requests.php';

        //REALIZAR BUSCA
        $("#buscarUsuarios").click(function(){

            var nome  = $("#buscaNome").val()  != "" ? $("#buscaNome").val()  : "indefinido";

            window.location = "<?php echo URL; ?>usuarios/buscar/"+nome+"/1";
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
                                modulo    : 'usuarios',
                                acao      : 'delete',
                                id        : idAdminstrador,
                                idUsuario : idUsuario,
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

                            	alert('erro');
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
    <p>Você tem certeza que deseja remover esse usuário ?</p>
</div>