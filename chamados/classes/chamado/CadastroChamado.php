<?php
/**
 * Cadastro de objetos Chamado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:26:07
 */
class CadastroChamado {
	/**
	 * Repositório de classes Chamado
	 *
	 * @access private
	 * @var IRepositorioChamado
	 */
	private $objRepositorioChamado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioChamado $objRepositorioChamado
	 */
	public function __construct(IRepositorioChamado $objRepositorioChamado) {
		$this->objRepositorioChamado = $objRepositorioChamado;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioChamado
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @throws ChamadoJaCadastradoException
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Chamado $objChamado) {
		if ($this->existe($objChamado->getIdChamado()))
			throw new ChamadoJaCadastradoException($objChamado->getIdChamado());
		return $this->objRepositorioChamado->inserir($objChamado);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioChamado
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Chamado $objChamado) {
		$this->objRepositorioChamado->atualizar($objChamado);
	}
	
	/**
	 * Método que remove um objeto do RepositorioChamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdChamado) {
		$this->objRepositorioChamado->remover($intIdChamado);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioChamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws ChamadoNaoCadastradoException
	 * @return Chamado
	 */
	public function procurar($intIdChamado) {
		return $this->objRepositorioChamado->procurar($intIdChamado);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioChamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdChamado) {
		return $this->objRepositorioChamado->existe($intIdChamado);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioChamado
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioChamado->listar();
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioChamado
	 *
	 * @access public
	 * @param array $arrParametro
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarEnviadosPorParametro($arrParametro, $intOffSet, $intRows) {
		return $this->objRepositorioChamado->listarEnviadosPorParametro($arrParametro, $intOffSet, $intRows);
	}
	
	/**
	 * Método que conta a quantidade dos objetos do RepositorioChamado
	 *
	 * @access public
	 * @param array $arrParametro
	 * @throws RepositorioException
	 * @return array
	 */
	public function quantidadeEnviadosPorParametro($arrParametro) {
		return $this->objRepositorioChamado->quantidadeEnviadosPorParametro($arrParametro);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioChamado
	 *
	 * @access public
	 * @param array $arrParametro
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarRecebidosPorParametro($arrParametro, $intOffSet, $intRows) {
		return $this->objRepositorioChamado->listarRecebidosPorParametro($arrParametro, $intOffSet, $intRows);
	}
	
	/**
	 * Método que conta a quantidade dos objetos do RepositorioChamado
	 *
	 * @access public
	 * @param array $arrParametro
	 * @throws RepositorioException
	 * @return array
	 */
	public function quantidadeRecebidosPorParametro($arrParametro) {
		return $this->objRepositorioChamado->quantidadeRecebidosPorParametro($arrParametro);
	}
}