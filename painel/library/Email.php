<?php
	
	// header('Content-Type: text/html; charset=utf-8');
	
	//require($_SERVER['DOCUMENT_ROOT'] . SITE_PATH . 'PHPMailer/class.phpmailer.php');

	require('PHPMailer/class.phpmailer.php');

	class Email {
		
		// MÉTODOS
		function __construct(){		

		}
		
		function Enviar($remetente, $remetenteNome, $destinatario, $destinatarioEmail, $assunto, $conteudo,$arquivo=null,$arquivo2=null,$destinatarioCC=null){
			
			$mail = new PHPMailer();
			
			$mail->CharSet 		='UTF-8';
			$mail->IsSMTP();
			$mail->SMTPAuth 	= true;
			$mail->Port 		= EMAIL_PORTA;
			$mail->SMTPSecure 	= EMAIL_SSL;
			$mail->Host 		= EMAIL_HOST;
			$mail->Username 	= EMAIL_USUARIO;
			$mail->Password 	= EMAIL_SENHA;
			
			$mail->SetFrom($remetente, $remetenteNome);
			$mail->AddAddress($destinatario, $destinatarioEmail);

			if($destinatarioCC != null){
				$mail->addCC($destinatarioCC);
			}
			
			$mail->Subject = $assunto;
			
			$mail->MsgHTML($conteudo);

			if($arquivo != null){
				$mail->addStringAttachment(file_get_contents($arquivo), 'boleto.pdf');
			}

			if($arquivo2 != null){
				$mail->addStringAttachment(file_get_contents($arquivo2), 'demonstrativo.pdf');
			}
			
			$enviaEmail = $mail->Send();

			if($enviaEmail == 1)
			{

			   return 1;
			}
			else
			{
			   return $mail->ErrorInfo;		
			}
		}
		
		function __destruct(){

		}
		
	}
?>