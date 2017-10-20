$(function(){

	// ÁREA CADASTRO
		var urlRequest = URL+"library/Requests.php";

		$('#formulario-usuario input[type="submit"]').click(function(e){

		// VALIDAÇÃO DE E-MAIL EXISTENTE NO BANCO
		var emailUsuarioRef = $("#emailUsuarioRef").val();

 			e.preventDefault();	

			// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
			$('#formulario-usuario').validate({
		        rules:{
					nomeUsuario: {
						required: true
					},
					emailUsuario: {
						required: true,
						email: true,
						remote: {
							url: urlRequest,
							type: 	"POST",
							dataType: "json",
							data: {
								modulo : "usuarios",
							    acao   : "verificaEmail"
							}
						}
					},
					emailUsuarioEdit: {
						required: true,
						email: true,
						remote: {
							url: urlRequest,
							type: 	"POST",
							dataType: "json",
							data: {
								modulo           : "usuarios",
							    acao             : "verificaEmail",
							    emailUsuarioRef  : emailUsuarioRef
							}
						}
					},
					senhaUsuario: {
						equalTo: "#repetirSenhaUsuario"
					}
		        },
		        messages:{
		        	nomeUsuario: {
		        		required: "Campo obrigatório."
		        	},
		        	emailUsuario: {
		        		required: "Campo obrigatório.",
		        		email: "Digite um e-mail válido.",
		        		remote: "Esta conta já está registrada e sendo utilizada no momento!"
		        	},
		        	emailUsuarioEdit: {
		        		required: "Campo obrigatório.",
		        		email: "Digite um e-mail válido.",
		        		remote: "Esta conta já está registrada e sendo utilizada no momento!"
		        	},
		        	senhaUsuario: {
		        		equalTo: "As senhas digitadas não correspondem."
		        	}
		        }
		    });

		    if($("#formulario-usuario").valid()){

		    	$("#formulario-usuario").submit();

			}

 		});

});
