<?php
/**
 * Classe básica de Chamados
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:26:07
 */
class Chamado {
	/**
	 * Identificador do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdChamado;
	
	/**
	 * Identificador do Assunto do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdAssunto;
	
	/**
	 * Identificador do Usuário de Origem do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuarioOrigem;
	
	/**
	 * Identificador do Usuario de Destino do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuarioDestino;
	
	/**
	 * Identificador do Grupo de Destino do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupoDestino;
	
	/**
	 * Identificador do Usuário que Encerrou o Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuarioFechador;
	
	/**
	 * Código da Prioridade do Chamado. Exemplo: Baixa, Normal, Urgente, etc.
	 *
	 * @access private
	 * @var int
	 */
	private $intCodigoPrioridade;
	
	/**
	 * Descrição do Problema do Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strDescricaoChamado;
	
	/**
	 * Justificativa Textual de Prioridade
	 *
	 * @access private
	 * @var string
	 */
	private $strJustificativaPrioridade;
	
	/**
	 * Status do Chamado. Indica o estado do chamado: Aberto, Fechado, Cancelado, etc.
	 *
	 * @access private
	 * @var int
	 */
	private $intStatusChamado;
	
	/**
	 * Data de Abertura do Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strDataAbertura;
	
	/**
	 * Data do Prazo Máximo do Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strDataPrazo;
	
	/**
	 * Data de Encerramento do Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strDataFechamento;
	
	/**
	 * Flag Indicativa do Envio de Emails
	 *
	 * @access private
	 * @var int
	 */
	private $intStatusEmail;
	
	/**
	 * Código do Chamado aberto em um Fornecedor Externo
	 *
	 * @access private
	 * @var string
	 */
	private $strCodigoChamadoExterno;
	
	/**
	 * Objeto Assunto
	 *
	 * @access private
	 * @var Assunto
	 */
	private $objAssunto = null;
	
	/**
	 * Objeto Usuario de Origem
	 *
	 * @access private
	 * @var Usuario
	 */
	private $objUsuarioOrigem = null;
	
	/**
	 * Objeto Usuario de Destino
	 *
	 * @access private
	 * @var Usuario
	 */
	private $objUsuarioDestino = null;
	
	/**
	 * Objeto Grupo de Destino
	 *
	 * @access private
	 * @var Grupo
	 */
	private $objGrupoDestino = null;
	
	/**
	 * Objeto Usuario Fechador
	 *
	 * @access private
	 * @var Usuario
	 */
	private $objUsuarioFechador = null;
	
	/**
	 * Array contendo os objetos Encaminhamento
	 *
	 * @access private
	 * @var array
	 */
	private $arrObjEncaminhamento = array();
	
	/**
	 * Array contendo os objetos Historico
	 *
	 * @access private
	 * @var array
	 */
	private $arrObjHistorico = array();
	
