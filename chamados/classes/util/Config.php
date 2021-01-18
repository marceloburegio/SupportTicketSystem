<?php
/**
 * Classe de configurações do sistema
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 27/05/2011 16:26:17
 */
final class Config {
	/**
	 * Método construtor da classe
	 *
	 * @access private
	 */
	private function __construct() {
	}
	
	/**
	 * Método que retorna uma string contendo a URL Base do sistema
	 * 
	 * @access public
	 * @return string
	 */
	public static function getUrlBase() {
		return "http://localhost/SupportTicketSystem/chamados";
	}
	
	/**
	 * Método que retorna uma string contendo o endereço do remetente do email
	 * 
	 * @access public
	 * @return string
	 */
	public static function getRemetenteEmail() {
		return "Chamados <chamados@your-domain.com>";
	}
	
	/**
	 * Método que retorna uma string contendo o domínio de email principal
	 * 
	 * @access public
	 * @return string
	 */
	public static function getDominioEmail() {
		return "your-domain.com";
	}
	
	/**
	 * Método que retorna uma string contendo a mensagem de erro padrão adicional
	 * 
	 * @access public
	 * @return string
	 */
	public static function getMensagemErroPadrao() {
		return "Caso não seja possível corrigi-lo, favor entrar em contato com o administrador explicando todos os passos do erro para uma possível solução.";
	}
	
	/**
	 * Método que retorna uma string contendo a mensagem do rodape
	 * 
	 * @access public
	 * @return string
	 */
	public static function getMensagemRodape() {
		return "&copy; Desenvolvido por <a href=\"https://github.com/marceloburegio\">Marcelo Buregio</a> - ". date("Y");
	}
	
	/**
	 * Método que retorna o endereço do servidor de autenticação
	 * 
	 * @access public
	 * @return string
	 */
	public static function getServidorAD() {
		return "your-active-directory.domain";
	}
	
	/**
	 * Método que retorna nome do domínio que o sistema irá autenticar
	 * 
	 * @access public
	 * @return string
	 */
	public static function getDominioAD() {
		return "YOUR-AD-DOMAIN";
	} 
	
	/**
	 * Método que retorna a quantidade de chamados por página
	 * 
	 * @access public
	 * @return int
	 */
	public static function getChamadosPorPagina() {
		return 20;
	}
	
	/**
	 * Método que retorna o vetor com os status dos chamados
	 * 
	 * @access public
	 * @return array
	 */
	public static function getStatus() {
		return array(1=>"Aberto", 2=>"Fechado", 3=>"Pendente", 9=>"Cancelado");
	}
	
	/**
	 * Método que retorna o vetor com as prioridades dos chamados
	 * 
	 * @access public
	 * @return array
	 */
	public static function getPrioridades() {
		return array(1=>"Baixa", 2=>"Normal", 3=>"Alta", 4=>"Urgente");
	}
	
	/**
	 * Método que retorna um vetor com os icones das prioridades
	 * 
	 * @access public
	 * @return array
	 */
	public static function getImagensPrioridades() {
		return array(1=>"seta_prioridade_baixa.gif", 2=>"seta_prioridade_normal.gif", 3=>"seta_prioridade_alta.gif", 4=>"seta_prioridade_urgente.gif");
	}
	
	/**
	 * Método que retorna a quantidade de caracteres exibida no resumo da descrição do chamado
	 * 
	 * @access public
	 * @return string
	 */
	public static function getQtdeCaracteresDescricao() {
		return 75;
	}
	
	/**
	 * Método que retorna a string contendo o path dos arquivos anexos
	 * 
	 * @access public
	 * @return string
	 */
	public static function getCaminhoArquivosAnexos() {
		return realpath(dirname(__FILE__) ."/../../arquivos/");
	}
	
	/**
	 * Método que retorna um vetor com os tipos de históricos
	 * 
	 * @access public
	 * @return array
	 */
	public static function getTiposHistorico() {
		return array(1=>"Normal", 2=>"Abertura",3=>"Fechamento",4=>"Encaminhamento", 5=>"Reabertura",6=>"Cancelamento",7=>"Leitura",8=>"Reclassificação");
	}
	
	/**
	 * Método que retorna a quantidade máxima de barras exibidas no gráfico de barras
	 * 
	 * @access public
	 * @return string
	 */
	public static function getQtdeMaxBarrasGrafico() {
		return 11;
	}
	
}