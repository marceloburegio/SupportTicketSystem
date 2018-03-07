<?php
/**
 * Classe para o envio de email
 *
 * @author Marcelo Burégio
 * @subpackage util
 * @version 1.0
 * @since 08/10/2008 15:06
 */
// Include
require_once('phpmailer_5.2.9/class.phpmailer.php');

class Email {
	
	/**
	 * Método construtor da classe
	 *
	 * @access private
	 */
	private function __construct() {
	}
	
	/**
	 * Método estático que envia emails
	 *
	 * @access public
	 * @param string $strRemetente
	 * @param string $strDestinatario
	 * @param string $strAssunto
	 * @param string $strMensagem
	 * @return boolean
	 */
	public static function enviar($strRemetente, $strDestinatario, $strAssunto, $strMensagem) {
		// Removendo os espaços vazios
		$strRemetente		= trim($strRemetente);
		$strDestinatario	= trim($strDestinatario);
		$strAssunto			= trim($strAssunto);
		$strMensagem		= trim($strMensagem);
		
		// Verificando se os dados foram setados
		if (empty($strRemetente) || empty($strDestinatario) || empty($strAssunto) || empty($strMensagem)) return false;
		
		// Inicializando o Mailer e a linguagem pt-br
		$mail = new PHPMailer(true);
		$mail->setLanguage("br");
		$mail->Encoding = "quoted-printable";
		
		// Definindo o remetente
		$arrRemetentes = Email::separaEmails($strRemetente);
		$mail->setFrom($arrRemetentes[0]["email"], $arrRemetentes[0]["nome"]);
		
		// Definindo o destinatário
		$arrDestinatarios = Email::separaEmails($strDestinatario);
		foreach ($arrDestinatarios as $arrDestinatario) $mail->addAddress($arrDestinatario["email"], $arrDestinatario["nome"]);
		
		// Definindo o assunto
		$mail->Subject = $strAssunto;
		
		// Adicionando a mensagem em HTML
		$mail->msgHTML($strMensagem);
		
		// Enviando o email para o destinatário
		if (!$mail->send()) throw new Exception($mail->ErrorInfo);
		return true;
	}
	
	/**
	 * Método estático que separa os emails retornando um array com os nomes e emails
	 *
	 * @access public
	 * @param string $strEmails
	 * @return array
	 */
	private static function separaEmails($strEmails) {
		$arrEmails = array();
		$arrListaEmails = explode(",", $strEmails);
		foreach ($arrListaEmails as $strEmail) {
			$strEmail = trim($strEmail);
			if (preg_match('/^([^<]*)<([^>]*)>$/', $strEmail, $arrEmail)) {
				$strNome = trim(str_replace('"', "", $arrEmail[1]));
				$strEmail = trim($arrEmail[2]);
			}
			else {
				$strNome = $strEmail;
			}
			$arrEmails[] = array("nome" => $strNome, "email" => $strEmail);
		}
		return $arrEmails;
	}
}