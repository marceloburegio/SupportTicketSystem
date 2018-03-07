<?php
/**
 * Cadastro de objetos Setor
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 19/06/2011 00:03:29
 */
class CadastroSetor {
	/**
	 * Repositório de classes Setor
	 *
	 * @access private
	 * @var IRepositorioSetor
	 */
	private $objRepositorioSetor;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioSetor $objRepositorioSetor
	 */
	public function __construct(IRepositorioSetor $objRepositorioSetor) {
		$this->objRepositorioSetor = $objRepositorioSetor;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioSetor
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @throws SetorJaCadastradoException
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Setor $objSetor) {
		if ($this->existe($objSetor->getIdSetor()))
			throw new SetorJaCadastradoException($objSetor->getIdSetor());
		return $this->objRepositorioSetor->inserir($objSetor);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioSetor
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Setor $objSetor) {
		$this->objRepositorioSetor->atualizar($objSetor);
	}
	
	/**
	 * Método que remove um objeto do RepositorioSetor
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdSetor) {
		$this->objRepositorioSetor->remover($intIdSetor);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioSetor
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws SetorNaoCadastradoException
	 * @return Setor
	 */
	public function procurar($intIdSetor) {
		return $this->objRepositorioSetor->procurar($intIdSetor);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioSetor
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdSetor) {
		return $this->objRepositorioSetor->existe($intIdSetor);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioSetor
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioSetor->listar();
	}
	
	/**
	 * Método que lista todos os Setores Ativos do RepositorioSetor
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivos() {
		return $this->objRepositorioSetor->listarAtivos();
	}
}