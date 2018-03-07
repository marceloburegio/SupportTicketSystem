<?php
/**
 * Controlador responsável pelos os envios de e-mail
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorEmail {
	/**
	 * Repositório da Classe Chamado
	 *
	 * @access private
	 * @var IRepositorioChamado
	 */
	private $objRepositorioChamado;
	
	/**
	 * Repositório da Classe Assunto
	 *
	 * @access private
	 * @var IRepositorioAssunto
	 */
	private $objRepositorioAssunto;
	
	/**
	 * Repositório da Classe Grupo
	 *
	 * @access private
	 * @var IRepositorioGrupo
	 */
	private $objRepositorioGrupo;
	
	/**
	 * Repositório da Classe Usuario
	 *
	 * @access private
	 * @var IRepositorioUsuario
	 */
	private $objRepositorioUsuario;
	
	/**
	 * Repositório da Classe Setor
	 *
	 * @access private
	 * @var IRepositorioSetor
	 */
	private $objRepositorioSetor;
	
	/**
	 * Repositório da Classe Historico
	 *
	 * @access private
	 * @var IRepositorioHistorico
	 */
	private $objRepositorioHistorico;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioChamado $objRepositorioChamado = null
	 * @param IRepositorioAssunto $objRepositorioAssunto = null
	 * @param IRepositorioGrupo $objRepositorioGrupo = null
	 * @param IRepositorioUsuario $objRepositorioUsuario = null
	 * @param IRepositorioSetor $objRepositorioSetor = null
	 * @param IRepositorioHistorico $objRepositorioHistorico = null
	 */
	public function __construct(IRepositorioChamado $objRepositorioChamado = null, IRepositorioAssunto $objRepositorioAssunto = null, IRepositorioGrupo $objRepositorioGrupo = null, IRepositorioUsuario $objRepositorioUsuario = null, IRepositorioSetor $objRepositorioSetor = null, IRepositorioHistorico $objRepositorioHistorico = null) {
		$this->objRepositorioChamado = $objRepositorioChamado;
		$this->objRepositorioAssunto = $objRepositorioAssunto;
		$this->objRepositorioGrupo = $objRepositorioGrupo;
		$this->objRepositorioUsuario = $objRepositorioUsuario;
		$this->objRepositorioSetor = $objRepositorioSetor;
		$this->objRepositorioHistorico = $objRepositorioHistorico;
	}
	
	/**
	 * Método que envia emails para os envolvidos do chamado
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @param string $strAssuntoEmail
	 * @return void
	 */	
	public function enviarChamadoPorEmail($intIdChamado, $strAssuntoEmail) {
		// Inicializando os controladores
		$objControladorChamado		= new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
		$objControladorHistorico	= new ControladorHistorico($this->objRepositorioHistorico, null, null, null, $this->objRepositorioUsuario);
		$objCadastroUsuario			= new CadastroUsuario($this->objRepositorioUsuario);
		
		// Recuperando o objeto Chamado (Populado)
		$objChamado = $objControladorChamado->procurarChamadoPorIdChamado($intIdChamado);
		
		// Listando todos os Históricos do Chamado (Populados)
		$arrObjHistorico = $objControladorHistorico->listarHistoricoPorIdChamadoOrdenadoRecentes($intIdChamado);
		
		// Definindo o nome do destinatário
		$strDestinatario = $objChamado->getGrupoDestino()->getDescricaoGrupo() ." (Grupo)";
		if ($objChamado->getIdUsuarioDestino() != 0) $strDestinatario = $objChamado->getUsuarioDestino()->getNomeUsuario() ." (Individual)";
		
		// Definindo os destinatários do email
		$arrDestinatariosEmail = array();
		
		// Adicionando o Usuário de Origem
		$arrDestinatariosEmail[] = $objChamado->getUsuarioOrigem()->getEmailUsuario();
		$arrObjUsuarioAdmin = $objCadastroUsuario->listarAdminPorIdUsuario($objChamado->getIdUsuarioOrigem());
		foreach ($arrObjUsuarioAdmin as $objUsuarioAdmin) {
			$arrDestinatariosEmail[] = $objUsuarioAdmin->getEmailUsuario();
		}
		
		// Adicionando o Destinatário (Grupo ou Específico)
		if ($objChamado->getIdUsuarioDestino() == 0) $arrDestinatariosEmail[] = $objChamado->getGrupoDestino()->getEmailGrupo();
		else {
			// Destinatário Específico
			$arrDestinatariosEmail[] = $objChamado->getUsuarioDestino()->getEmailUsuario();
			$arrObjUsuarioAdmin = $objCadastroUsuario->listarAdminPorIdGrupo($objChamado->getIdGrupoDestino());
			foreach ($arrObjUsuarioAdmin as $objUsuarioAdmin) {
				$arrDestinatariosEmail[] = $objUsuarioAdmin->getEmailUsuario();
			}
		}
		
		// Adicionando os Emails em Copia do Chamado
		$strEmailCopia = trim($objChamado->getEmailCopia());
		if (strlen($strEmailCopia) > 0) {
			$arrEmailCopia = explode(",", $strEmailCopia);
			foreach ($arrEmailCopia as $strEmail) {
				$strEmail = trim($strEmail);
				if (strlen($strEmail) > 0) $arrDestinatariosEmail[] = $strEmail;
			}
		}
		
		// Processando os destinatários
		$arrDestinatariosEmail = array_unique($arrDestinatariosEmail);
		$strDestinatariosEmail = implode(", ", $arrDestinatariosEmail);
		
		// Criando o corpo do email
		ob_start();
		include("includes/incEmail.php");
		$strConteudoEmail = ob_get_clean();
		
		// Enviando o email
		Email::enviar(Config::getRemetenteEmail(), $strDestinatariosEmail, $strAssuntoEmail, $strConteudoEmail);
	}
}