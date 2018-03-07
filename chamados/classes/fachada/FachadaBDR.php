<?php
/**
 * Fachada do sistema
 * Esta Fachada é a implementação usando os repositórios BDR
 *
 * @author Marcelo Burégio
 * @subpackage fachada
 * @version 1.0
 * @since 07/04/2010 17:04:50
 */
class FachadaBDR {
	/**
	 * Atributo contendo a instância do Singleton da FachadaBDR
	 *
	 * @access private
	 * @var FachadaBDR
	 */
	private static $objInstance = null;

	/**
	 * Repositório da Classe Assunto
	 *
	 * @access private
	 * @var IRepositorioAssunto
	 */
	private $objRepositorioAssunto;

	/**
	 * Repositório da Classe Chamado
	 *
	 * @access private
	 * @var IRepositorioChamado
	 */
	private $objRepositorioChamado;

	/**
	 * Repositório da Classe Emcaminhamento
	 *
	 * @access private
	 * @var IRepositorioEmcaminhamento
	 */
	private $objRepositorioEmcaminhamento;

	/**
	 * Repositório da Classe Grupo
	 *
	 * @access private
	 * @var IRepositorioGrupo
	 */
	private $objRepositorioGrupo;

	/**
	 * Repositório da Classe GrupoUsuario
	 *
	 * @access private
	 * @var IRepositorioGrupoUsuario
	 */
	private $objRepositorioGrupoUsuario;

	/**
	 * Repositório da Classe Historico
	 *
	 * @access private
	 * @var IRepositorioHistorico
	 */
	private $objRepositorioHistorico;

	/**
	 * Repositório da Classe Usuario
	 *
	 * @access private
	 * @var IRepositorioUsuario
	 */
	private $objRepositorioUsuario;

	/**
	 * Repositório da Classe Horario
	 *
	 * @access private
	 * @var IRepositorioHorario
	 */
	private $objRepositorioHorario;

	/**
	 * Repositório da Classe Setor
	 *
	 * @access private
	 * @var IRepositorioSetor
	 */
	private $objRepositorioSetor;
	
	/**
	 * Repositório da Classe Relatorio
	 *
	 * @access private
	 * @var RepositorioRelatorio
	 */
	private $objRepositorioRelatorio;
	
	/**
	 * Repositório da Classe Feriado
	 *
	 * @access private
	 * @var IRepositorioFeriado
	 */
	private $objRepositorioFeriado;

	/**
	 * Método construtor da classe
	 *
	 * @access private
	 */
	private function __construct() {
		$this->objRepositorioAssunto			= new RepositorioAssuntoBDRCustomizado();
		$this->objRepositorioChamado			= new RepositorioChamadoBDRCustomizado();
		$this->objRepositorioEncaminhamento		= new RepositorioEncaminhamentoBDRCustomizado();
		$this->objRepositorioGrupo				= new RepositorioGrupoBDRCustomizado();
		$this->objRepositorioGrupoUsuario		= new RepositorioGrupoUsuarioBDRCustomizado();
		$this->objRepositorioHistorico			= new RepositorioHistoricoBDRCustomizado();
		$this->objRepositorioUsuario			= new RepositorioUsuarioBDRCustomizado();
		$this->objRepositorioHorario			= new RepositorioHorarioBDRCustomizado();
		$this->objRepositorioSetor				= new RepositorioSetorBDRCustomizado();
		$this->objRepositorioRelatorio			= new RepositorioRelatorioBDR();
		$this->objRepositorioFeriado			= new RepositorioFeriadoBDRCustomizado();
	}

	/**
	 * Método estático Singleton que retorna uma instância da FachadaBDR
	 *
	 * @access public
	 * @return FachadaBDR
	 */
	public static function getInstance() {
		if (self::$objInstance == null) {
			self::$objInstance = new FachadaBDR();
		}
		return self::$objInstance;
	}


