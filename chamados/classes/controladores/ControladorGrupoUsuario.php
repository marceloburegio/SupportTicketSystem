<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Usuários
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorGrupoUsuario {
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
	 * @param IRepositorioGrupoUsuario $objRepositorioGrupoUsuario = null
	 */
	public function __construct(IRepositorioGrupoUsuario $objRepositorioGrupoUsuario = null) {
		$this->objRepositorioGrupoUsuario = $objRepositorioGrupoUsuario;
	}
	
	/**
	 * Método que cadastra o relacionamento entre usuário e o grupo
	 * 
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function cadastrarGrupoUsuario($intIdGrupo, $intIdUsuario) {
		// Inicializando os cadastros
		$objCadastroGrupoUsuario = new CadastroGrupoUsuario($this->objRepositorioGrupoUsuario);
		
		// Removendo os espaços vazios
		$intIdGrupo		= (int) $intIdGrupo;
		$intIdUsuario	= (int) $intIdUsuario;
		
		// Validando os dados
		if ($intIdGrupo <= 0)	throw new CampoObrigatorioException("ID do Grupo");
		if ($intIdUsuario <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		
		// Cadastrando o relacionamento no RepositorioGrupoUsuario
		$bolFlagAdmin = false;
		$objGrupoUsuario = new GrupoUsuario($intIdGrupo, $intIdUsuario, $bolFlagAdmin);
		$objCadastroGrupoUsuario->cadastrar($objGrupoUsuario);
	}
	
	/**
	 * Método que atualiza o status do usuário no grupo informado
	 * 
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @param boolean $bolFlagAdmin
	 * @return void
	 */
	public function atualizarGrupoUsuario($intIdGrupo, $intIdUsuario, $bolFlagAdmin) {
		// Inicializando os cadastros
		$objCadastroGrupoUsuario = new CadastroGrupoUsuario($this->objRepositorioGrupoUsuario);
		
		// Removendo os espaços vazios
		$intIdGrupo		= (int) $intIdGrupo;
		$intIdUsuario	= (int) $intIdUsuario;
		$bolFlagAdmin	= (boolean) $bolFlagAdmin;
		
		// Validando os dados
		if ($intIdGrupo <= 0)	throw new CampoObrigatorioException("ID do Grupo");
		if ($intIdUsuario <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		
		// Atualizando o grupo
		$objGrupoUsuario = $objCadastroGrupoUsuario->procurar($intIdGrupo, $intIdUsuario);
		$objGrupoUsuario->setFlagAdmin($bolFlagAdmin);
		$objCadastroGrupoUsuario->atualizar($objGrupoUsuario);
	}
	
	/**
	 * Método que procura um determinado usuario pelos identificadores informados
	 * 
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function procurarGrupoUsuario($intIdGrupo, $intIdUsuario) {
		// Inicializando os cadastros
		$objCadastroGrupoUsuario = new CadastroGrupoUsuario($this->objRepositorioGrupoUsuario);
		
		// Removendo os espaços vazios
		$intIdGrupo		= (int) $intIdGrupo;
		$intIdUsuario	= (int) $intIdUsuario;
		
		// Validando os dados
		if ($intIdGrupo <= 0)	throw new CampoObrigatorioException("ID do Grupo");
		if ($intIdUsuario <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		
		// Recuperando o objeto
		return $objCadastroGrupoUsuario->procurar($intIdGrupo, $intIdUsuario);
	}
	
	/**
	 * Método que exclui usuário do grupo
	 *
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function excluirGrupoUsuario($intIdGrupo, $intIdUsuario){
		// Inicializando os cadastros
		$objCadastroGrupoUsuario = new CadastroGrupoUsuario($this->objRepositorioGrupoUsuario);
		
		// Removendo os espaços vazios
		$intIdGrupo		= (int) $intIdGrupo;
		$intIdUsuario	= (int) $intIdUsuario;
		
		// Validando os dados
		if ($intIdGrupo <= 0)	throw new CampoObrigatorioException("ID do Grupo");
		if ($intIdUsuario <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		
		// Removendo o usuário do grupo
		$objCadastroGrupoUsuario->remover($intIdGrupo, $intIdUsuario);
	}
}