	/**
	 * Contem os emails de contatos
	 * 
	 * @var String $strEmailCopia
	 */
	private $strEmailCopia;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @param int $intIdAssunto
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdUsuarioDestino
	 * @param int $intIdGrupoDestino
	 * @param int $intIdUsuarioFechador
	 * @param int $intCodigoPrioridade
	 * @param string $strDescricaoChamado
	 * @param string $strJustificativaPrioridade
	 * @param int $intStatusChamado
	 * @param string $strDataAbertura
	 * @param string $strDataPrazo
	 * @param string $strDataFechamento
	 * @param int $intStatusEmail
	 * @param string $strEmailCopia
	 * @param string $strCodigoChamadoExterno
	 */
	public function __construct($intIdChamado, $intIdAssunto, $intIdUsuarioOrigem, $intIdUsuarioDestino, $intIdGrupoDestino, $intIdUsuarioFechador, $intCodigoPrioridade, $strDescricaoChamado, $strJustificativaPrioridade, $intStatusChamado, $strDataAbertura, $strDataPrazo, $strDataFechamento, $intStatusEmail, $strEmailCopia, $strCodigoChamadoExterno="") {
		$this->setIdChamado($intIdChamado);
		$this->setIdAssunto($intIdAssunto);
		$this->setIdUsuarioOrigem($intIdUsuarioOrigem);
		$this->setIdUsuarioDestino($intIdUsuarioDestino);
		$this->setIdGrupoDestino($intIdGrupoDestino);
		$this->setIdUsuarioFechador($intIdUsuarioFechador);
		$this->setCodigoPrioridade($intCodigoPrioridade);
		$this->setDescricaoChamado($strDescricaoChamado);
		$this->setJustificativaPrioridade($strJustificativaPrioridade);
		$this->setStatusChamado($intStatusChamado);
		$this->setDataAbertura($strDataAbertura);
		$this->setDataPrazo($strDataPrazo);
		$this->setDataFechamento($strDataFechamento);
		$this->setStatusEmail($intStatusEmail);
		$this->setEmailCopia($strEmailCopia);
		$this->setCodigoChamadoExterno($strCodigoChamadoExterno);
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdChamado</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdChamado() {
		return $this->intIdChamado;
	}
	
	/**
	 * Define o valor de <var>$this->intIdChamado</var>
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @return void
	 */
	public function setIdChamado($intIdChamado) {
		$this->intIdChamado = (int) $intIdChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdAssunto</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdAssunto() {
		return $this->intIdAssunto;
	}
	
	/**
	 * Define o valor de <var>$this->intIdAssunto</var>
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @return void
	 */
	public function setIdAssunto($intIdAssunto) {
		$this->intIdAssunto = (int) $intIdAssunto;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdUsuarioOrigem</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuarioOrigem() {
		return $this->intIdUsuarioOrigem;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuarioOrigem</var>
	 *
	 * @access public
	 * @param int $intIdUsuarioOrigem
	 * @return void
	 */
	public function setIdUsuarioOrigem($intIdUsuarioOrigem) {
		$this->intIdUsuarioOrigem = (int) $intIdUsuarioOrigem;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdUsuarioDestino</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuarioDestino() {
		return $this->intIdUsuarioDestino;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuarioDestino</var>
	 *
	 * @access public
	 * @param int $intIdUsuarioDestino
	 * @return void
	 */
	public function setIdUsuarioDestino($intIdUsuarioDestino) {
		$this->intIdUsuarioDestino = (int) $intIdUsuarioDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdGrupoDestino</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdGrupoDestino() {
		return $this->intIdGrupoDestino;
	}
	
	/**
	 * Define o valor de <var>$this->intIdGrupoDestino</var>
	 *
	 * @access public
	 * @param int $intIdGrupoDestino
	 * @return void
	 */
	public function setIdGrupoDestino($intIdGrupoDestino) {
		$this->intIdGrupoDestino = (int) $intIdGrupoDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdUsuarioFechador</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuarioFechador() {
		return $this->intIdUsuarioFechador;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuarioFechador</var>
	 *
	 * @access public
	 * @param int $intIdUsuarioFechador
	 * @return void
	 */
	public function setIdUsuarioFechador($intIdUsuarioFechador) {
		$this->intIdUsuarioFechador = (int) $intIdUsuarioFechador;
	}
	
	/**
	 * Retorna o valor de <var>$this->intCodigoPrioridade</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getCodigoPrioridade() {
		return $this->intCodigoPrioridade;
	}
	
	/**
	 * Define o valor de <var>$this->intCodigoPrioridade</var>
	 *
	 * @access public
	 * @param int $intCodigoPrioridade
	 * @return void
	 */
	public function setCodigoPrioridade($intCodigoPrioridade) {
		$this->intCodigoPrioridade = (int) $intCodigoPrioridade;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDescricaoChamado</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDescricaoChamado() {
		return $this->strDescricaoChamado;
	}
	
	/**
	 * Define o valor de <var>$this->strDescricaoChamado</var>
	 *
	 * @access public
	 * @param string $strDescricaoChamado
	 * @return void
	 */
	public function setDescricaoChamado($strDescricaoChamado) {
		$this->strDescricaoChamado = (string) $strDescricaoChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->strJustificativaPrioridade</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getJustificativaPrioridade() {
		return $this->strJustificativaPrioridade;
	}
	
	/**
	 * Define o valor de <var>$this->strJustificativaPrioridade</var>
	 *
	 * @access public
	 * @param string $strJustificativaPrioridade
	 * @return void
	 */
	public function setJustificativaPrioridade($strJustificativaPrioridade) {
		$this->strJustificativaPrioridade = (string) $strJustificativaPrioridade;
	}
	
	/**
	 * Retorna o valor de <var>$this->intStatusChamado</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getStatusChamado() {
		return $this->intStatusChamado;
	}
	
	/**
	 * Define o valor de <var>$this->intStatusChamado</var>
	 *
	 * @access public
	 * @param int $intStatusChamado
	 * @return void
	 */
	public function setStatusChamado($intStatusChamado) {
		$this->intStatusChamado = (int) $intStatusChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataAbertura</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataAbertura() {
		return $this->strDataAbertura;
	}
	
	/**
	 * Define o valor de <var>$this->strDataAbertura</var>
	 *
	 * @access public
	 * @param string $strDataAbertura
	 * @return void
	 */
	public function setDataAbertura($strDataAbertura) {
		$this->strDataAbertura = (string) $strDataAbertura;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataPrazo</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataPrazo() {
		return $this->strDataPrazo;
	}
	
	/**
	 * Define o valor de <var>$this->strDataPrazo</var>
	 *
	 * @access public
	 * @param string $strDataPrazo
	 * @return void
	 */
	public function setDataPrazo($strDataPrazo) {
		$this->strDataPrazo = (string) $strDataPrazo;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataFechamento</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataFechamento() {
		return $this->strDataFechamento;
	}
	
	/**
	 * Define o valor de <var>$this->strDataFechamento</var>
	 *
	 * @access public
	 * @param string $strDataFechamento
	 * @return void
	 */
	public function setDataFechamento($strDataFechamento) {
		$this->strDataFechamento = (string) $strDataFechamento;
	}
	
	/**
	 * Retorna o valor de <var>$this->intStatusEmail</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getStatusEmail() {
		return $this->intStatusEmail;
	}
	
	/**
	 * Define o valor de <var>$this->intStatusEmail</var>
	 *
	 * @access public
	 * @param int $intStatusEmail
	 * @return void
	 */
	public function setStatusEmail($intStatusEmail) {
		$this->intStatusEmail = (int) $intStatusEmail;
	}
	
	/**
	 * Retorna o valor de <var>$this->strEmailCopia</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getEmailCopia() {
		return $this->strEmailCopia;
	}
	
	/**
	 * Define o valor de <var>$this->strEmailCopia</var>
	 *
	 * @access public
	 * @param string $strEmailCopia
	 * @return void
	 */
	public function setEmailCopia($strEmailCopia) {
		$this->strEmailCopia = (string) $strEmailCopia;
	}
	
	/**
	 * Retorna o valor de <var>$this->strCodigoChamadoExterno</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getCodigoChamadoExterno() {
		return $this->strCodigoChamadoExterno;
	}
	
	/**
	 * Define o valor de <var>$this->strCodigoChamadoExterno</var>
	 *
	 * @access public
	 * @param string $strCodigoChamadoExterno
	 * @return void
	 */
	public function setCodigoChamadoExterno($strCodigoChamadoExterno) {
		$this->strCodigoChamadoExterno = (string) $strCodigoChamadoExterno;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @return boolean
	 */
	public function equals(Chamado $objChamado) {
		if ($this->intIdChamado == $objChamado->getIdChamado() &&
			$this->intIdAssunto == $objChamado->getIdAssunto() &&
			$this->intIdUsuarioOrigem == $objChamado->getIdUsuarioOrigem() &&
			$this->intIdUsuarioDestino == $objChamado->getIdUsuarioDestino() &&
			$this->intIdGrupoDestino == $objChamado->getIdGrupoDestino() &&
			$this->intIdUsuarioFechador == $objChamado->getIdUsuarioFechador() &&
			$this->intCodigoPrioridade == $objChamado->getCodigoPrioridade() &&
			$this->strDescricaoChamado == $objChamado->getDescricaoChamado() &&
			$this->strJustificativaPrioridade == $objChamado->getJustificativaPrioridade() &&
			$this->intStatusChamado == $objChamado->getStatusChamado() &&
			$this->strDataAbertura == $objChamado->getDataAbertura() &&
			$this->strDataPrazo == $objChamado->getDataPrazo() &&
			$this->strDataFechamento == $objChamado->getDataFechamento() &&
			$this->intStatusEmail == $objChamado->getStatusEmail()) return true;
		return false;
	}
	
	/**
	 * Retorna o valor de <var>$this->objAssunto</var>
	 *
	 * @access public
	 * @return Assunto
	 */
	public function getAssunto() {
		return $this->objAssunto;
	}
	
	/**
	 * Define o valor de <var>$this->objAssunto</var>
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @return void
	 */
	public function setAssunto(Assunto $objAssunto) {
		$this->objAssunto = $objAssunto;
	}
	
	/**
	 * Retorna o valor de <var>$this->objUsuarioOrigem</var>
	 *
	 * @access public
	 * @return Usuario
	 */
	public function getUsuarioOrigem() {
		return $this->objUsuarioOrigem;
	}
	
	/**
	 * Define o valor de <var>$this->objUsuarioOrigem</var>
	 *
	 * @access public
	 * @param Usuario $objUsuarioOrigem
	 * @return void
	 */
	public function setUsuarioOrigem(Usuario $objUsuarioOrigem) {
		$this->objUsuarioOrigem = $objUsuarioOrigem;
	}
	
	/**
	 * Retorna o valor de <var>$this->objUsuarioDestino</var>
	 *
	 * @access public
	 * @return Usuario
	 */
	public function getUsuarioDestino() {
		return $this->objUsuarioDestino;
	}
	
	/**
	 * Define o valor de <var>$this->objUsuarioDestino</var>
	 *
	 * @access public
	 * @param Usuario $objUsuarioDestino
	 * @return void
	 */
	public function setUsuarioDestino(Usuario $objUsuarioDestino) {
		$this->objUsuarioDestino = $objUsuarioDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->objGrupoDestino</var>
	 *
	 * @access public
	 * @return Grupo
	 */
	public function getGrupoDestino() {
		return $this->objGrupoDestino;
	}
	
	/**
	 * Define o valor de <var>$this->objGrupoDestino</var>
	 *
	 * @access public
	 * @param Grupo $objGrupoDestino
	 * @return void
	 */
	public function setGrupoDestino(Grupo $objGrupoDestino) {
		$this->objGrupoDestino = $objGrupoDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->objUsuarioFechador</var>
	 *
	 * @access public
	 * @return Usuario
	 */
	public function getUsuarioFechador() {
		return $this->objUsuarioFechador;
	}
	
	/**
	 * Define o valor de <var>$this->objUsuarioFechador</var>
	 *
	 * @access public
	 * @param Usuario $objUsuarioFechador
	 * @return void
	 */
	public function setUsuarioFechador(Usuario $objUsuarioFechador) {
		$this->objUsuarioFechador = $objUsuarioFechador;
	}
	
	/**
	 * Retorna o valor de <var>$this->arrObjEncaminhamento</var>
	 *
	 * @access public
	 * @return array
	 */
	public function getEncaminhamento() {
		return $this->arrObjEncaminhamento;
	}
	
	/**
	 * Define o valor de $this->arrObjEncaminhamento
	 *
	 * @access public
	 * @param array $arrObjEncaminhamento
	 * @return void
	 */
	public function setEncaminhamento($arrObjEncaminhamento) {
		$this->arrObjEncaminhamento = array();
		if (is_array($arrObjEncaminhamento)) {
			foreach ($arrObjEncaminhamento as $objEncaminhamento) {
				$this->adicionarEncaminhamento($objEncaminhamento);
			}
		}
	}
	
	/**
	 * Adiciona um objeto Encaminhamento ao array $this->arrObjEncaminhamento
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @return void
	 */
	public function adicionarEncaminhamento(Encaminhamento $objEncaminhamento) {
		$this->arrObjEncaminhamento[] = $objEncaminhamento;
	}
	
	/**
	 * Retorna o valor de <var>$this->arrObjHistorico</var>
	 *
	 * @access public
	 * @return array
	 */
	public function getHistorico() {
		return $this->arrObjHistorico;
	}
	
	/**
	 * Define o valor de $this->arrObjHistorico
	 *
	 * @access public
	 * @param array $arrObjHistorico
	 * @return void
	 */
	public function setHistorico($arrObjHistorico) {
		$this->arrObjHistorico = array();
		if (is_array($arrObjHistorico)) {
			foreach ($arrObjHistorico as $objHistorico) {
				$this->adicionarHistorico($objHistorico);
			}
		}
	}
	
	/**
	 * Adiciona um objeto Historico ao array $this->arrObjHistorico
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @return void
	 */
	public function adicionarHistorico(Historico $objHistorico) {
		$this->arrObjHistorico[] = $objHistorico;
	}
	
}