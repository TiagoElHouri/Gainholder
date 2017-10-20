$(function(){
	
		$('#escolhaPermissoes').uiEscolhaItens({
			msgSelecao: 'Escolha os módulos em que esse usuário terá permissão de uso.',
			msgAlerta:  'O módulo selecionado já foi escolhido ou nenhuma seleção foi feita.'
		});

		var urlRequest      = URL+"library/Requests.php";

		$('#formulario-administrador input[type="submit"]').click(function(e){

 			e.preventDefault();

			// VALIDAÇÃO DE E-MAIL EXISTENTE NO BANCO
			var emailAdminRef = $("#emailAdminRef").val();

			// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
			$('#formulario-administrador').validate({
		        rules:{
					nomeCompletoAdmin: {
						required: true
					},
					emailAdmin: {
						required: true,
						email: true,
						remote: {
							url: urlRequest,
							type: 	"POST",
							dataType: "json",
							data: {
								modulo : "administradores",
							    acao   : "verificaEmail"
							}
						}
					},
					emailAdminEdit: {
						required: true,
						email: true,
						remote: {
							url: urlRequest,
							type: 	"POST",
							dataType: "json",
							data: {
								modulo        : "administradores",
							    acao          : "verificaEmail",
							    emailAdminRef : emailAdminRef
							}
						}
					},
					senhaAdmin: {
						equalTo: "#repetirSenhaAdmin"
					}
		        },
		        messages:{
		        	nomeCompletoAdmin: {
		        		required: "Campo obrigatório."
		        	},
		        	emailAdmin: {
		        		required: "Campo obrigatório.",
		        		email: "Digite um e-mail válido.",
		        		remote: "O email já está cadastrado no sistema!"
		        	},
		        	emailAdminEdit: {
		        		required: "Campo obrigatório.",
		        		email: "Digite um e-mail válido.",
		        		remote: "O email já está cadastrado no sistema!"
		        	},
		        	senhaAdmin: {
		        		equalTo: "As senhas digitadas não correspondem."
		        	}
		        }
		    });

		    if($("#formulario-administrador").valid()){

		    	$('#listaModulosEscolhidos option').each(function(){
					$(this).prop('selected', true);
				});

		    	$("#formulario-administrador").submit();

			}

 		});

});
