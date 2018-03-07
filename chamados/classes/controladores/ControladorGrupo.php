<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Grupos
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorGrupo {
	/**
	 * Repositório da Classe Grupo
	 *
	 * @access private
	 * @var IRepositorioGrupo
	 */
	private $objRepositorioGrupo;
	
	/**
	 * Repositorio da Classe GrupoUsuario
	 * 
	 * @access private
	 * @var IRepositorioGrupoUsuario
	 */
	private $objRepositorioGrupoUsuario;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioGrupo $objRepositorioGrupo = null
	 * @param IRepositorioGrupoUsuario $objRepositorioGrupoUsuario = null
	 */
	public function __construct(IRepositorioGrupo $objRepositorioGrupo = null, IRepositorioGrupoUsuario $objRepositorioGrupoUsuario = null) {
		$this->objRepositorioGrupo = $objRepositorioGrupo;
		$this->objRepositorioGrupoUsuario = $objRepositorioGrupoUsuario;
	}
	
	/**
	 * Método que cadastra um novo Grupo no RepositorioGrupo
	 * 
	 * @access public
	 * @param string $strDescricaoGrupo
	 * @param string $strEmailGrupo
	 * @param boolean $bolFlagRecebeChamado
	 * @return void
	 */
	public function cadastrarGrupo($strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado) {
		// Inicializando os cadastros
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		
		// Removendo os espaços vazios
		$strDescricaoGrupo		= (string) trim($strDescricaoGrupo);
		$strEmailGrupo			= (string) trim($strEmailGrupo);
		$bolFlagRecebeChamado	= (boolean) $bolFlagRecebeChamado;
		
		// Validando os dados
		if (strlen($strDescricaoGrupo) < 1) throw new CampoObrigatorioException("Descrição do Grupo");
		if (strlen($strEmailGrupo) > 0 && !Util::verificaEmail($strEmailGrupo)) throw new CampoInvalidoException("Email");
		
		// TODO O Usuário autenticado tem permissão (admin) de criar grupos?
		
		// Criando o Grupo
		$intIdGrupo = 0;
		$bolStatusGrupo = true;
		$objGrupo = new Grupo($intIdGrupo, $strDescricaoGrupo, $strEmailGrupo, $bolStatusGrupo, $bolFlagRecebeChamado);
		
		// Cadastrando o Grupo
		$objCadastroGrupo->cadastrar($objGrupo);
	}
	
	/**
	 * Método que atualiza um determinado Grupo
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @param String $strDescricaoGrupo
	 * @param String $strEmailGrupo
	 * @return void
	 */
	public function atualizarGrupo($intIdGrupo, $strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado) {
		// Inicializando os cadastros
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		
		// Removendo os espaços vazios
		$intIdGrupo				= (int) $intIdGrupo;
		$strDescricaoGrupo		= (string) trim($strDescricaoGrupo);
		$strEmailGrupo			= (string) trim($strEmailGrupo);
		$bolFlagRecebeChamado	= (boolean) $bolFlagRecebeChamado;
		
		// Validando os dados
		if ($intIdGrupo < 0)				throw new CampoObrigatorioException("ID do Grupo");
		if (strlen($strDescricaoGrupo) < 1)	throw new CampoObrigatorioException("Descrição do Grupo");
		if (strlen($strEmailGrupo) > 0 && !Util::verificaEmail($strEmailGrupo)) throw new CampoInvalidoException("Email");
		
		// Recuperando o Grupo
		$objGrupo = $objCadastroGrupo->procurar($intIdGrupo);
		
		// TODO O Usuário autenticado tem permissão (admin) de modificar este grupo?
		
		// Atualizando o Grupo
		$objGrupo->setDescricaoGrupo($strDescricaoGrupo);
		$objGrupo->setEmailGrupo($strEmailGrupo);
		$objGrupo->setFlagRecebeChamado($bolFlagRecebeChamado);
		$objCadastroGrupo->atualizar($objGrupo);
	}
	
	/**
	 * Método que Cancela um determinado Grupo
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return void
	 */
	public function cancelarGrupo($intIdGrupo) {
		// Inicializando os cadastros
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		
		// Removendo os espaços vazios
		$intIdGrupo = (int) $intIdGrupo;
		
		// Validando os dados
		if ($intIdGrupo < 0) throw new CampoObrigatorioException("ID do Grupo");
		
		// TODO O Usuário autenticado tem permissão (admin) de cancelar este grupo?
		
		// Recuperando o grupo a ser atualizado
		$objGrupo = $objCadastroGrupo->procurar($intIdGrupo);
		
		// Atualizando o status do Grupo para Inativo
		$bolStatusGrupo = false;
		$objGrupo->setStatusGrupo($bolStatusGrupo);
		$objCadastroGrupo->atualizar($objGrupo);
	}
	
	/**
	 * Método que procura o determinado Grupo pelo IdGrupo
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return Grupo
	 */
	public function procurarGrupo($intIdGrupo){
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		return $objCadastroGrupo->procurar($intIdGrupo);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos no RepositorioGrupo
	 * 
	 * @access public
	 * @return array
	 */
	public function listarGruposAtivos() {
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		return $objCadastroGrupo->listarAtivos();
	}
	
	/**
	 * Método que lista todos os Grupos Ativos que Recebem Chamados no RepositorioGrupo
	 * 
	 * @access public
	 * @return array
	 */
	public function listarGruposAtivosQueRecebemChamados() {
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		return $objCadastroGrupo->listarAtivosQueRecebemChamados();
	}
	
	/**
	 * Método que lista todos os Grupos Ativos do Usuário especificado
	 * 
	 * @access public
	 * @param int $intIdAssunto
	 * @return array
	 */
	public function listarGruposAtivosNormaisPorIdUsuario($intIdUsuario) {
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		return $objCadastroGrupo->listarAtivosNormaisPorIdUsuario($intIdUsuario);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos Administrados pelo Usuário informado
	 * 
	 * @access public
	 * @param int $intIdUsuario
	 * @return array
	 */
	public function listarGruposAtivosAdminPorIdUsuario($intIdUsuario) {
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		return $objCadastroGrupo->listarAtivosAdminPorIdUsuario($intIdUsuario);
	}
}