<?php
/**
 * Cadastro de objetos Assunto
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:24:39
 */
class CadastroAssunto {
	/**
	 * Repositório de classes Assunto
	 *
	 * @access private
	 * @var IRepositorioAssunto
	 */
	private $objRepositorioAssunto;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioAssunto $objRepositorioAssunto
	 */
	public function __construct(IRepositorioAssunto $objRepositorioAssunto) {
		$this->objRepositorioAssunto = $objRepositorioAssunto;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioAssunto
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoJaCadastradoException
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Assunto $objAssunto) {
		if ($this->existe($objAssunto->getIdAssunto()))
			throw new AssuntoJaCadastradoException($objAssunto->getIdAssunto());
		return $this->objRepositorioAssunto->inserir($objAssunto);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioAssunto
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Assunto $objAssunto) {
		$this->objRepositorioAssunto->atualizar($objAssunto);
	}
	
	/**
	 * Método que remove um objeto do RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdAssunto) {
		$this->objRepositorioAssunto->remover($intIdAssunto);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @return Assunto
	 */
	public function procurar($intIdAssunto) {
		return $this->objRepositorioAssunto->procurar($intIdAssunto);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdAssunto) {
		return $this->objRepositorioAssunto->existe($intIdAssunto);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioAssunto
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioAssunto->listar();
	}
	
	/**
	 * Método que lista todos os Assuntos Ativos do RepositorioAssunto
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivos() {
		return $this->objRepositorioAssunto->listarAtivos();
	}
	
	/**
	 * Método que lista todos os Assuntos do Grupo especificado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupo($intIdGrupo) {
		return $this->objRepositorioAssunto->listarPorIdGrupo($intIdGrupo);
	}
	
	/**
	 * Método que lista todos os Assuntos Ativos do Grupo especificado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosPorIdGrupo($intIdGrupo) {
		return $this->objRepositorioAssunto->listarAtivosPorIdGrupo($intIdGrupo);
	}
}