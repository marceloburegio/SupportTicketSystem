<?php
/**
 * Cadastro de objetos Historico
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:28:24
 */
class CadastroHistorico {
	/**
	 * Repositório de classes Historico
	 *
	 * @access private
	 * @var IRepositorioHistorico
	 */
	private $objRepositorioHistorico;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioHistorico $objRepositorioHistorico
	 */
	public function __construct(IRepositorioHistorico $objRepositorioHistorico) {
		$this->objRepositorioHistorico = $objRepositorioHistorico;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioHistorico
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @throws HistoricoJaCadastradoException
	 * @throws HistoricoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Historico $objHistorico) {
		if ($this->existe($objHistorico->getIdHistorico()))
			throw new HistoricoJaCadastradoException($objHistorico->getIdHistorico());
		return $this->objRepositorioHistorico->inserir($objHistorico);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioHistorico
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Historico $objHistorico) {
		$this->objRepositorioHistorico->atualizar($objHistorico);
	}
	
	/**
	 * Método que remove um objeto do RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdHistorico) {
		$this->objRepositorioHistorico->remover($intIdHistorico);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @return Historico
	 */
	public function procurar($intIdHistorico) {
		return $this->objRepositorioHistorico->procurar($intIdHistorico);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdHistorico) {
		return $this->objRepositorioHistorico->existe($intIdHistorico);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioHistorico
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioHistorico->listar();
	}
	
	/**
	 * Método que lista todos os objetos do chamado no RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdChamado($intIdChamado) {
		return $this->objRepositorioHistorico->listarPorIdChamado($intIdChamado);
	}
	
	/**
	 * Método que lista todos os objetos do chamado no RepositorioHistorico (ordenado recentes))
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdChamadoOrdenadoRecentes($intIdChamado) {
		return $this->objRepositorioHistorico->listarPorIdChamadoOrdenadoRecentes($intIdChamado);
	}
	
	/**
	 * Método que ira verificar se o usuario já leu o chamado do tipo especificado
	 * 
	 * @param int $intIdUsuario
	 * @param int $intIdChamado
	 * @param int $intTipoHistorico
	 * @return boolean
	 */
	public function existePorIdUsuarioPorIdChamadoPorTipo($intIdUsuario, $intIdChamado, $intTipoHistorico){
		return $this->objRepositorioHistorico->existePorIdUsuarioPorIdChamadoPorTipo($intIdUsuario, $intIdChamado, $intTipoHistorico);
	}
}