<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Usuários
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorUsuario {
	/**
	 * Repositório da Classe Usuário
	 *
	 * @access private
	 * @var IRepositorioUsuario
	 */
	private $objRepositorioUsuario;
	
	/**
	 * Repositorio da Classe Grupo
	 * 
	 * @access private
	 * @var IRepositorioGrupo
	 */
	private $objRepositorioGrupo;
	
	/**
	 * Repositório da Classe Setor
	 *
	 * @access private
	 * @var IRepositorioSetor
	 */
	private $objRepositorioSetor;
	
	/**
	 * Repositório da Classe Chamado
	 *
	 * @access private
	 * @var IRepositorioChamado
	 */
	private $objRepositorioChamado;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioUsuario $objRepositorioUsuario = null
	 * @param IRepositorioGrupo $objRepositorioGrupo = null
	 * @param IRepositorioSetor $objRepositorioSetor = null
	 * @param IRepositorioSetor $objRepositorioChamado = null
	 */
	public function __construct(IRepositorioUsuario $objRepositorioUsuario = null, IRepositorioGrupo $objRepositorioGrupo = null, IRepositorioSetor $objRepositorioSetor = null, IRepositorioChamado $objRepositorioChamado = null) {
		$this->objRepositorioUsuario = $objRepositorioUsuario;
		$this->objRepositorioGrupo = $objRepositorioGrupo;
		$this->objRepositorioSetor = $objRepositorioSetor;
		$this->objRepositorioChamado = $objRepositorioChamado;
	}
	
	/**
	 * Método que cadastra um usuário no repositório
	 * 
	 * @param $strLogin
	 * @param $strNomeUsuario
	 * @param $strEmailUsuario
	 * @param $strSetor
	 * @param $strRamal
	 * @return void
	 */
	public function cadastrarUsuario($strLogin, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal) {
		// Inicializando os cadastros
		$objCadastroUsuario = new CadastroUsuario($this->objRepositorioUsuario);
		
		// Removendo os espaços vazios
		$strLogin			= (string) strtolower(trim($strLogin));
		$strNomeUsuario		= (string) Util::formatarFrase(trim($strNomeUsuario));
		$strEmailUsuario	= (string) strtolower(trim($strEmailUsuario));
		$intIdSetor			= (int) $intIdSetor;
		$strRamal			= (string) Util::formatarFrase(trim($strRamal));
		
		// Validando os dados
		if (strlen($strLogin) < 1)					throw new CampoObrigatorioException("Login");
		if (strlen($strNomeUsuario) < 1)			throw new CampoObrigatorioException("Nome");
		if (strlen($strEmailUsuario) < 1)			throw new CampoObrigatorioException("Email");
		if ($intIdSetor <= 0)						throw new CampoObrigatorioException("ID do setor");
		if (strlen($strRamal) < 1)					throw new CampoObrigatorioException("Ramal");
		if (!Util::verificaEmail($strEmailUsuario))	throw new CampoInvalidoException("Email");
		
		// Definindo outros dados não recebidos pelo formulário
		$intIdUsuario = 0;
		$strDataCadastro = date("Y-m-d H:i:s");
		$strDataAlteracao = $strDataCadastro;
		$strDataUltimoLogin = $strDataCadastro;
		$bolStatusUsuario = true;
		$bolFlagSuperAdmin = false;
		
		// Cadastrando o objeto
		$objUsuario = new Usuario($intIdUsuario, $intIdSetor, $strLogin, $strNomeUsuario, $strEmailUsuario, $strRamal, $strDataCadastro, $strDataAlteracao, $strDataUltimoLogin, $bolStatusUsuario, $bolFlagSuperAdmin);
		$intIdUsuario = $objCadastroUsuario->cadastrar($objUsuario);
		$objUsuario->setIdUsuario($intIdUsuario);
		
		// Atualizando a sessão
		$_SESSION["intIdUsuario"]		= $intIdUsuario;
		$_SESSION["strLogin"]			= $strLogin;
		$_SESSION["strNomeUsuario"]		= $strNomeUsuario;
		$_SESSION["bolRecebeChamado"]	= false;
		$_SESSION["bolGrupoAdmin"]		= false;
		$_SESSION["bolSuperAdmin"]		= false;
	}
	
	/**
	 * Método que atualiza o Usuario no RepositorioUsuario
	 * 
	 * @param $intIdUsuario
	 * @param $strNomeUsuario
	 * @param $strEmailUsuario
	 * @param $intIdSetor
	 * @param $strRamal
	 * @return void
	 */
	public function atualizarUsuario($intIdUsuario, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal) {
		// Inicializando os cadastros
		$objCadastroUsuario = new CadastroUsuario($this->objRepositorioUsuario);
		
		// Removendo os espaços vazios
		$intIdUsuario		= (int) $intIdUsuario;
		$strNomeUsuario		= (string) Util::formatarFrase(trim($strNomeUsuario));
		$strEmailUsuario	= (string) strtolower(trim($strEmailUsuario));
		$intIdSetor			= (int) $intIdSetor;
		$strRamal			= (string) Util::formatarFrase(strtolower(trim($strRamal)));
		
		// Validando os dados
		if ($intIdUsuario <= 0)						throw new CampoObrigatorioException("ID do Usuário");
		if (strlen($strNomeUsuario) < 1)			throw new CampoObrigatorioException("Nome");
		if (strlen($strEmailUsuario) < 1)			throw new CampoObrigatorioException("Email");
		if ($intIdSetor <= 0)						throw new CampoObrigatorioException("Identificado do Setor");
		if (strlen($strRamal) < 1)					throw new CampoObrigatorioException("Ramal");
		if (!Util::verificaEmail($strEmailUsuario))	throw new CampoInvalidoException("Email");
		
		// Recuperando o objeto
		$objUsuario = $objCadastroUsuario->procurar($intIdUsuario);
		
		// Atualizando o objeto
		$objUsuario->setNomeUsuario($strNomeUsuario);
		$objUsuario->setEmailUsuario($strEmailUsuario);
		$objUsuario->setIdSetor($intIdSetor);
		$objUsuario->setRamal($strRamal);
		
		// Atualizando no repositório
		$objCadastroUsuario->atualizar($objUsuario);
		
		// Atualizando a sessão
		$_SESSION["strNomeUsuario"] = $strNomeUsuario;
	}
	
	/**
	 * Método que procura o Usuário pelo IdUsuario
	 * 
	 * @access public
	 * @param int $intIdUsuario
	 * @return Usuario
	 */
	public function procurarUsuario($intIdUsuario){
		// Inicializando os cadastros
		$objCadastroUsuario	= new CadastroUsuario($this->objRepositorioUsuario);
		$objCadastroSetor	= new CadastroSetor($this->objRepositorioSetor);
		
		// Removendo os espaços vazios
		$intIdUsuario = (int) $intIdUsuario;
		
		// Validando os dados
		if ($intIdUsuario < 0) throw new CampoObrigatorioException("ID do Usuário");
		
		// Procurando o Usuário no RepositorioUsuario
		$objUsuario = $objCadastroUsuario->procurar($intIdUsuario);
		
		// Atualizando o Setor
		$objSetor = $objCadastroSetor->procurar($objUsuario->getIdSetor());
		$objUsuario->setSetor($objSetor);
		return $objUsuario;
	}
	
	/**
	 * Método que procura um Usuário pelo Login
	 * 
	 * @access public
	 * @param string $strLogin
	 * @return Usuario
	 */
	public function procurarUsuarioPorLogin($strLogin){
		// Inicializando os cadastros
		$objCadastroUsuario	= new CadastroUsuario($this->objRepositorioUsuario);
		$objCadastroSetor	= new CadastroSetor($this->objRepositorioSetor);
		
		// Removendo os espaços vazios
		$strLogin = (string) strtolower(trim($strLogin));
		
		// Validando os dados
		if (strlen($strLogin) < 1) throw new CampoObrigatorioException("Login");
		
		// Procurando o Usuário no RepositorioUsuario
		$objUsuario = $objCadastroUsuario->procurarPorLogin($strLogin);
		
		// Atualizando o Setor
		$objSetor = $objCadastroSetor->procurar($objUsuario->getIdSetor());
		$objUsuario->setSetor($objSetor);
		return $objUsuario;
	}
	
	/**
	 * Método que lista todos os usuários pertencente ao grupo informado
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarUsuariosPorIdGrupo($intIdGrupo){
		// Inicializando os cadastros
		$objCadastroUsuario = new CadastroUsuario($this->objRepositorioUsuario);
		
		// Removendo os espaços vazios
		$intIdGrupo = (int) $intIdGrupo;
		
		// Validando os dados
		if ($intIdGrupo < 0) throw new CampoObrigatorioException("ID do Grupo");
		
		// Consultando os usuários do grupo
		return $objCadastroUsuario->listarPorIdGrupo($intIdGrupo);
	}
	
	/**
	 * Método que autentica um Usuário no AD
	 * 
	 * @access public
	 * @param String $strLogin
	 * @param String $strSenha
	 * @return boolean
	 */
	public function autenticarUsuario($strLogin, $strSenha){
		// Inicializando os cadastros
		$objCadastroUsuario = new CadastroUsuario($this->objRepositorioUsuario);
		$objCadastroGrupo = new CadastroGrupo($this->objRepositorioGrupo);
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$strLogin = (string) strtolower(trim($strLogin));
		$strSenha = (string) trim($strSenha);
		
		// Validando os dados
		if (strlen($strLogin) < 1) throw new CampoObrigatorioException("Login");
		if (strlen($strSenha) < 1) throw new CampoObrigatorioException("Senha");
		
		// Autenticando no Servidor LDAP
		if ($this->autenticarLDAP(Config::getServidorAD(), Config::getDominioAD(), $strLogin, $strSenha)) {
			
			// Definindo os valores padrões
			$intIdUsuario = 0;
			$strNomeUsuario = "";
			$bolPrimeiroAcesso = false;
			$bolRecebeChamado = false;
			$bolGrupoAdmin = false;
			$bolSuperAdmin = false;
			$bolBalaoNovoChamado = false;
			
			// Verificando se o usuário existe
			if ($objCadastroUsuario->existePorLogin($strLogin)) {
				
				// Recuperando os dados do usuário
				$objUsuario = $objCadastroUsuario->procurarPorLogin($strLogin);
				$intIdUsuario = $objUsuario->getIdUsuario();
				$strNomeUsuario = $objUsuario->getNomeUsuario();
				$bolSuperAdmin = $objUsuario->getFlagSuperAdmin();
				
				// Verificando se o Usuário é Admin de algum Grupo
				$arrGruposAdmin = $objCadastroGrupo->listarAtivosAdminPorIdUsuario($intIdUsuario);
				if (count($arrGruposAdmin) > 0) $bolGrupoAdmin = true;
				
				// Verificando se o Usuário recebe Chamados
				$arrGruposUsuario = $objCadastroGrupo->listarAtivosNormaisPorIdUsuario($intIdUsuario);
				foreach ($arrGruposUsuario as $objGrupo) {
					if ($objGrupo->getFlagRecebeChamado()) {
						$bolRecebeChamado = true;
						break;
					}
				}
				
				// Atualizando a data e hora de login
				$objUsuario->setDataUltimoLogin(date("Y-m-d H:i:s"));
				$objCadastroUsuario->atualizar($objUsuario);
				
				// Verificando se este usuário possui algum chamado cadastrado
				if (!$bolRecebeChamado) {
					$intQtdeChamadosEnviados = $objCadastroChamado->quantidadeEnviadosPorParametro(array("intIdUsuario"=>$intIdUsuario));
					if ($intQtdeChamadosEnviados == 0) $bolBalaoNovoChamado = true;
				}
			}
			else {
				$bolPrimeiroAcesso = true;
				$bolBalaoNovoChamado = true;
			}
			
			// Inicializando a sessao
			session_start();
			$_SESSION["intIdUsuario"] = $intIdUsuario;
			$_SESSION["strLogin"] = $strLogin;
			$_SESSION["strNomeUsuario"] = $strNomeUsuario;
			$_SESSION["bolPrimeiroAcesso"] = $bolPrimeiroAcesso;
			$_SESSION["bolRecebeChamado"] = $bolRecebeChamado;
			$_SESSION["bolGrupoAdmin"] = $bolGrupoAdmin;
			$_SESSION["bolSuperAdmin"] = $bolSuperAdmin;
			$_SESSION["bolBalaoNovoChamado"] = $bolBalaoNovoChamado;
			return true;
		}
		return false;
	}
	
	/**
	 * Método que verifica se a sessão é válida ou não
	 *
	 * @access public
	 * @return void
	 */
	public function validarSessaoUsuario() {
		// Inicializando a sessão
		session_start();
		
		// Verificando se a sessão está vazia
		if (empty($_SESSION["intIdUsuario"])) {
			
			// Limpando a sessão
			$this->limparSessao();
			
			// Redirecionando para a página de autenticação
			echo '<script type="text/javascript">parent.window.location = \'./autenticar.php\';</script>';
			exit();
		}
	}
	
	/**
	 * Método que verifica se a sessão é válida ou não
	 *
	 * @access public
	 * @return void
	 */
	public function validarSessaoAdmin() {
		// Validando a sessão do Usuário
		$this->validarSessaoUsuario();
		
		// Verificando se a sessão está vazia
		if ((empty($_SESSION["bolGrupoAdmin"]) || !$_SESSION["bolGrupoAdmin"]) && (empty($_SESSION["bolSuperAdmin"]) || !$_SESSION["bolSuperAdmin"])) {
			throw new Exception("Seu usuário não possui permissão para acessar esta opção.");
			exit();
		}
	}
	
	/**
	 * Método que finaliza a sessão do usuário
	 *
	 * @access public
	 * @return void
	 */
	public function fecharSessaoUsuario() {
		// Inicializando a sessão
		session_start();
		
		// Limpando a sessão
		$this->limparSessao();
		
		// Redirecionando para a página de autenticação
		header("Location: ./");
		exit();
	}
	
	/**
	 * Método que elimina da sessão todos os dados do usuário
	 *
	 * @access private
	 * @return void
	 */
	private function limparSessao() {
		// Limpando o login da sessão
		unset($_SESSION["intIdUsuario"]);
		unset($_SESSION["strLogin"]);
		unset($_SESSION["strNomeUsuario"]);
		unset($_SESSION["bolPrimeiroAcesso"]);
		unset($_SESSION["bolRecebeChamado"]);
		unset($_SESSION["bolGrupoAdmin"]);
		unset($_SESSION["bolSuperAdmin"]);
		unset($_SESSION["bolBalaoNovoChamado"]);
	}
	
	/**
	 * Metodo que autentica um usuário no servidor de autenticação (LDAP)
	 * 
	 * @param string $strHost
	 * @param string $strDominio
	 * @param string $strUsuario
	 * @param string $strSenha
	 * @return bool
	 */
	private function autenticarLDAP($strHost, $strDominio, $strUsuario, $strSenha) {
		if (strlen($strHost) > 0 && strlen($strDominio) > 0 && strlen($strUsuario) > 0 && strlen($strSenha) > 0) {
			if ($srcConexao = @ldap_connect($strHost)) {
				ldap_set_option($srcConexao, LDAP_OPT_PROTOCOL_VERSION, 3);
				ldap_set_option($srcConexao, LDAP_OPT_REFERRALS, 0);
				if (@ldap_bind($srcConexao, $strUsuario ."@". $strDominio, $strSenha)) return true;
			}
		}
		return false;
	}
}