	/***********************
	 *       ASSUNTO
	 **********************/
	/**
	 * Método que cadastra um Assunto no RepositorioAssunto
	 *
	 * @param int $intIdGrupo
	 * @param string $strDescricaoAssunto
	 * @param int $intSla
	 * @param string $strAlertaChamado
	 * @param string $strFormatoChamado
	 * @param string $strUrlChamadoExterno
	 * @return void
	 */
	public function cadastrarAssunto($intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno) {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		$objControladorAssunto->cadastrarAssunto($intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno);
	}

	/**
	 * Método que atualiza um determinado Assunto no RepositorioAssunto
	 *
	 * @param int $intIdAssunto
	 * @param int $intIdGrupo
	 * @param string $strDescricaoAssunto
	 * @param int $intSla
	 * @param string $strAlertaChamado
	 * @param string $strFormatoChamado
	 * @param string $strUrlChamadoExterno
	 * @return void
	 */
	public function atualizarAssunto($intIdAssunto, $intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno) {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		$objControladorAssunto->atualizarAssunto($intIdAssunto, $intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno);
	}

	/**
	 * Método que cancela um determinado Assunto no RepositorioAssunto
	 *
	 * @param int $intIdAssunto
	 * @return void
	 */
	public function cancelarAssunto($intIdAssunto) {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		$objControladorAssunto->cancelarAssunto($intIdAssunto);
	}

	/**
	 * Método que procura um determinado Assunto no RepositorioAssunto
	 *
	 * @param int $intIdAssunto
	 * @return Assunto
	 */
	public function procurarAssuntoPorIdAssunto($intIdAssunto) {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		return $objControladorAssunto->procurarAssuntoPorIdAssunto($intIdAssunto);
	}

	/**
	 * Método que lista todos os Assuntos do RepositorioAssunto
	 *
	 * @access public
	 * @return array
	 */
	public function listarAssuntos() {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		return $objControladorAssunto->listarAssuntos();
	}

	/**
	 * Método que lista todos os Assuntos de um Grupo no RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarAssuntosPorIdGrupo($intIdGrupo) {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		return $objControladorAssunto->listarAssuntosPorIdGrupo($intIdGrupo);
	}

	/**
	 * Método que lista todos os Assuntos Ativos do RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarAssuntosAtivosPorIdGrupo($intIdGrupo) {
		$objControladorAssunto = new ControladorAssunto($this->objRepositorioAssunto);
		return $objControladorAssunto->listarAssuntosAtivosPorIdGrupo($intIdGrupo);
	}


	/***********************
	 *       CHAMADOS
	 **********************/
	/**
	 * Método que cadastra um chamado no repositório
	 *
	 * @access public
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdGrupoDestino
	 * @param int $intIdAssunto
	 * @param string $strDescricaoChamado
	 * @param int $intCodigoPrioridade
	 * @param string $strJustificativaPrioridade
	 * @param string $strNomeArquivo
	 * @return int $intIdChamado
	 */
	public function cadastrarChamado($intIdUsuarioOrigem, $intIdGrupoDestino, $intIdAssunto, $strDescricaoChamado, $intCodigoPrioridade, $strJustificativaPrioridade, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strEmailCopia) {
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação para cadastro do chamado
			$objPDO->beginTransaction();
			
			// Cadastrando o chamado
			$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico, $this->objRepositorioHorario, null, $this->objRepositorioFeriado);
			$intIdChamado = $objControladorChamado->cadastrarChamado($intIdUsuarioOrigem, $intIdGrupoDestino, $intIdAssunto, $strDescricaoChamado, $intCodigoPrioridade, $strJustificativaPrioridade,  $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strEmailCopia);
			
			// Enviando o email do cadastramento do chamado
			$objControladorEmail = new ControladorEmail($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
			$strAssuntoEmail = "Chamado No. ". $intIdChamado ." - Abertura do Chamado";
			$objControladorEmail->enviarChamadoPorEmail($intIdChamado, $strAssuntoEmail);
			
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
		return $intIdChamado;
	}

	/**
	 * Método que retorna o objeto chamado completo cadastrando o histórico de leitura
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @return Chamado
	 */
	public function detalharChamado($intIdChamado){
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação
			$objPDO->beginTransaction();
				
			// Recuperando o objeto Chamado com o devido cadastramento do histórico
			$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
			$objChamado = $objControladorChamado->detalharChamado($intIdChamado);
				
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
		return $objChamado;
	}

