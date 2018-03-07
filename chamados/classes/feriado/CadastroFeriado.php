<?php
/**
 * Cadastro de objetos Feriado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
class CadastroFeriado {
	/**
	 * Repositório de classes Feriado
	 *
	 * @access private
	 * @var IRepositorioFeriado
	 */
	private $objRepositorioFeriado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioFeriado $objRepositorioFeriado
	 */
	public function __construct(IRepositorioFeriado $objRepositorioFeriado) {
		$this->objRepositorioFeriado = $objRepositorioFeriado;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioFeriado
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @throws FeriadoJaCadastradoException
	 * @throws FeriadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Feriado $objFeriado) {
		if ($this->existe($objFeriado->getIdFeriado()))
			throw new FeriadoJaCadastradoException($objFeriado->getIdFeriado());
		return $this->objRepositorioFeriado->inserir($objFeriado);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioFeriado
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Feriado $objFeriado) {
		$this->objRepositorioFeriado->atualizar($objFeriado);
	}
	
	/**
	 * Método que remove um objeto do RepositorioFeriado
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdFeriado) {
		$this->objRepositorioFeriado->remover($intIdFeriado);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioFeriado
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @return Feriado
	 */
	public function procurar($intIdFeriado) {
		return $this->objRepositorioFeriado->procurar($intIdFeriado);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioFeriado
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdFeriado) {
		return $this->objRepositorioFeriado->existe($intIdFeriado);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioFeriado
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioFeriado->listar();
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioFeriado pelo Id do Grupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupo($intIdGrupo) {
		return $this->objRepositorioFeriado->listarPorIdGrupo($intIdGrupo);
	}
	
	/**
	 * Método que ira verificar a existencia de um determinado feriado pelo Id do Grupo e Data do Feriado
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strDataFeriado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existePorIdGrupoPorDataFeriado($intIdGrupo, $strDataFeriado) {
		return $this->objRepositorioFeriado->existePorIdGrupoPorDataFeriado($intIdGrupo, $strDataFeriado);
	}
}