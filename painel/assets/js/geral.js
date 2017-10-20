		


		// // SLICKNAV
		// $('.menu-superior').slicknav({
		// 	'label' : 'MENU',
		// 	'prependTo' : '.menu-mobile'
		// });

		// // BANNER APP
		// $.smartbanner({ 
		// 	daysHidden: 5,
		//  	daysReminder: 15, 
		//  	title:'Exemplo',
		//  	price: 'Grátis',
		//  	inGooglePlay: 'no Google Play',
		//  	inAppStore: 'no App Store',
		//  	inWindowsStore: 'no Windows Store',
		//  	button: 'Baixar',
		//  	author: 'Exemplo',
		//  	scale: 'auto',
	 // 	});

		function BuscarCep(URL){

			var URL = URL+"library/Requests.php";

	        var cep = $('.cep').val();
	        $.ajax({
	            url: URL,
	            type: 'GET',
	            data : {
	            			modulo : "correios",
	                        acao   : "consultaCep",
	                        cep    : cep,
	                    },
	            dataType: 'json',
	            cache: false,
	            success: function (resp) {

		            if(typeof(resp) != "undefined" && resp !== null){

		            	if(resp.Erro){

		            		alert(resp.Erro);
		            	}

						cep            = cep.replace('-', '');

		                var estado     = resp.estado;
		                var cidade     = resp.cidade;
		                var bairro     = resp.bairro;
		                var logradouro = resp.logradouro;

						if(cep.length == 8){


							$('.pais option[value="Brasil"]').attr('selected', 'selected');
						}
						
		                $('.estado option').removeAttr('selected');
		                // $('.estado option[value="' + estado + '"]').attr('selected', 'selected');
		                $('.cidade option').removeAttr('selected');
		                // $('.cidade option[value="' + cidade + '"]').attr('selected', 'selected');
		    			$('input.estado').val(estado);
		    			$('input.cidade').val(cidade);
		                $('input.logradouro').attr('value', logradouro);
		                $('input.bairro').attr('value', bairro);
		                $(".numero").focus();
			        }
	            }        
	        });
		}

		/* PLUGIN DELAY P/ KEYUP */ 
		var Delay = (function(){

		  var timer = 0;
		  return function(callback, ms){

		    clearTimeout(timer);
		    timer = setTimeout(callback, ms);
		  };
		})();