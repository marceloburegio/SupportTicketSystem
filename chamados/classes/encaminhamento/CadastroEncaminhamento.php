<?php
/**
 * Cadastro de objetos Encaminhamento
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 23:06:26
 */
class CadastroEncaminhamento {
	/**
	 * Repositório de classes Encaminhamento
	 *
	 * @access private
	 * @var IRepositorioEncaminhamento
	 */
	private $objRepositorioEncaminhamento;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioEncaminhamento $objRepositorioEncaminhamento
	 */
	public function __construct(IRepositorioEncaminhamento $objRepositorioEncaminhamento) {
		$this->objRepositorioEncaminhamento = $objRepositorioEncaminhamento;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @throws EncaminhamentoJaCadastradoException
	 * @throws EncaminhamentoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Encaminhamento $objEncaminhamento) {
		if ($this->existe($objEncaminhamento->getIdEncaminhamento()))
			throw new EncaminhamentoJaCadastradoException($objEncaminhamento->getIdEncaminhamento());
		return $this->objRepositorioEncaminhamento->inserir($objEncaminhamento);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Encaminhamento $objEncaminhamento) {
		$this->objRepositorioEncaminhamento->atualizar($objEncaminhamento);
	}
	
	/**
	 * Método que remove um objeto do RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdEncaminhamento) {
		$this->objRepositorioEncaminhamento->remover($intIdEncaminhamento);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @return Encaminhamento
	 */
	public function procurar($intIdEncaminhamento) {
		return $this->objRepositorioEncaminhamento->procurar($intIdEncaminhamento);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdEncaminhamento) {
		return $this->objRepositorioEncaminhamento->existe($intIdEncaminhamento);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioEncaminhamento
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioEncaminhamento->listar();
	}
	
	/**
	 * Método que lista todos os objetos por chamado do RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdChamado($intIdChamado) {
		return $this->objRepositorioEncaminhamento->listarPorIdChamado($intIdChamado);
	}
	
	/**
	 * Método que verifica se existe algum objeto por chamado no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existePorIdChamado($intIdChamado) {
		return $this->objRepositorioEncaminhamento->existePorIdChamado($intIdChamado);
	}
}