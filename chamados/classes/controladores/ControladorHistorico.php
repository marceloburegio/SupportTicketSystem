<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Historicos
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorHistorico {
	/**
	 * Repositório da Classe Historico
	 *
	 * @access private
	 * @var IRepositorioHistorico
	 */
	private $objRepositorioHistorico;
	
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
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioHistorico $objRepositorioHistorico = null
	 * @param IRepositorioChamado $objRepositorioChamado = null
	 * @param IRepositorioAssunto $objRepositorioAssunto = null
	 * @param IRepositorioGrupo $objRepositorioGrupo = null
	 * @param IRepositorioUsuario $objRepositorioUsuario = null
	 * @param IRepositorioSetor $objRepositorioSetor = null
	 */
	public function __construct(IRepositorioHistorico $objRepositorioHistorico = null, IRepositorioChamado $objRepositorioChamado = null, IRepositorioAssunto $objRepositorioAssunto = null, IRepositorioGrupo $objRepositorioGrupo = null, IRepositorioUsuario $objRepositorioUsuario = null, IRepositorioSetor $objRepositorioSetor = null) {
		$this->objRepositorioHistorico = $objRepositorioHistorico;
		$this->objRepositorioChamado = $objRepositorioChamado;
		$this->objRepositorioAssunto = $objRepositorioAssunto;
		$this->objRepositorioGrupo = $objRepositorioGrupo;
		$this->objRepositorioUsuario = $objRepositorioUsuario;
		$this->objRepositorioSetor = $objRepositorioSetor;
	}
	
	/**
	 * Método que lista o histórico de chamados do chamado especificado
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @return array
	 */
	public function listarHistoricoPorIdChamado($intIdChamado) {
		// Inicializando os cadastros
		$objCadastroHistorico	= new CadastroHistorico($this->objRepositorioHistorico);
		$objCadastroUsuario		= new CadastroUsuario($this->objRepositorioUsuario);
		
		// Removendo os espaços vazios
		$intIdChamado = (int) $intIdChamado;
		
		// Validando os dados
		if ($intIdChamado <= 0) throw new CampoObrigatorioException("ID do Chamado");
		
		// Listando todo o historico
		$arrObjHistorico = $objCadastroHistorico->listarPorIdChamado($intIdChamado);
		
		// Populando o Histórico
		foreach ($arrObjHistorico as $objHistorico) {
			$objUsuario = $objCadastroUsuario->procurar($objHistorico->getIdUsuario());
			$objHistorico->setUsuario($objUsuario);
		}
		return $arrObjHistorico;
	}

	/**
	 * Método que lista o histórico de chamados do chamado especificado (ordenado pelos recentes)
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @return array
	 */
	public function listarHistoricoPorIdChamadoOrdenadoRecentes($intIdChamado) {
		// Inicializando os cadastros
		$objCadastroHistorico	= new CadastroHistorico($this->objRepositorioHistorico);
		$objCadastroUsuario		= new CadastroUsuario($this->objRepositorioUsuario);
		
		// Removendo os espaços vazios
		$intIdChamado = (int) $intIdChamado;
		
		// Validando os dados
		if ($intIdChamado <= 0) throw new CampoObrigatorioException("ID do Chamado");
		
		// Listando todo o historico
		$arrObjHistorico = $objCadastroHistorico->listarPorIdChamadoOrdenadoRecentes($intIdChamado);
		
		// Populando o Histórico
		foreach ($arrObjHistorico as $objHistorico) {
			$objUsuario = $objCadastroUsuario->procurar($objHistorico->getIdUsuario());
			$objHistorico->setUsuario($objUsuario);
		}
		return $arrObjHistorico;
	}
	
	/**
	 * Método que lista cadastra um novo histórico do chamado especificado
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @param int $intIdUsuario
	 * @param string $strDescricaoHistorico
	 * @param string $strAcaoChamado
	 * @param string $strNomeArquivoAnexo
	 * @param string $strCaminhoArquivoAnexo
	 * @return void
	 */
	public function cadastrarHistorico($intIdChamado, $intIdUsuario, $strDescricaoHistorico, $strAcaoChamado, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strCodigoChamadoExterno) {
		// Inicializando os cadastros
		$objCadastroHistorico	= new CadastroHistorico($this->objRepositorioHistorico);
		$objCadastroChamado		= new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$intIdChamado				= (int) $intIdChamado;
		$intIdUsuario				= (int) $intIdUsuario;
		$strDescricaoHistorico		= (string) $strDescricaoHistorico;
		$strAcaoChamado				= (string) $strAcaoChamado;
		$strNomeArquivoAnexo		= (string) $strNomeArquivoAnexo;
		$strCaminhoArquivoAnexo		= (string) $strCaminhoArquivoAnexo;
		$strCodigoChamadoExterno	= (string) $strCodigoChamadoExterno;
		
		// Validando os dados
		if ($intIdChamado <= 0)					throw new CampoObrigatorioException("ID do Chamado");
		if ($intIdUsuario <= 0)					throw new CampoObrigatorioException("ID do Usuário");
		if (strlen($strDescricaoHistorico) < 1)	throw new CampoObrigatorioException("Descrição do Histórico");
		if (strlen($strAcaoChamado) < 1)		throw new CampoObrigatorioException("Ação do Chamado");
		
		//verificando se o arquivo anexo foi enviado corretamente
		if(!file_exists(Config::getCaminhoArquivosAnexos().DIRECTORY_SEPARATOR.$strCaminhoArquivoAnexo))
			throw new Exception("O arquivo anexo não foi enviado corretamente. \nRemova-o, envie novamente e tente cadastrar o chamado mais uma vez.");
		
		// Obtendo o chamado atual
		$objChamado = $objCadastroChamado->procurar($intIdChamado);
		
		// Definindo o status do chamado
		$intStatusChamado = $objChamado->getStatusChamado();
		$strDataFechamento = $objChamado->getDataFechamento();
		$intIdUsuarioFechador = $objChamado->getIdUsuarioFechador();
		switch ($strAcaoChamado) {
			case "fechar" :
				$intStatusChamado = 2;
				$intTipoHistorico = 3;
				$strDataFechamento = date("Y-m-d H:i:s");
				$intIdUsuarioFechador = (int) @$_SESSION["intIdUsuario"];
				$strAssuntoEmail = "Fechamento do Chamado";
				break;
			case "cancelar" :
				$intStatusChamado = 9;
				$intTipoHistorico = 6;
				$strDataFechamento = date("Y-m-d H:i:s");
				$intIdUsuarioFechador = (int) @$_SESSION["intIdUsuario"];
				$strAssuntoEmail = "Cancelamento do Chamado";
				break;
			case "reabrir" :
				$intStatusChamado = 1;
				$intTipoHistorico = 5;
				$strDataFechamento = null;
				$intIdUsuarioFechador = 0;
				$strAssuntoEmail = "Reabertura do Chamado";
				break;
			default :
				$intTipoHistorico = 1;
				$strCodigoChamadoExterno = (strlen($strCodigoChamadoExterno) > 0) ? $strCodigoChamadoExterno : $objChamado->getCodigoChamadoExterno();
				$strAssuntoEmail = "Movimentação do Chamado";
		}
		
		// Cadastrando o Histórico
		$intIdHistorico = 0;
		$strDataHistorico = date("Y-m-d H:i:s");
		$objHistorico = new Historico($intIdHistorico, $intIdChamado, $intIdUsuario, $intTipoHistorico, $strDescricaoHistorico, $strDataHistorico, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo);
		$objCadastroHistorico->cadastrar($objHistorico);
		
		// Definindo o novo status do chamado
		$objChamado->setStatusChamado($intStatusChamado);
		$objChamado->setDataFechamento($strDataFechamento);
		$objChamado->setIdUsuarioFechador($intIdUsuarioFechador);
		$objChamado->setCodigoChamadoExterno($strCodigoChamadoExterno);
		$objCadastroChamado->atualizar($objChamado);
		
		// Enviando o email do cadastramento do chamado
		$objControladorEmail = new ControladorEmail($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
		$strAssuntoEmail = "Chamado No. ". $intIdChamado ." - ". $strAssuntoEmail;
		$objControladorEmail->enviarChamadoPorEmail($intIdChamado, $strAssuntoEmail);
	}
	
	/**
	 * Método que procura um histórico no repositório
	 * 
	 * @access public
	 * @param int $intIdHistorico
	 * @return array
	 */
	public function procurarHistorico($intIdHistorico) {
		// Inicializando os cadastros
		$objCadastroHistorico	= new CadastroHistorico($this->objRepositorioHistorico);
		$objCadastroUsuario		= new CadastroUsuario($this->objRepositorioUsuario);
		
		// Removendo os espaços vazios
		$intIdHistorico = (int) $intIdHistorico;
		
		// Validando os dados
		if ($intIdHistorico <= 0) throw new CampoObrigatorioException("ID do Histórico");
		
		// Listando todo o historico
		$objHistorico = $objCadastroHistorico->procurar($intIdHistorico);
		
		// Populando o Histórico
		$objUsuario = $objCadastroUsuario->procurar($objHistorico->getIdUsuario());
		$objHistorico->setUsuario($objUsuario);
		return $objHistorico;
	}
}