	/**
	 * Método que reclassifica o Assunto ou a Prioridade de um determinado Chamado
	 *
	 * @param int $intIdChamado
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdAssunto
	 * @param int $intCodigoPrioridade
	 * @param int $intStatus
	 * @return void
	 */
	public function reclassificarChamado($intIdChamado, $intIdUsuarioOrigem, $intIdAssunto, $intCodigoPrioridade, $intStatus) {
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação
			$objPDO->beginTransaction();
				
			$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico, $this->objRepositorioHorario, null, $this->objRepositorioFeriado);
			$objControladorChamado->reclassificarChamado($intIdChamado, $intIdUsuarioOrigem, $intIdAssunto, $intCodigoPrioridade, $intStatus);
			
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
	}

	/**
	 * Método que cadastra um Encaminhamento de um determinado Chamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @param int $intIdAssunto
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdGrupoDestino
	 * @param int $intIdUsuarioDestino
	 * @return array
	 */
	public function encaminharChamado($intIdChamado, $intIdAssunto, $intIdUsuarioOrigem, $intIdGrupoDestino, $intIdUsuarioDestino) {
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação
			$objPDO->beginTransaction();
			
			// Encaminhando o chamado para o grupo ou usuário especificado
			$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico, $this->objRepositorioHorario, $this->objRepositorioEncaminhamento, $this->objRepositorioFeriado);
			$objControladorChamado->encaminharChamado($intIdChamado, $intIdAssunto, $intIdUsuarioOrigem, $intIdGrupoDestino, $intIdUsuarioDestino);
			
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
	}

	/**
	 * Método que lista todos os chamados enviados do usuário
	 *
	 * @access public
	 * @param array $arrParametro
	 * @return array
	 */
	public function listarChamadosEnviadosPorParametro($arrParametro, $intOffSet = 0) {
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor);
		return $objControladorChamado->listarChamadosEnviadosPorParametro($arrParametro, $intOffSet);
	}

	/**
	 * Método que conta a quantidade de chamados de um usuário
	 *
	 * @access public
	 * @param array $arrParametro
	 * @return int
	 */
	public function quantidadeChamadosEnviadosPorParametro($arrParametro) {
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado);
		return $objControladorChamado->quantidadeChamadosEnviadosPorParametro($arrParametro);
	}

	/**
	 * Método que lista todos os chamados recebidos do usuário
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param int $intOffSet
	 * @return array
	 */
	public function listarChamadosRecebidosPorParametro($arrParametro, $intOffSet = 0){
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor);
		return $objControladorChamado->listarChamadosRecebidosPorParametro($arrParametro, $intOffSet);
	}

	/**
	 * Método que conta a quantidade de chamados de um usuário
	 *
	 * @access public
	 * @param array $arrParametro
	 * @return int
	 */
	public function quantidadeChamadosRecebidosPorParametro($arrParametro) {
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado);
		return $objControladorChamado->quantidadeChamadosRecebidosPorParametro($arrParametro);
	}

	/**
	 * Método que calcula a data de prazo de um chamado com base no grupo e no assunto
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdAssunto
	 * @param string $strDataReferencia
	 * @return string
	 */
	public function calcularDataPrazo($intIdGrupo, $intIdAssunto, $strDataReferencia) {
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, null, null, null, null, $this->objRepositorioHorario, null, $this->objRepositorioFeriado);
		return $objControladorChamado->calcularDataPrazo($intIdGrupo, $intIdAssunto, $strDataReferencia);
	}

	/**
	 * Método que recupera o objeto chamado
	 * 
	 * @access public
	 * @param $intIdChamado
	 * @return Chamado
	 */
	public function procurarChamadoPorIdChamado($intIdChamado) {
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor);
		return $objControladorChamado->procurarChamadoPorIdChamado($intIdChamado);
	}

	/**
	 * Método que ira listar todos os chamados abertos pelo usuário informado
	 * @param $intIdUsuario
	 * @return Array Chamado
	 */
	public function listarChamadoRecebidoAtivosPorIdUsuário($intIdUsuario){
		$objControladorChamado = new ControladorChamado($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor);
		return $objControladorChamado->listarChamadoRecebidoAtivosPorIdUsuário($intIdUsuario);
		
	}

	/***********************
	 *   ENCAMINHAMENTOS
	 **********************/
	/**
	 * Método que lista todos os encaminhamentos do chamado especificado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @return array
	 */
	public function listarEncaminhamentosPorIdChamado($intIdChamado) {
		$objControladorEncaminhamento = new ControladorEncaminhamento($this->objRepositorioEncaminhamento, $this->objRepositorioUsuario, $this->objRepositorioGrupo);
		return $objControladorEncaminhamento->listarEncaminhamentosPorIdChamado($intIdChamado);
	}


	/***********************
	 *       GRUPOS
	 **********************/
	/**
	 * Método que cadastra o Grupo no RepositorioGrupo
	 *
	 * @access public
	 * @param string $strDescricaoGrupo
	 * @param string $strEmailGrupo
	 * @param boolean $bolFlagRecebeChamado
	 * @return void
	 */
	public function cadastrarGrupo($strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado) {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		$objControladorGrupo->cadastrarGrupo($strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado);
	}

	/**
	 * Método que atualiza os dados do Grupo informado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strDescricaoGrupo
	 * @param string $strEmailGrupo
	 * @param boolean $bolFlagRecebeChamado
	 * @return void
	 */
	public function atualizarGrupo($intIdGrupo, $strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado) {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		$objControladorGrupo->atualizarGrupo($intIdGrupo, $strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado);
	}

	/**
	 * Método que cancela um Grupo no RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return void
	 */
	public function cancelarGrupo($intIdGrupo) {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		$objControladorGrupo->cancelarGrupo($intIdGrupo);
	}

	/**
	 * Método que procura um Grupo pelo Id no RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return Grupo
	 */
	public function procurarGrupo($intIdGrupo){
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		return $objControladorGrupo->procurarGrupo($intIdGrupo);
	}

	/**
	 * Método que lista todos os Grupos Ativos do RepositorioGrupo
	 *
	 * @access public
	 * @return array
	 */
	public function listarGruposAtivos() {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		return $objControladorGrupo->listarGruposAtivos();
	}

	/**
	 * Método que lista todos os Grupos Ativos que Recebem Chamados do RepositorioGrupo
	 *
	 * @access public
	 * @return array
	 */
	public function listarGruposAtivosQueRecebemChamados() {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		return $objControladorGrupo->listarGruposAtivosQueRecebemChamados();
	}

	/**
	 * Método que lista todos os Grupos Administrados do Usuário informado
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarGruposAtivosAdminPorIdUsuario($intIdUsuario) {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		return $objControladorGrupo->listarGruposAtivosAdminPorIdUsuario($intIdUsuario);
	}

	/**
	 * Método que lista todos os Grupos Ativos do Usuário especificado
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @return array
	 */
	public function listarGruposAtivosNormaisPorIdUsuario($intIdUsuario) {
		$objControladorGrupo = new ControladorGrupo($this->objRepositorioGrupo);
		return $objControladorGrupo->listarGruposAtivosNormaisPorIdUsuario($intIdUsuario);
	}


	/***********************
	 *   GRUPOS USUÁRIOS
	 **********************/
	/**
	 * Método que associa um usuário ao grupo
	 *
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function cadastrarGrupoUsuario($intIdGrupo, $intIdUsuario){
		$objControladorGrupoUsuario = new ControladorGrupoUsuario($this->objRepositorioGrupoUsuario);
		$objControladorGrupoUsuario->cadastrarGrupoUsuario($intIdGrupo, $intIdUsuario);
	}

	/**
	 * Método que atualiza o status do usuário no grupo
	 *
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @param boolean $bolFlagAdmin
	 * @return void
	 */
	public function atualizarGrupoUsuario($intIdGrupo, $intIdUsuario, $bolFlagAdmin){
		$objControladorGrupoUsuario = new ControladorGrupoUsuario($this->objRepositorioGrupoUsuario);
		$objControladorGrupoUsuario->atualizarGrupoUsuario($intIdGrupo, $intIdUsuario, $bolFlagAdmin);
	}

	/**
	 * Método que exclui um usuário do grupo
	 *
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function excluirGrupoUsuario($intIdGrupo, $intIdUsuario){
		$objControladorGrupoUsuario = new ControladorGrupoUsuario($this->objRepositorioGrupoUsuario);
		$objControladorGrupoUsuario->excluirGrupoUsuario($intIdGrupo, $intIdUsuario);
	}

	/**
	 * Método que procura o usuario no grupo pelos identificadores
	 *
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @return UsuarioGrupo
	 */
	public function procurarGrupoUsuario($intIdGrupo, $intIdUsuario){
		$objControladorGrupoUsuario = new ControladorGrupoUsuario($this->objRepositorioGrupoUsuario);
		return $objControladorGrupoUsuario->procurarGrupoUsuario($intIdGrupo, $intIdUsuario);
	}


	/***********************
	 *      HISTÓRICOS
	 **********************/
	/**
	 * Método que cadastra um histórico do chamado especificado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @param int $intIdUsuario
	 * @param string $strDescricaoHistorico
	 * @param string $strArquivoAnexo
	 * @param string $strAcaoChamado
	 * @return array
	 */
	public function cadastrarHistorico($intIdChamado, $intIdUsuario, $strDescricaoHistorico, $strAcaoChamado, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strCodigoChamadoExterno) {
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação
			$objPDO->beginTransaction();
				
			// Cadastrando o histórico
			$objControladorHistorico = new ControladorHistorico($this->objRepositorioHistorico, $this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor);
			$objControladorHistorico->cadastrarHistorico($intIdChamado, $intIdUsuario, $strDescricaoHistorico, $strAcaoChamado, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strCodigoChamadoExterno);
				
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
	}

	/**
	 * Método que procura um histórico no repositorio
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @return array
	 */
	public function procurarHistorico($intIdHistorico) {
		$objControladorHistorico = new ControladorHistorico($this->objRepositorioHistorico, null, null, null, $this->objRepositorioUsuario);
		return $objControladorHistorico->procurarHistorico($intIdHistorico);
	}

	/**
	 * Método que lista todos os históricos do chamado especificado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @return array
	 */
	public function listarHistoricoPorIdChamado($intIdChamado) {
		$objControladorHistorico = new ControladorHistorico($this->objRepositorioHistorico, $this->objRepositorioChamado, null, null, $this->objRepositorioUsuario);
		return $objControladorHistorico->listarHistoricoPorIdChamado($intIdChamado);
	}

	/**
	 * Método que lista todos os históricos do chamado especificado (mais recente primeiro)
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @return array
	 */
	public function listarHistoricoPorIdChamadoOrdenadoRecentes($intIdChamado) {
		$objControladorHistorico = new ControladorHistorico($this->objRepositorioHistorico, $this->objRepositorioChamado, null, null, $this->objRepositorioUsuario);
		return $objControladorHistorico->listarHistoricoPorIdChamadoOrdenadoRecentes($intIdChamado);
	}


	/***********************
	 *       USUÁRIO
	 **********************/
	/**
	 * Método que cadastra um usuário no repositório
	 *
	 * @param string $strLogin
	 * @param string $strNomeUsuario
	 * @param string $strEmailUsuario
	 * @param string $strSetor
	 * @param string $strRamal
	 * @return void
	 */
	public function cadastrarUsuario($strLogin, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal){
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação
			$objPDO->beginTransaction();
			
			// Efetuando o cadastro do usuário
			$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario);
			$objControladorUsuario->cadastrarUsuario($strLogin, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal);
				
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
	}

	/**
	 * Método que atualiza os dados do Usuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @param string $strNomeUsuario
	 * @param string $strEmailUsuario
	 * @param string $strSetor
	 * @param string $strRamal
	 * @return void
	 */
	public function atualizarUsuario($intIdUsuario, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal) {
		// Obtendo uma instância da conexão
		$objConexao	= ConexaoBDR::getInstancia("sistema");
		$objPDO		= $objConexao->getConexao();
		try {
			// Iniciando a transação
			$objPDO->beginTransaction();
				
			// Efetuando a atualização do usuário
			$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario);
			$objControladorUsuario->atualizarUsuario($intIdUsuario, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal);
				
			// Comprometendo a transação
			$objPDO->commit();
		}
		catch (Exception $ex) {
			// Em caso de exceção, desfazer
			$objPDO->rollBack();
			throw $ex;
		}
	}

	/**
	 * Método que procura o Usuário pelo IdUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @return Usuario
	 */
	public function procurarUsuario($intIdUsuario){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario, null, $this->objRepositorioSetor);
		return $objControladorUsuario->procurarUsuario($intIdUsuario);
	}

	/**
	 * Método que procura o Usuário pelo Login
	 *
	 * @access public
	 * @param string $strLogin
	 * @return Usuario
	 */
	public function procurarUsuarioPorLogin($strLogin){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario, null, $this->objRepositorioSetor);
		return $objControladorUsuario->procurarUsuarioPorLogin($strLogin);
	}

	/**
	 * Método que lista todos os usuários pertencente ao grupo informado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarUsuariosPorIdGrupo($intIdGrupo){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario);
		return $objControladorUsuario->listarUsuariosPorIdGrupo($intIdGrupo);
	}

	/**
	 * Método que autentica o usuário no servidor de autenticação
	 *
	 * @access public
	 * @param string $strLogin
	 * @param string $strSenha
	 * @return boolean
	 */
	public function autenticarUsuario($strLogin, $strSenha){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario, $this->objRepositorioGrupo, null, $this->objRepositorioChamado);
		return $objControladorUsuario->autenticarUsuario($strLogin, $strSenha);
	}

	/**
	 * Método que verifica se o usuário possui uma sessão válida
	 *
	 * @access public
	 * @return void
	 */
	public function validarSessaoUsuario(){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario);
		$objControladorUsuario->validarSessaoUsuario();
	}

	/**
	 * Método que verifica se o usuário possui uma sessão administativa válida
	 *
	 * @access public
	 * @return void
	 */
	public function validarSessaoAdmin(){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario);
		$objControladorUsuario->validarSessaoAdmin();
	}

	/**
	 * Método que encerra a sessão do usuário
	 *
	 * @access public
	 * @return void
	 */
	public function fecharSessaoUsuario(){
		$objControladorUsuario = new ControladorUsuario($this->objRepositorioUsuario);
		$objControladorUsuario->fecharSessaoUsuario();
	}


	/***********************
	 *       SETORES
	 **********************/
	/**
	 * Método que cadastra um Setor no RepositorioSetor
	 *
	 * @access public
	 * @param string $strDescricaoSetor
	 * @param string $strCodigoCentroCusto
	 * @param boolean $bolStatusSetor
	 * @return void
	 */
	public function cadastrarSetor($strDescricaoSetor, $strCodigoCentroCusto, $bolStatusSetor) {
		$objControladorSetor = new ControladorSetor($this->objRepositorioSetor);
		$objControladorSetor->cadastrarSetor($strDescricaoSetor, $strCodigoCentroCusto, $bolStatusSetor);
	}

	/**
	 * Método que lista todos os Setores Ativos no RepositorioSetor
	 *
	 * @access public
	 * @return array
	 */
	public function listarSetoresAtivos() {
		$objControladorSetor = new ControladorSetor($this->objRepositorioSetor);
		return $objControladorSetor->listarSetoresAtivos();
	}


	/***********************
	 *       FERIADO
	 **********************/
	/**
	 * Método que cadastra um Feriado no RepositorioFeriado
	 * 
	 * @param int $intIdFeriado
	 * @param string $strDataFeriado
	 * @param string $strDescricaoFeriado
	 * @return void
	 */
	public function cadastrarFeriado($intIdGrupo, $strDataFeriado, $strDescricaoFeriado) {
		$objControladorFeriado = new ControladorFeriado($this->objRepositorioFeriado);
		$objControladorFeriado->cadastrarFeriado($intIdGrupo, $strDataFeriado, $strDescricaoFeriado);
	}

	/**
	 * Método que atualiza um Feriado no RepositorioFeriado
	 * 
	 * @param int $intIdFeriado
	 * @param int $intIdGrupo
	 * @param string $strDataFeriado
	 * @param string $strDescricaoFeriado
	 * @return void
	 */
	public function atualizarFeriado($intIdFeriado, $intIdGrupo, $strDataFeriado, $strDescricaoFeriado) {
		$objControladorFeriado = new ControladorFeriado($this->objRepositorioFeriado);
		$objControladorFeriado->atualizarFeriado($intIdFeriado, $intIdGrupo, $strDataFeriado, $strDescricaoFeriado);
	}

	/**
	 * Método que exclui um Feriado no RepositorioFeriado
	 * 
	 * @param int $intIdFeriado
	 * @return void
	 */
	public function excluirFeriado($intIdFeriado) {
		$objControladorFeriado = new ControladorFeriado($this->objRepositorioFeriado);
		return $objControladorFeriado->excluirFeriado($intIdFeriado);
	}

	/**
	 * Método que procura um Feriado especificado
	 * 
	 * @param int $intIdFeriado
	 * @return Feriado
	 */
	public function procurarFeriado($intIdFeriado){
		$objControladorFeriado = new ControladorFeriado($this->objRepositorioFeriado);
		return $objControladorFeriado->procurarFeriado($intIdFeriado);
	}

	/**
	 * Método que lista todos os Feriados do Grupo especificado
	 * 
	 * @param $intIdGrupo
	 * @return array
	 */
	public function listarFeriadosPorIdGrupo($intIdGrupo) {
		$objControladorFeriado = new ControladorFeriado($this->objRepositorioFeriado);
		return $objControladorFeriado->listarFeriadosPorIdGrupo($intIdGrupo);
	}


	/***********************
	 *     RELATORIOS
	 **********************/
	/**
	 * Método do relatorio de Chamados Por Sla Mensal
	 *
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSlaMensal(array $arrParametro){
		$objControladorRelatorio = new ControladorRelatorio($this->objRepositorioRelatorio);
		return $objControladorRelatorio->relatorioChamadosPorSlaMensal($arrParametro);
	}
	
	/**
	 * Método do relatorio de Chamados Listagem Geral
	 *
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSlaGeral(array $arrParametro){
		$objControladorRelatorio = new ControladorRelatorio($this->objRepositorioRelatorio);
		return $objControladorRelatorio->relatorioChamadosPorSlaGeral($arrParametro);
	}
	
	/**
	 * Método do relatorio de Chamados Abertos e Fechados
	 *
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosAbertosFechados(array $arrParametro){
		$objControladorRelatorio = new ControladorRelatorio($this->objRepositorioRelatorio);
		return $objControladorRelatorio->relatorioChamadosAbertosFechados($arrParametro);
	}
	
	/**
	 * Método do relatorio de Chamados Por Assunto
	 *
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorAssunto(array $arrParametro){
		$objControladorRelatorio = new ControladorRelatorio($this->objRepositorioRelatorio);
		return $objControladorRelatorio->relatorioChamadosPorAssunto($arrParametro);
	}
	
	/**
	 * Método do relatorio de Chamados Por Setor
	 *
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSetor(array $arrParametro){
		$objControladorRelatorio = new ControladorRelatorio($this->objRepositorioRelatorio);
		return $objControladorRelatorio->relatorioChamadosPorSetor($arrParametro);
	}
	
	/**
	 * Método do relatorio de Chamados Por Grupo
	 *
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorGrupo(array $arrParametro){
		$objControladorRelatorio = new ControladorRelatorio($this->objRepositorioRelatorio);
		return $objControladorRelatorio->relatorioChamadosPorGrupo($arrParametro);
	}
	
}