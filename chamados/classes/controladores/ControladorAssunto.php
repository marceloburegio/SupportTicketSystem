<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Assuntos
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorAssunto {
	/**
	 * Repositório da Classe Assunto
	 *
	 * @access private
	 * @var IRepositorioAssunto
	 */
	private $objRepositorioAssunto;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioAssunto $objRepositorioAssunto = null
	 */
	public function __construct(IRepositorioAssunto $objRepositorioAssunto = null) {
		$this->objRepositorioAssunto = $objRepositorioAssunto;
	}
	
	/**
	 * Método que cadastra o Assunto no RepositorioAssunto
	 * 
	 * @param int $intIdGrupo
	 * @param String $strDescricaoAssunto
	 * @param int $intSla
	 * @param string $strAlertaChamado
	 * @param string $strFormatoChamado
	 * @param string $strUrlChamadoExterno
	 * @return void
	 */
	public function cadastrarAssunto($intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno) {
		// Inicializando os cadastros
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		
		// Removendo os espaços vazios
		$intIdGrupo				= (int) $intIdGrupo;
		$strDescricaoAssunto	= (string) trim($strDescricaoAssunto);
		$intSla					= (int) $intSla;
		$strAlertaChamado		= (string) trim($strAlertaChamado);
		$strFormatoChamado		= (string) ltrim($strFormatoChamado);
		$strUrlChamadoExterno	= (string) trim($strUrlChamadoExterno);
		
		// Validando os dados
		if ($intIdGrupo < 0)					throw new CampoObrigatorioException("ID do Grupo");
		if (strlen($strDescricaoAssunto) < 1)	throw new CampoObrigatorioException("Descrição do Assunto");
		if ($intSla < 0)						throw new CampoObrigatorioException("SLA");
		
		// Criando o Assunto
		$intIdAssunto		= 0;
		$bolStatusAssunto	= true;
		$objAssunto			= new Assunto($intIdAssunto, $intIdGrupo, $strDescricaoAssunto, $bolStatusAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno);
		
		// Cadastrando o Assunto
		$objCadastroAssunto->cadastrar($objAssunto);
	}
	
	/**
	 * Método que atualiza o Assunto no RepositorioAssunto
	 * 
	 * @param int $intIdAssunto
	 * @param int $intIdGrupo
	 * @param String $strDescricaoAssunto
	 * @param int $intSla
	 * @param string $strAlertaChamado
	 * @param string $strFormatoChamado
	 * @param string $strUrlChamadoExterno
	 * @return void
	 */
	public function atualizarAssunto($intIdAssunto, $intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno) {
		// Inicializando os cadastros
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		
		// Removendo os espaços vazios
		$intIdAssunto			= (int) $intIdAssunto;
		$intIdGrupo				= (int) $intIdGrupo;
		$strDescricaoAssunto	= (string) trim($strDescricaoAssunto);
		$intSla					= (int) $intSla;
		$strAlertaChamado		= (string) trim($strAlertaChamado);
		$strFormatoChamado		= (string) ltrim($strFormatoChamado);
		$strUrlChamadoExterno	= (string) trim($strUrlChamadoExterno);
		
		// Validando os dados
		if ($intIdAssunto < 0)					throw new CampoObrigatorioException("ID do Assunto");
		if ($intIdGrupo < 0)					throw new CampoObrigatorioException("ID do Grupo");
		if (strlen($strDescricaoAssunto) < 1)	throw new CampoObrigatorioException("Descrição do Assunto");
		if ($intSla < 0)						throw new CampoObrigatorioException("SLA");
		
		// Recuperando o objeto Assunto
		$objAssunto = $objCadastroAssunto->procurar($intIdAssunto);
		
		// Atualizando o Assunto
		$objAssunto->setIdGrupo($intIdGrupo);
		$objAssunto->setDescricaoAssunto($strDescricaoAssunto);
		$objAssunto->setSla($intSla);
		$objAssunto->setAlertaChamado($strAlertaChamado);
		$objAssunto->setFormatoChamado($strFormatoChamado);
		$objAssunto->setUrlChamadoExterno($strUrlChamadoExterno);
		$objCadastroAssunto->atualizar($objAssunto);
	}
	
	/**
	 * Método que cancela o Assunto no RepositorioAssunto
	 * 
	 * @param int $intIdAssunto
	 * @return void
	 */
	public function cancelarAssunto($intIdAssunto) {
		// Inicializando os cadastros
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		
		// Removendo os espaços vazios
		$intIdAssunto = (int) $intIdAssunto;
		
		// Validando os dados
		if ($intIdAssunto < 0) throw new CampoObrigatorioException("ID do Assunto");
		
		// Recuperando o objeto Assunto
		$objAssunto = $objCadastroAssunto->procurar($intIdAssunto);
		
		// Atualizando o Assunto
		$bolStatusAssunto = false;
		$objAssunto->setStatusAssunto($bolStatusAssunto);
		$objCadastroAssunto->atualizar($objAssunto);
	}
	
	/**
	 * Método que procura um Assunto no RepositorioAssunto
	 * 
	 * @param int $intIdAssunto
	 * @return void
	 */
	public function procurarAssuntoPorIdAssunto($intIdAssunto) {
		// Inicializando os cadastros
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		
		// Removendo os espaços vazios
		$intIdAssunto = (int) $intIdAssunto;
		
		// Validando os dados
		if ($intIdAssunto < 0) throw new CampoObrigatorioException("ID do Assunto");
		
		// Recuperando o objeto o Assunto
		return $objCadastroAssunto->procurar($intIdAssunto);
	}
	
	/**
	 * Método que lista todos os Assuntos do RepositorioAssunto
	 * 
	 * @access public
	 * @return array
	 */
	public function listarAssuntos() {
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		return $objCadastroAssunto->listar();
	}
	
	/**
	 * Método que lista todos os Assuntos do Grupo especificado no RepositorioAssunto
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarAssuntosPorIdGrupo($intIdGrupo) {
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		return $objCadastroAssunto->listarPorIdGrupo($intIdGrupo);
	}
	
	/**
	 * Método que lista todos os Assuntos Ativos do Grupo no RepositorioAssunto
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarAssuntosAtivosPorIdGrupo($intIdGrupo) {
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		return $objCadastroAssunto->listarAtivosPorIdGrupo($intIdGrupo);
	}
}