<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Setores
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorSetor {
	/**
	 * Repositório da Classe Setor
	 *
	 * @access private
	 * @var IRepositorioSetor
	 */
	private $objRepositorioSetor;
	
	/**
	 * Método construtor da classe
	 * 
	 * @param IRepositorioSetor $objRepositorioSetor
	 */
	public function __construct(IRepositorioSetor $objRepositorioSetor = null) {
		$this->objRepositorioSetor = $objRepositorioSetor;
	}
	
	/**
	 * Método que cadastra o setor no RepositorioSetor
	 * 
	 * @param string $strDescricaoSetor
	 * @param string $strCodigoCentroCusto
	 * @param boolean $bolStatusSetor
	 */
	public function cadastrarSetor($strDescricaoSetor, $strCodigoCentroCusto, $bolStatusSetor) {
		// Inicializando os cadastros
		$objCadastroSetor = new CadastroSetor($this->objRepositorioSetor);
		
		// Removendo os espaços vazios
		$strDescricaoSetor		= (string) trim($strDescricaoSetor);
		$strCodigoCentroCusto	= (string) trim($strCodigoCentroCusto);
		$bolStatusSetor			= (boolean) $bolStatusSetor;
		
		// Validando os dados
		if (strlen($strDescricaoSetor) < 1)		throw new CampoObrigatorioException("Descrição do Setor");
		if (strlen($strCodigoCentroCusto) < 1)	throw new CampoObrigatorioException("Código do Centro de Custo");
		
		// Cadastrando o objeto
		$intIdSetor = 0;
		$objSetor = new Setor($intIdSetor, $strDescricaoSetor, $strCodigoCentroCusto, $bolStatusSetor);
		$objCadastroSetor->cadastrar($objSetor);
	}
	
	/**
	 * Método que lista todos os Setores Ativos no RepositorioSetor
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarSetoresAtivos() {
		$objCadastroSetor = new CadastroSetor($this->objRepositorioSetor);
		return $objCadastroSetor->listarAtivos();
	}
}