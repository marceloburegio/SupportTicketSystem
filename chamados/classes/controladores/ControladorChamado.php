<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Chamados
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorChamado {
	/**
	 * Repositório da Classe Chamado
	 *
	 * @access private
	 * @var IRepositorioChamado
	 */
	private $objRepositorioChamado;
	
	/**
	 * Repositório da Classe Encaminhamento
	 *
	 * @access private
	 * @var IRepositorioEncaminhamento
	 */
	private $objRepositorioEncaminhamento;
	
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
	 * Repositório da Classe Horario
	 *
	 * @access private
	 * @var IRepositorioHorario
	 */
	private $objRepositorioHorario;
	
		/**
	 * Repositório da Classe Horario
	 *
	 * @access private
	 * @var IRepositorioHorario
	 */
	private $objRepositorioFeriado;
	
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
	 * @param IRepositorioHorario $objRepositorioHorario = null
	 */
	public function __construct(IRepositorioChamado $objRepositorioChamado = null, IRepositorioAssunto $objRepositorioAssunto = null, IRepositorioGrupo $objRepositorioGrupo = null, IRepositorioUsuario $objRepositorioUsuario = null, IRepositorioSetor $objRepositorioSetor = null, IRepositorioHistorico $objRepositorioHistorico = null, IRepositorioHorario $objRepositorioHorario = null, IRepositorioEncaminhamento $objRepositorioEncaminhamento = null, IRepositorioFeriado $objRepositorioFeriado = null) {
		$this->objRepositorioChamado = $objRepositorioChamado;
		$this->objRepositorioAssunto = $objRepositorioAssunto;
		$this->objRepositorioGrupo = $objRepositorioGrupo;
		$this->objRepositorioUsuario = $objRepositorioUsuario;
		$this->objRepositorioSetor = $objRepositorioSetor;
		$this->objRepositorioHistorico = $objRepositorioHistorico;
		$this->objRepositorioHorario = $objRepositorioHorario;
		$this->objRepositorioEncaminhamento = $objRepositorioEncaminhamento;
		$this->objRepositorioFeriado = $objRepositorioFeriado;
	}
	
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
	 * @return void
	 */
	public function cadastrarChamado($intIdUsuarioOrigem, $intIdGrupoDestino, $intIdAssunto, $strDescricaoChamado, $intCodigoPrioridade, $strJustificativaPrioridade,  $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strEmailCopia) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		$objCadastroHistorico = new CadastroHistorico($this->objRepositorioHistorico);
		
		// Removendo os espaços vazios
		$intIdUsuarioOrigem			= (int) $intIdUsuarioOrigem;
		$intIdGrupoDestino			= (int) $intIdGrupoDestino;
		$intIdAssunto				= (int) $intIdAssunto;
		$strDescricaoChamado		= (string) trim($strDescricaoChamado);
		$intCodigoPrioridade		= (int) $intCodigoPrioridade;
		$strJustificativaPrioridade	= (string) trim($strJustificativaPrioridade);
		$strNomeArquivoAnexo		= (string) $strNomeArquivoAnexo;
		$strCaminhoArquivoAnexo		= (string) $strCaminhoArquivoAnexo;
		$strEmailCopia				= (string) trim($strEmailCopia);
		
		// Validando os dados
		if ($intIdUsuarioOrigem <= 0)					throw new CampoObrigatorioException("ID do Usuário");
		if ($intIdGrupoDestino <= 0)					throw new CampoObrigatorioException("ID do Grupo");
		if ($intIdAssunto <= 0)							throw new CampoObrigatorioException("ID do Assunto");
		if (strlen($strDescricaoChamado) < 1)			throw new CampoObrigatorioException("Descrição do Chamado");
		if ($intCodigoPrioridade <= 0)					throw new CampoObrigatorioException("Código da Prioridade");
		if ($intCodigoPrioridade == 4 && strlen(trim($strJustificativaPrioridade)) < 1) {
			throw new CampoObrigatorioException("Justificativa de Prioridade");
		}
		
		// Verificando se o arquivo anexo foi enviado corretamente
		if(!file_exists(Config::getCaminhoArquivosAnexos().DIRECTORY_SEPARATOR.$strCaminhoArquivoAnexo))
			throw new Exception("O arquivo anexo não foi enviado corretamente. \nRemova-o, envie novamente e tente cadastrar o chamado mais uma vez.");
		
		// Validando o campo de e-mails em cópia
		$arrEmailCopia = array();
		$arrEmail = explode(",", str_replace(";", ",", $strEmailCopia));
		foreach ($arrEmail as $strEmail) {
			$strEmail = trim($strEmail);
			if (strlen($strEmail) != 0) {
				if (!Util::verificaEmail($strEmail)) throw new CampoObrigatorioException("E-mail inválido: " . $strEmail);
				$arrEmailCopia[] = strtolower($strEmail);
			}
		}
		$strEmailCopia = implode(",", $arrEmailCopia);
		
		// Criando o novo objeto de chamado
		$intIdChamado			= 0;
		$intIdUsuarioDestino	= 0;
		$intIdUsuarioFechador	= 0;
		$intStatusChamado		= 1; // Status = Aberto
		$strDataAbertura		= date("Y-m-d H:i:s");
		$strDataPrazo			= $this->calcularDataPrazo($intIdGrupoDestino, $intIdAssunto, $strDataAbertura);
		$strDataFechamento		= null;
		$intStatusEmail			= 0;
		
		// Cadastrando o chamado
		$objChamado = new Chamado($intIdChamado, $intIdAssunto, $intIdUsuarioOrigem, $intIdUsuarioDestino, $intIdGrupoDestino, $intIdUsuarioFechador, $intCodigoPrioridade, $strDescricaoChamado, $strJustificativaPrioridade, $intStatusChamado, $strDataAbertura, $strDataPrazo, $strDataFechamento, $intStatusEmail, $strEmailCopia);
		$intIdChamado = $objCadastroChamado->cadastrar($objChamado);
		$objChamado->setIdChamado($intIdChamado);
		
		// Cadastrando o histórico de abertura
		$intIdHistorico			= 0;
		$intIdUsuario			= $intIdUsuarioOrigem;
		$intTipoHistorico		= 2; // Tipo de Histórico = Abertura
		$strDescricaoHistorico	= "Abertura do chamado.";
		$strDataHistorico		= date("Y-m-d H:i:s");
		$strNomeArquivoAnexo	= (string) $strNomeArquivoAnexo;
		$strCaminhoArquivoAnexo	= (string) $strCaminhoArquivoAnexo;
		
		// Cadastrando o histórico 
		$objHistorico = new Historico($intIdHistorico, $intIdChamado, $intIdUsuario, $intTipoHistorico, $strDescricaoHistorico, $strDataHistorico, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo);
		$objCadastroHistorico->cadastrar($objHistorico);
		
		return $intIdChamado;
	}
	
	/**
	 * Método que ira listar os chamados enviados pelo usuário
	 * 
	 * @access public
	 * @param array $arrParametro
	 * @param int $intOffSet
	 * @return array
	 */
	public function listarChamadosEnviadosPorParametro($arrParametro, $intOffSet = 0) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$arrParametro["intIdUsuario"]	= (int) @$arrParametro["intIdUsuario"];
		$arrParametro["strDataInicial"]	= (string) @$arrParametro["strDataInicial"];
		$arrParametro["strDataFinal"]	= (string) @$arrParametro["strDataFinal"];
		$arrParametro["intStatus"]		= (int) @$arrParametro["intStatus"];
		$arrParametro["intIdGrupo"]		= (int) @$arrParametro["intIdGrupo"];
		$intOffSet						= (int) $intOffSet;
		
		// Validando os dados
		if ($arrParametro["intIdUsuario"] <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		if ($intOffSet < 0)		throw new CampoObrigatorioException("OffSet");
		
		// Definindo os valores padrões
		if ($arrParametro["intStatus"] < -1) $arrParametro["intStatus"] = (int) 0;
		if ($arrParametro["intIdGrupo"] < 0) $arrParametro["intIdGrupo"] = (int) 0;
		if (strlen($arrParametro["strDataInicial"]) < 10) $arrParametro["strDataInicial"] = (string) "01/01/2000";
		if (strlen($arrParametro["strDataFinal"]) < 10) $arrParametro["strDataFinal"] = (string) "31/12/2030";
		
		// Convertendo a data do formato DD/MM/YYYY para YYYY-MM-DD
		$arrParametro["strDataInicial"] = Util::formatarDataBanco($arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]   = Util::formatarDataBanco($arrParametro["strDataFinal"]);
		
		// Listando os chamados
		$arrObjChamado = $objCadastroChamado->listarEnviadosPorParametro($arrParametro, $intOffSet, Config::getChamadosPorPagina());
		
		// Populando os chamados
		foreach ($arrObjChamado as $objChamado) $this->popularChamado($objChamado);
		return $arrObjChamado;
	}
	
	/**
	 * Método que conta a quantidade de chamados enviados pelo usuário
	 * 
	 * @access public
	 * @param array $arrParametro
	 * @return int
	 */
	public function quantidadeChamadosEnviadosPorParametro($arrParametro) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$arrParametro["intIdUsuario"]	= (int) @$arrParametro["intIdUsuario"];
		$arrParametro["strDataInicial"]	= (string) @$arrParametro["strDataInicial"];
		$arrParametro["strDataFinal"]	= (string) @$arrParametro["strDataFinal"];
		$arrParametro["intStatus"]		= (int) @$arrParametro["intStatus"];
		$arrParametro["intIdGrupo"]		= (int) @$arrParametro["intIdGrupo"];
		
		// Validando os dados
		if ($arrParametro["intIdUsuario"] <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		
		// Definindo os valores padrões
		if ($arrParametro["intStatus"] < -1) $arrParametro["intStatus"] = (int) 0;
		if ($arrParametro["intIdGrupo"] < 0) $arrParametro["intIdGrupo"] = (int) 0;
		if (strlen($arrParametro["strDataInicial"]) < 10) $arrParametro["strDataInicial"] = (string) "01/01/2000";
		if (strlen($arrParametro["strDataFinal"]) < 10) $arrParametro["strDataFinal"] = (string) "31/12/2030";
		
		// Convertendo a data do formato DD/MM/YYYY para YYYY-MM-DD
		$arrParametro["strDataInicial"] = Util::formatarDataBanco($arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]   = Util::formatarDataBanco($arrParametro["strDataFinal"]);
		
		// Obtendo a quantidade de chamados
		return $objCadastroChamado->quantidadeEnviadosPorParametro($arrParametro);
	}
	
	/**
	 * Método que ira listar os chamados recebidos pelo usuário
	 * 
	 * @access public
	 * @param array $arrParametro
	 * @param int $intOffSet
	 * @return array
	 */
	public function listarChamadosRecebidosPorParametro($arrParametro, $intOffSet = 0) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$arrParametro["intIdUsuario"]			= (int) @$arrParametro["intIdUsuario"];
		$arrParametro["strDataInicial"]			= (string) @$arrParametro["strDataInicial"];
		$arrParametro["strDataFinal"]			= (string) @$arrParametro["strDataFinal"];
		$arrParametro["intStatus"]				= (int) @$arrParametro["intStatus"];
		$arrParametro["intIdGrupo"]				= (int) @$arrParametro["intIdGrupo"];
		$arrParametro["intIdChamado"]			= (int) @$arrParametro["intIdChamado"];
		$arrParametro["strNomeUsuarioOrigem"]	= (string) trim(@$arrParametro["strNomeUsuarioOrigem"]);
		$arrParametro["strNomeUsuarioFechador"]	= (string) trim(@$arrParametro["strNomeUsuarioFechador"]);
		$arrParametro["strDescricaoAssunto"]	= (string) trim(@$arrParametro["strDescricaoAssunto"]);
		$arrParametro["strDescricaoChamado"]	= (string) trim(@$arrParametro["strDescricaoChamado"]);
		$arrParametro["strDescricaoHistorico"]	= (string) trim(@$arrParametro["strDescricaoHistorico"]);
		$intOffSet								= (int) $intOffSet;
		
		// Validando os dados
		if ($arrParametro["intIdUsuario"] <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		if ($intOffSet < 0)		throw new CampoObrigatorioException("OffSet");
		
		// Definindo os valores padrões
		if ($arrParametro["intStatus"] < -1) $arrParametro["intStatus"] = (int) 0;
		if ($arrParametro["intIdGrupo"] < 0) $arrParametro["intIdGrupo"] = (int) 0;
		if (strlen($arrParametro["strDataInicial"]) < 10) $arrParametro["strDataInicial"] = (string) "01/01/2000";
		if (strlen($arrParametro["strDataFinal"]) < 10) $arrParametro["strDataFinal"] = (string) "31/12/2030";
		
		// Convertendo a data do formato DD/MM/YYYY para YYYY-MM-DD
		$arrParametro["strDataInicial"] = Util::formatarDataBanco($arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]   = Util::formatarDataBanco($arrParametro["strDataFinal"]);
		
		// Listando os chamados
		$arrObjChamado = $objCadastroChamado->listarRecebidosPorParametro($arrParametro, $intOffSet, Config::getChamadosPorPagina());
		
		// Populando os chamados
		foreach ($arrObjChamado as $objChamado) $this->popularChamado($objChamado);
		return $arrObjChamado;
	}
	
	/**
	 * Método que conta a quantidade de chamados enviados pelo usuário
	 * 
	 * @access public
	 * @param array $arrParametro
	 * @return int
	 */
	public function quantidadeChamadosRecebidosPorParametro($arrParametro) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$arrParametro["intIdUsuario"]			= (int) @$arrParametro["intIdUsuario"];
		$arrParametro["strDataInicial"]			= (string) @$arrParametro["strDataInicial"];
		$arrParametro["strDataFinal"]			= (string) @$arrParametro["strDataFinal"];
		$arrParametro["intStatus"]				= (int) @$arrParametro["intStatus"];
		$arrParametro["intIdGrupo"]				= (int) @$arrParametro["intIdGrupo"];
		$arrParametro["intIdChamado"]			= (int) @$arrParametro["intIdChamado"];
		$arrParametro["strNomeUsuarioOrigem"]	= (string) trim(@$arrParametro["strNomeUsuarioOrigem"]);
		$arrParametro["strNomeUsuarioFechador"]	= (string) trim(@$arrParametro["strNomeUsuarioFechador"]);
		$arrParametro["strDescricaoAssunto"]	= (string) trim(@$arrParametro["strDescricaoAssunto"]);
		$arrParametro["strDescricaoChamado"]	= (string) trim(@$arrParametro["strDescricaoChamado"]);
		$arrParametro["strDescricaoHistorico"]	= (string) trim(@$arrParametro["strDescricaoHistorico"]);
		
		// Validando os dados
		if ($arrParametro["intIdUsuario"] <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		
		// Definindo os valores padrões
		if ($arrParametro["intStatus"] < -1) $arrParametro["intStatus"] = (int) 0;
		if ($arrParametro["intIdGrupo"] < 0) $arrParametro["intIdGrupo"] = (int) 0;
		if (strlen($arrParametro["strDataInicial"]) < 10) $arrParametro["strDataInicial"] = (string) "01/01/2000";
		if (strlen($arrParametro["strDataFinal"]) < 10) $arrParametro["strDataFinal"] = (string) "31/12/2030";
		
		// Convertendo a data do formato DD/MM/YYYY para YYYY-MM-DD
		$arrParametro["strDataInicial"] = Util::formatarDataBanco($arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]   = Util::formatarDataBanco($arrParametro["strDataFinal"]);
		
		// Obtendo a quantidade de chamados
		return $objCadastroChamado->quantidadeRecebidosPorParametro($arrParametro);
	}
	
	/**
	 * Método que recupera o objeto chamado
	 * 
	 * @access public
	 * @param $intIdChamado
	 * @return Chamado
	 */
	public function procurarChamadoPorIdChamado($intIdChamado) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		
		// Removendo os espaços vazios
		$intIdChamado = (int) $intIdChamado;
		
		// Validando os dados
		if ($intIdChamado <= 0) throw new CampoObrigatorioException("ID do Chamado");
		
		// Recuperando o objeto chamado
		$objChamado = $objCadastroChamado->procurar($intIdChamado);
		
		// Populando os dados do chamado
		$this->popularChamado($objChamado);
		return $objChamado;
	}
	
	/**
	 * Método que recupera o objeto chamado e cadastra o registro de leitura no histórico
	 * 
	 * @access public
	 * @param $intIdChamado
	 * @return Chamado
	 */
	public function detalharChamado($intIdChamado) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		$objCadastroHistorico = new CadastroHistorico($this->objRepositorioHistorico);
		
		// Removendo os espaços vazios
		$intIdChamado = (int) $intIdChamado;
		
		// Validando os dados
		if ($intIdChamado <= 0) throw new CampoObrigatorioException("ID do Chamado");
		
		// Recuperando o objeto chamado
		$objChamado = $objCadastroChamado->procurar($intIdChamado);
		
		// Populando os dados do chamado
		$this->popularChamado($objChamado);
		
		// Verificando se o usuário da leitura é mesmo que abriu o chamado
		$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
		if ($objChamado->getStatusChamado() == 1 || $objChamado->getStatusChamado() == 3) {
			if ($objChamado->getIdUsuarioOrigem() != $intIdUsuario && !$objCadastroHistorico->existePorIdUsuarioPorIdChamadoPorTipo($intIdUsuario, $intIdChamado, 7)) {
				
				// Cadastrando o histórico de leitura
				$intIdHistorico			= 0;
				$intTipoHistorico		= 7; // Tipo de Historico = Leitura
				$strDescricaoHistorico	= "Feita a leitura do chamado.";
				$strDataHistorico		= date("Y-m-d H:i:s");
				$strNomeArquivoAnexo	= "";
				$strCaminhoArquivoAnexo	= "";
				
				// Cadastrando o histórico
				$objHistorico = new Historico($intIdHistorico, $intIdChamado, $intIdUsuario, $intTipoHistorico, $strDescricaoHistorico, $strDataHistorico, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo);
				$objCadastroHistorico->cadastrar($objHistorico);
				
				// Enviando o email da leitura do chamado
				/*
				$objControladorEmail = new ControladorEmail($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
				$strAssuntoEmail = "Chamado No. ". $intIdChamado ." - Leitura do Chamado";
				$objControladorEmail->enviarChamadoPorEmail($intIdChamado, $strAssuntoEmail);
				*/
			}
		}
		return $objChamado;
	}
	
	/**
	 * Método que cadastra encaminha um chamado no repositório
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @param int $intIdAssunto
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdGrupoDestino
	 * @param int $intIdUsuarioDestino
	 * @return void
	 */
	public function encaminharChamado($intIdChamado, $intIdAssunto, $intIdUsuarioOrigem, $intIdGrupoDestino, $intIdUsuarioDestino) {
		// Inicializando os cadastros
		$objCadastroEncaminhamento	= new CadastroEncaminhamento($this->objRepositorioEncaminhamento);
		$objCadastroChamado			= new CadastroChamado($this->objRepositorioChamado);
		$objCadastroHistorico		= new CadastroHistorico($this->objRepositorioHistorico);
		$objCadastroGrupo			= new CadastroGrupo($this->objRepositorioGrupo);
		$objCadastroUsuario			= new CadastroUsuario($this->objRepositorioUsuario);
		$objCadastroAssunto			= new CadastroAssunto($this->objRepositorioAssunto);
		
		// Retirando os espaços vazios
		$intIdChamado			= (int) $intIdChamado;
		$intIdAssunto			= (int) $intIdAssunto;
		$intIdUsuarioOrigem		= (int) $intIdUsuarioOrigem;
		$intIdGrupoDestino		= (int) $intIdGrupoDestino;
		$intIdUsuarioDestino	= (int) $intIdUsuarioDestino;
		
		// Validando os dados
		if ($intIdChamado < 0)			throw new CampoObrigatorioException("ID do Chamado");
		if ($intIdAssunto < 0)			throw new CampoObrigatorioException("ID do Assunto");
		if ($intIdUsuarioOrigem < 0)	throw new CampoObrigatorioException("ID do Usuário de Origem");
		if ($intIdGrupoDestino < 0)		throw new CampoObrigatorioException("ID do Grupo de Destino");
		if ($intIdUsuarioDestino < 0)	throw new CampoObrigatorioException("ID do Usuário de Destino");
		
		// Recuperando o objeto chamado
		$objChamado = $objCadastroChamado->procurar($intIdChamado);
		
		// Verificando se não existe nenhum encaminhamento para este chamado 
		if (!$objCadastroEncaminhamento->existePorIdChamado($intIdChamado)) {
			
			// Definindo os valores do objeto encaminhamento
			$intIdEncaminhamentoAnterior = 0;
			$intIdUsuarioOrigemAnterior = $objChamado->getIdUsuarioOrigem();
			$intIdGrupoDestinoAnterior = $objChamado->getIdGrupoDestino();
			$intIdUsuarioDestinoAnterior = $objChamado->getIdUsuarioDestino();
			$strDataEncaminhamentoAnterior = $objChamado->getDataAbertura();
			
			// Cadastrando o Encaminhamento inicial
			$objEncaminhamentoInicial = new Encaminhamento($intIdEncaminhamentoAnterior, $intIdChamado, $intIdUsuarioOrigemAnterior, $intIdGrupoDestinoAnterior, $intIdUsuarioDestinoAnterior, $strDataEncaminhamentoAnterior);
			$objCadastroEncaminhamento->cadastrar($objEncaminhamentoInicial);
		}
		
		// Cadastrando o encaminhamento
		$intIdEncaminhamento = 0;
		$strDataEncaminhamento = date("Y-m-d H:i:s");
		$objEncaminhamento = new Encaminhamento($intIdEncaminhamento, $intIdChamado, $intIdUsuarioOrigem, $intIdGrupoDestino, $intIdUsuarioDestino, $strDataEncaminhamento);
		$objCadastroEncaminhamento->cadastrar($objEncaminhamento);
		
		//Recuperando o chamado
		$objChamado = $objCadastroChamado->procurar($intIdChamado);
		
		// Calculando o novo prazo com base no Assunto e no Grupo
		$strDataAbertura	= $objChamado->getDataAbertura();
		$strDataPrazoAntiga	= $objChamado->getDataPrazo();
		$strDataPrazoNova	= $this->calcularDataPrazo($intIdGrupoDestino, $intIdAssunto, $strDataAbertura);
		
		// Armazenando o Assunto
		$intIdAssuntoAntigo = $objChamado->getIdAssunto();
		$intIdAssuntoNovo = $intIdAssunto;
		
		// Atualizando os dados no chamado
		$objChamado->setIdGrupoDestino($intIdGrupoDestino);
		$objChamado->setIdUsuarioDestino($intIdUsuarioDestino);
		$objChamado->setDataPrazo($strDataPrazoNova);
		$objChamado->setIdAssunto($intIdAssuntoNovo);
		$objCadastroChamado->atualizar($objChamado);
		
		// Definindo o nome do destinatário
		$strDestinatario = $objCadastroGrupo->procurar($intIdGrupoDestino)->getDescricaoGrupo() ." (Grupo)";
		if ($objChamado->getIdUsuarioDestino() != 0) $strDestinatario = $objCadastroUsuario->procurar($intIdUsuarioDestino)->getNomeUsuario() ." (Individual)";
		
		// Cadastrando o Histórico de Encaminhamento
		$intIdHistorico			= (int) 0;
		$intIdUsuario			= (int) $intIdUsuarioOrigem;
		$intTipoHistorico		= (int) 4; // Tipo de Histórico = Encaminhamento
		$strDescricaoHistorico	= (string) "Chamado encaminhado para ". $strDestinatario .".";
		$strDataHistorico		= (string) date("Y-m-d H:i:s");
		$strNomeArquivoAnexo	= (string) "";
		$strCaminhoArquivoAnexo	= (string) "";
		
		// Verificando se houve alteração do Assunto e acrescentando no Histórico
		if ($intIdAssuntoAntigo != $intIdAssuntoNovo) {
			$objAssuntoAntigo	= $objCadastroAssunto->procurar($intIdAssuntoAntigo);
			$objAssuntoNovo		= $objCadastroAssunto->procurar($intIdAssuntoNovo);
			$strDescricaoHistorico .= "\r\nAssunto alterado de: ". $objAssuntoAntigo->getDescricaoAssunto() ." para: ". $objAssuntoNovo->getDescricaoAssunto();
		}
		
		// Verificando se houve alteração na Data de Prazo e acrescentando no Histórico
		if ($strDataPrazoAntiga != $strDataPrazoNova) {
			$strDescricaoHistorico .= "\r\nData de Prazo alterada de: ". Util::reduzirDataHora(Util::formatarBancoData($strDataPrazoAntiga)) ." para: ". Util::reduzirDataHora(Util::formatarBancoData($strDataPrazoNova));
		}
		
		// Cadastrando o Histórico
		$objHistorico = new Historico($intIdHistorico, $intIdChamado, $intIdUsuario, $intTipoHistorico, $strDescricaoHistorico, $strDataHistorico, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo);
		$objCadastroHistorico->cadastrar($objHistorico);
		
		// Enviando o email do encaminhamento do Chamado
		$objControladorEmail = new ControladorEmail($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
		$strAssuntoEmail = "Chamado No. ". $intIdChamado ." - Chamado Encaminhado";
		$objControladorEmail->enviarChamadoPorEmail($intIdChamado, $strAssuntoEmail);
	}
	
	/**
	 * Método que reclassifica o Assunto ou a Prioridade de um determinado Chamado
	 * 
	 * @access public
	 * @param int $intIdChamado
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdAssunto
	 * @param int $intCodigoPrioridade
	 * @param int $intStatus
	 * @return void
	 */
	public function reclassificarChamado($intIdChamado, $intIdUsuarioOrigem, $intIdAssunto, $intCodigoPrioridade, $intStatus) {
		// Inicializando os cadastros
		$objCadastroChamado = new CadastroChamado($this->objRepositorioChamado);
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		$objCadastroHistorico = new CadastroHistorico($this->objRepositorioHistorico);
		
		// Removendo os espaços vazios
		$intIdChamado					= (int) $intIdChamado;
		$intIdUsuarioOrigem				= (int) $intIdUsuarioOrigem;
		$intIdAssunto					= (int) $intIdAssunto;
		$intCodigoPrioridade			= (int) $intCodigoPrioridade;
		$intStatus					= (int) $intStatus;
		
		// Validando os dados
		if ($intIdChamado <= 0)			throw new CampoObrigatorioException("ID do Chamado");
		if ($intIdUsuarioOrigem <= 0)	throw new CampoObrigatorioException("ID do Usuário");
		if ($intIdAssunto <= 0)			throw new CampoObrigatorioException("ID do Assunto");
		if ($intCodigoPrioridade <= 0)	throw new CampoObrigatorioException("Código da Prioridade");
		if ($intStatus <= 0)	throw new CampoObrigatorioException("Status");
		
		// Armazenando os dados novos e antigos
		$objChamado = $objCadastroChamado->procurar($intIdChamado);
		$intIdAssuntoAntigo			= $objChamado->getIdAssunto();
		$intIdAssuntoNovo			= $intIdAssunto;
		$intCodigoPrioridadeAntigo	= $objChamado->getCodigoPrioridade();
		$intCodigoPrioridadeNovo	= $intCodigoPrioridade;
		$intStatusAntigo		= $objChamado->getStatusChamado();
		$intStatusNovo		= $intStatus;
		
		// Verificando se existe alterações
		if ($intIdAssuntoAntigo == $intIdAssuntoNovo && $intCodigoPrioridadeAntigo == $intCodigoPrioridadeNovo && $intStatusAntigo == $intStatusNovo) {
			throw new Exception("O Assunto, Prioridade e Status informados são os mesmos do chamado.");
		}
		
		// Calculando o novo prazo
		$intIdGrupoDestino	= $objChamado->getIdGrupoDestino();
		$strDataAbertura	= $objChamado->getDataAbertura();
		$strDataPrazoAntiga	= $objChamado->getDataPrazo();
		$strDataPrazoNova	= $this->calcularDataPrazo($intIdGrupoDestino, $intIdAssunto, $strDataAbertura);
		
		// Atualizando o Chamado
		$objChamado->setDataPrazo($strDataPrazoNova);
		$objChamado->setIdAssunto($intIdAssuntoNovo);
		$objChamado->setCodigoPrioridade($intCodigoPrioridadeNovo);
		$objChamado->setStatusChamado($intStatusNovo);
		$objCadastroChamado->atualizar($objChamado);
		
		// Cadastrando o Histórico de Reclassificação
		$intIdHistorico			= (int) 0;
		$intIdUsuario			= (int) $intIdUsuarioOrigem;
		$intTipoHistorico		= (int) 8; // Tipo de Histórico = Reclassificação
		$strDescricaoHistorico	= (string) "Chamado reclassificado:";
		$strDataHistorico		= (string) date("Y-m-d H:i:s");
		$strNomeArquivoAnexo	= (string) "";
		$strCaminhoArquivoAnexo	= (string) "";
		
		// Verificando se houve alteração do Assunto e acrescentando no Histórico
		if ($intIdAssuntoAntigo != $intIdAssuntoNovo) {
			$objAssuntoAntigo	= $objCadastroAssunto->procurar($intIdAssuntoAntigo);
			$objAssuntoNovo		= $objCadastroAssunto->procurar($intIdAssuntoNovo);
			$strDescricaoHistorico .= "\r\nAssunto alterado de: ". $objAssuntoAntigo->getDescricaoAssunto() ." para: ". $objAssuntoNovo->getDescricaoAssunto();
		}
		
		// Verificando se houve alteração na Prioridade e acrescentando no Histórico
		if ($intCodigoPrioridadeAntigo != $intCodigoPrioridadeNovo) {
			$arrPrioridades = Config::getPrioridades();
			$strCodigoPrioridadeAntigo	= $arrPrioridades[$intCodigoPrioridadeAntigo];
			$strCodigoPrioridadeNovo	= $arrPrioridades[$intCodigoPrioridadeNovo];
			$strDescricaoHistorico .= "\r\nPrioridade alterada de: ". $strCodigoPrioridadeAntigo ." para: ". $strCodigoPrioridadeNovo;
		}
		
		// Verificando se houve alteração na Data de Prazo e acrescentando no Histórico
		if ($strDataPrazoAntiga != $strDataPrazoNova) {
			$strDescricaoHistorico .= "\r\nData de Prazo alterada de: ". Util::reduzirDataHora(Util::formatarBancoData($strDataPrazoAntiga)) ." para: ". Util::reduzirDataHora(Util::formatarBancoData($strDataPrazoNova));
		}
		
		// Verificando se houve alteração de Status e acrescentando no Histórico
		if ($intStatusAntigo != $intStatusNovo) {
			$arrStatus = Config::getStatus();
			$strDescricaoHistorico .= "\r\nStatus do Chamado alterado de: ". $arrStatus[$intStatusAntigo] ." para: ". $arrStatus[$intStatusNovo];
		}
		
		// Cadastrando o Histórico
		$objHistorico = new Historico($intIdHistorico, $intIdChamado, $intIdUsuario, $intTipoHistorico, $strDescricaoHistorico, $strDataHistorico, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo);
		$objCadastroHistorico->cadastrar($objHistorico);
		
		// Enviando o email do encaminhamento do Chamado
		$objControladorEmail = new ControladorEmail($this->objRepositorioChamado, $this->objRepositorioAssunto, $this->objRepositorioGrupo, $this->objRepositorioUsuario, $this->objRepositorioSetor, $this->objRepositorioHistorico);
		$strAssuntoEmail = "Chamado No. ". $intIdChamado ." - Chamado Reclassificado";
		$objControladorEmail->enviarChamadoPorEmail($intIdChamado, $strAssuntoEmail);
	}
	
	/**
	 * Método que calcula a data de prazo do chamado com base no calendário do grupo
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdAssunto
	 * @param string $strDataReferencia
	 * @return string
	 */
	public function calcularDataPrazo($intIdGrupo, $intIdAssunto, $strDataReferencia) {
		// Inicializando os cadastros
		$objCadastroHorario = new CadastroHorario($this->objRepositorioHorario);
		$objCadastroAssunto = new CadastroAssunto($this->objRepositorioAssunto);
		$objCadastroFeriado = new CadastroFeriado($this->objRepositorioFeriado);
		
		// Recuperando o objeto Assunto
		$objAssunto = $objCadastroAssunto->procurar($intIdAssunto);
		
		// Inicializando as variáveis
		$intSla = $objAssunto->getSla() * 60; // Convertendo o SLA em segundos
		$intDataAtual = strtotime($strDataReferencia);
		$intDataInicial = $intDataAtual;
		
		do {
			// Se data atual for feriado continuo
			if($objCadastroFeriado->existePorIdGrupoPorDataFeriado($intIdGrupo, date("Y-m-d", $intDataAtual))){
				// Indo para o próximo dia
				$intDataAtual += (24*60*60);
				continue;
			}
			
			// Obtendo as variáveis da data 
			list($intDiaAtual, $intMesAtual, $intAnoAtual, $intDiaSemanaAtual) = explode(" ", date("d m Y w", $intDataAtual));
			
			// Listando todos os horários do grupo no dia da semana específico
			$arrObjHorario = $objCadastroHorario->listarPorIdGrupoPorDiaSemana($intIdGrupo, $intDiaSemanaAtual);
			foreach ($arrObjHorario as $objHorario) {
				// Quebrando os horários
				$arrHoraInicial = explode(":", $objHorario->getInicioHorario());
				$arrHoraFinal = explode(":", $objHorario->getTerminoHorario());
				
				// Convertendo os horários em timestamp
				$intDataInicialAtual = mktime($arrHoraInicial[0], $arrHoraInicial[1], $arrHoraInicial[2], $intMesAtual, $intDiaAtual, $intAnoAtual);
				$intDataFinalAtual = mktime($arrHoraFinal[0], $arrHoraFinal[1], $arrHoraFinal[2], $intMesAtual, $intDiaAtual, $intAnoAtual);
				
				// Verificando se a data de início do turno é menor que a abertura do chamado
				if ($intDataInicialAtual < $intDataInicial) {
					$intDataInicialAtual = $intDataInicial;
				}
				
				// Calculando o tempo restante
				$intTempoRestante = $intDataFinalAtual - $intDataInicialAtual;
				if ($intTempoRestante > 0) {
					if ($intSla > $intTempoRestante) $intSla -= $intTempoRestante;
					else return date("Y-m-d H:i:s", ($intDataInicialAtual + $intSla));
				}
			}
			// Indo para o próximo dia
			$intDataAtual += (24*60*60);
		} while ($intDataAtual < (time() + 365*24*60*60)); // Ficar no loop até no máximo 1 ano
		return $strDataReferencia;
	}
	
	/**
	 * Método que atualiza os demais dados de outros cadastros no objeto chamado
	 * 
	 * @access private
	 * @param Chamado $objChamado
	 * @return void
	 */
	private function popularChamado($objChamado) {
		// Inicializando os cadastros
		$objCadastroAssunto	= new CadastroAssunto($this->objRepositorioAssunto);
		$objCadastroGrupo	= new CadastroGrupo($this->objRepositorioGrupo);
		$objCadastroUsuario	= new CadastroUsuario($this->objRepositorioUsuario);
		$objCadastroSetor	= new CadastroSetor($this->objRepositorioSetor);
		
		// Recuperando os dados
		$objAssunto = $objCadastroAssunto->procurar($objChamado->getIdAssunto());
		$objChamado->setAssunto($objAssunto);
		
		$objUsuarioOrigem = $objCadastroUsuario->procurar($objChamado->getIdUsuarioOrigem());
		$objSetor = $objCadastroSetor->procurar($objUsuarioOrigem->getIdSetor());
		$objUsuarioOrigem->setSetor($objSetor);
		$objChamado->setUsuarioOrigem($objUsuarioOrigem);
		
		if ($objChamado->getIdUsuarioDestino() != 0) {
			$objUsuarioDestino = $objCadastroUsuario->procurar($objChamado->getIdUsuarioDestino());
			$objSetor = $objCadastroSetor->procurar($objUsuarioDestino->getIdSetor());
			$objUsuarioDestino->setSetor($objSetor);
			$objChamado->setUsuarioDestino($objUsuarioDestino);
		}
		
		if ($objChamado->getIdGrupoDestino() != 0) {
			$objGrupoDestino = $objCadastroGrupo->procurar($objChamado->getIdGrupoDestino());
			$objChamado->setGrupoDestino($objGrupoDestino);
		}
		
		if ($objChamado->getIdUsuarioFechador() != 0) {
			$objUsuarioFechador = $objCadastroUsuario->procurar($objChamado->getIdUsuarioFechador());
			$objSetor = $objCadastroSetor->procurar($objUsuarioFechador->getIdSetor());
			$objUsuarioFechador->setSetor($objSetor);
			$objChamado->setUsuarioFechador($objUsuarioFechador);
		}
	}
}