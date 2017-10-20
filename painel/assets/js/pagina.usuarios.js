$(function(){

		$('#telefoneUsuario').focusout(function(){
		    var phone, element;
		    element = $(this);
		    element.unmask();
		    phone = element.val().replace(/\D/g, '');
		    if(phone.length > 10) {
		        element.mask("(99) 99999-999?9");
		    } else {
		        element.mask("(99) 9999-9999?9");	
		    }
		}).trigger('focusout');

		$('#celularUsuario').focusout(function(){
		    var phone, element;
		    element = $(this);
		    element.unmask();
		    phone = element.val().replace(/\D/g, '');
		    if(phone.length > 10) {
		        element.mask("(99) 99999-999?9");
		    } else {
		        element.mask("(99) 9999-9999?9");	
		    }
		}).trigger('focusout');

		$("#cpfUsuario").mask('999.999.999-99');

		var urlRequest      = URL+"library/Requests.php";

		$('#formulario-usuario input[type="submit"]').click(function(e){

		// VALIDAÇÃO DE E-MAIL EXISTENTE NO BANCO
		var emailUsuarioRef  = $("#emailUsuarioRef").val();

 			e.preventDefault();	

			// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO
			$('#formulario-usuario').validate({
		        rules:{
					nomeCompletoUsuario: {
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
					},
					dataNascimentoUsuario:{
						required: true
					}
		        },
		        messages:{
		        	nomeCompletoUsuario: {
		        		required: "Campo obrigatório."
		        	},
		        	emailUsuario: {
		        		required: "Campo obrigatório.",
		        		email: "Digite um e-mail válido.",
		        		remote: "O email já está cadastrado no sistema!"
		        	},
		        	emailUsuarioEdit: {
		        		required: "Campo obrigatório.",
		        		email: "Digite um e-mail válido.",
		        		remote: "O email já está cadastrado no sistema!"
		        	},
		        	senhaUsuario: {
		        		equalTo: "As senhas digitadas não correspondem."
		        	},
		        	dataNascimentoUsuario:{
						required: "Campo obrigatório."
					}
		        }
		    });

		    if($("#formulario-usuario").valid()){

		    	$("#formulario-usuario").submit();

			}

 		});

});
