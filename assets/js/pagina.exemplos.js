$(function(){

	$('#formulario-exemplo input[type="submit"]').click(function(e){

			e.preventDefault();	

		// VALIDAÇÃO DO FORMULÁRIO DE CADASTRO DE EXEMPLO
		$('#formulario-exemplo').validate({
	        rules:{
				campo1Exemplo: {
					required: true
				},
				campo2Exemplo:{
					required: true
				},
				campo3Exemplo:{
					required: true
				}
	        },
	        messages:{
	        	campo1Exemplo: {
	        		required: "Campo obrigatório."
	        	},
	        	campo2Exemplo: {
	        		required: "Campo obrigatório.",
	        	},
	        	campo3Exemplo:{
					required: "Campo obrigatório."
				}
	        }
	    });

	    if($("#formulario-exemplo").valid()){

	    	$("#formulario-exemplo").submit();
		}

	});

});
