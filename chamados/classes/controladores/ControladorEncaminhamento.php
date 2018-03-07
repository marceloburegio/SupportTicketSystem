<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Encaminhamentos
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorEncaminhamento {
	/**
	 * Repositório da Classe Encaminhamento
	 *
	 * @access private
	 * @var IRepositorioEncaminhamento
	 */
	private $objRepositorioEncaminhamento;
	
	/**
	 * Repositório da Classe Usuario
	 *
	 * @access private
	 * @var IRepositorioUsuario
	 */
	private $objRepositorioUsuario;
	
	/**
	 * Repositório da Classe Grupo
	 *
	 * @access private
	 * @var IRepositorioGrupo
	 */
	private $objRepositorioGrupo;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioEncaminhamento $objRepositorioEncaminhamento = null
	 * @param IRepositorioUsuario $objRepositorioUsuario = null
	 * @param IRepositorioGrupo $objRepositorioGrupo = null
	 */
	public function __construct(IRepositorioEncaminhamento $objRepositorioEncaminhamento = null, IRepositorioUsuario $objRepositorioUsuario = null, IRepositorioGrupo $objRepositorioGrupo = null) {
		$this->objRepositorioEncaminhamento = $objRepositorioEncaminhamento;
		$this->objRepositorioUsuario = $objRepositorioUsuario;
		$this->objRepositorioGrupo = $objRepositorioGrupo;
	}
	
	/**
	 * Método que lista todos os encaminhamentos do chamado no repositório
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @return array
	 */
	public function listarEncaminhamentosPorIdChamado($intIdChamado) {
		// Inicializando os cadastros
		$objCadastroEncaminhamento = new CadastroEncaminhamento($this->objRepositorioEncaminhamento);
		$objCadastroUsuario = new CadastroUsuario($this->objRepositorioUsuario);
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		
		// Removendo os espaços vazios
		$intIdChamado = (int) $intIdChamado;
		
		// Validando os dados
		if ($intIdChamado <= 0) throw new CampoObrigatorioException("ID do Chamado");
		
		// Listando todo o historico
		$arrObjEncaminhamento = $objCadastroEncaminhamento->listarPorIdChamado($intIdChamado);
		
		// Populando os encaminhamentos
		foreach ($arrObjEncaminhamento as $objEncaminhamento) {
			$objUsuarioOrigem = $objCadastroUsuario->procurar($objEncaminhamento->getIdUsuarioOrigem());
			$objEncaminhamento->setUsuarioOrigem($objUsuarioOrigem);
			
			if ($objEncaminhamento->getIdUsuarioDestino() != 0) {
				$objUsuarioDestino = $objCadastroUsuario->procurar($objEncaminhamento->getIdUsuarioDestino());
				$objEncaminhamento->setUsuarioDestino($objUsuarioDestino);
			}
			
			if ($objEncaminhamento->getIdGrupoDestino() != 0) {
				$objGrupoDestino = $objCadastroGrupo->procurar($objEncaminhamento->getIdGrupoDestino());
				$objEncaminhamento->setGrupoDestino($objGrupoDestino);
			}
		}
		return $arrObjEncaminhamento;
	}
}